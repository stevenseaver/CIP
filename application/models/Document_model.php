<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Document_model
 *
 * Handles all data operations for the QMS Document Control system.
 * Design principles:
 *   - No physical deletes on doc_versions (immutable audit trail)
 *   - Single "current" version enforced at DB level (trigger) + model level
 *   - All mutations return ['success' => bool, 'data'/'error' => mixed]
 */
class Document_model extends CI_Model
{
    // Allowed real MIME types (verified via finfo, not $_FILES['type'])
    private static $ALLOWED_MIME = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    ];

    // FIX: class constants with array values require PHP 5.6+. Defining as
    // a static property avoids any edge-case opcode cache issues on PHP 7.4
    // shared hosts that occasionally mis-parse typed class constants.
    private static $MAX_FILE_BYTES = 20971520; // 20 MB

    private static $EXT_MAP = [
        'application/pdf'                                                                => 'pdf',
        'application/msword'                                                             => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'       => 'docx',
        'application/vnd.ms-excel'                                                       => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'             => 'xlsx',
        'application/vnd.ms-powerpoint'                                                  => 'ppt',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation'     => 'pptx',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    // ================================================================
    // CATEGORIES
    // ================================================================

    public function get_categories($active_only = true)
    {
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        $this->db->order_by('code', 'ASC');
        return $this->db->get('doc_categories')->result_array();
    }

    public function get_category($id)
    {
        $row = $this->db->get_where('doc_categories', ['id' => (int) $id])->row_array();
        return $row ? $row : null;
    }

    public function create_category($data)
    {
        if (empty($data['code']) || empty($data['name'])) {
            return ['success' => false, 'error' => 'Code and name are required.'];
        }

        $code = strtoupper(trim($data['code']));
        $exists = $this->db->get_where('doc_categories', ['code' => $code])->num_rows();
        if ($exists) {
            return ['success' => false, 'error' => 'Category code already exists.'];
        }

        $username = $this->session->userdata('username');
        if (empty($username)) {
            return ['success' => false, 'error' => 'Session error: username not found.'];
        }

        $insert = [
            'code'        => $code,
            'name'        => trim($data['name']),
            'description' => isset($data['description']) ? trim($data['description']) : '',
            'is_active'   => 1,
            'created_by'  => $username,
        ];

        $ok = $this->db->insert('doc_categories', $insert);
        if (!$ok) {
            $err = $this->db->error();
            log_message('error', 'Document_model::create_category DB error: ' . json_encode($err));
            return ['success' => false, 'error' => 'Database insert failed. Check error logs.'];
        }
        return ['success' => true, 'data' => $this->db->insert_id()];
    }

    public function update_category($id, $data)
    {
        $id      = (int) $id;
        $current = $this->get_category($id);
        if (!$current) {
            return ['success' => false, 'error' => 'Category not found.'];
        }

        $code = strtoupper(trim($data['code']));

        // Uniqueness check excluding self
        $this->db->where('code', $code)->where('id !=', $id);
        if ($this->db->count_all_results('doc_categories') > 0) {
            return ['success' => false, 'error' => 'Category code already used by another record.'];
        }

        $update = [
            'code'        => $code,
            'name'        => trim($data['name']),
            'description' => isset($data['description']) ? trim($data['description']) : '',
            'is_active'   => isset($data['is_active']) ? (int) $data['is_active'] : 1,
        ];

        $this->db->where('id', $id)->update('doc_categories', $update);

        if ($this->db->affected_rows() < 0) { // 0 = no change (valid), -1 = error
            $err = $this->db->error();
            log_message('error', 'Document_model::update_category DB error: ' . json_encode($err));
            return ['success' => false, 'error' => 'Database update failed.'];
        }

        return ['success' => true, 'data' => $current]; // return old state for audit
    }

    // ================================================================
    // DOCUMENT MASTERS
    // ================================================================

    public function get_masters_paginated($filters = [], $limit = 15, $offset = 0)
    {
        // ── Data query
        $this->db->select('dm.*, dc.code AS category_code, dc.name AS category_name,
                           dv.version AS current_version, dv.status AS current_status,
                           dv.effective_date, dv.id AS current_version_id')
                 ->from('doc_masters dm')
                 ->join('doc_categories dc', 'dc.id = dm.category_id', 'left')
                 ->join('doc_versions dv', 'dv.doc_master_id = dm.id AND dv.is_current = 1', 'left');

        $this->_apply_filters($filters);

        $this->db->order_by('dm.doc_number', 'ASC')->limit((int) $limit, (int) $offset);
        $rows = $this->db->get()->result_array();

        // ── Count query (same filters, no limit)
        $this->db->select('COUNT(*) AS cnt')
                 ->from('doc_masters dm')
                 ->join('doc_categories dc', 'dc.id = dm.category_id', 'left')
                 ->join('doc_versions dv', 'dv.doc_master_id = dm.id AND dv.is_current = 1', 'left');

        $this->_apply_filters($filters);
        $count_row = $this->db->get()->row();
        $total = $count_row ? (int) $count_row->cnt : 0;

        return ['rows' => $rows, 'total' => $total];
    }

    // FIX: extracted to private method so we can safely call it twice
    // without accidentally leaving stale where clauses on the query builder.
    private function _apply_filters($filters)
    {
        if (!empty($filters['search'])) {
            $s = $this->db->escape_like_str($filters['search']);
            $this->db->group_start()
                     ->like('dm.doc_number', $s)
                     ->or_like('dm.title', $s)
                     ->or_like('dc.name', $s)
                     ->group_end();
        }
        if (!empty($filters['category_id'])) {
            $this->db->where('dm.category_id', (int) $filters['category_id']);
        }
        // is_active can legitimately be '0' — use isset + !== ''
        if (isset($filters['is_active']) && $filters['is_active'] !== '' && $filters['is_active'] !== false) {
            $this->db->where('dm.is_active', (int) $filters['is_active']);
        }
        if (!empty($filters['status'])) {
            $this->db->where('dv.status', $filters['status']);
        }
    }

    public function get_master_with_versions($id)
    {
        $id     = (int) $id;
        $master = $this->db->select('dm.*, dc.code AS category_code, dc.name AS category_name')
                           ->from('doc_masters dm')
                           ->join('doc_categories dc', 'dc.id = dm.category_id', 'left')
                           ->where('dm.id', $id)
                           ->get()
                           ->row_array();

        if (!$master) {
            return null;
        }

        $master['versions'] = $this->db
            ->where('doc_master_id', $id)
            ->order_by('id', 'DESC')
            ->get('doc_versions')
            ->result_array();

        return $master;
    }

    public function create_master($data)
    {
        if (empty($data['doc_number']) || empty($data['title']) || empty($data['category_id'])) {
            return ['success' => false, 'error' => 'Document number, title and category are required.'];
        }

        $doc_number = strtoupper(trim($data['doc_number']));

        $exists = $this->db->get_where('doc_masters', ['doc_number' => $doc_number])->num_rows();
        if ($exists) {
            return ['success' => false, 'error' => 'Document number already exists.'];
        }

        $username = $this->session->userdata('username');
        if (empty($username)) {
            return ['success' => false, 'error' => 'Session error: username not found.'];
        }

        $insert = [
            'doc_number'      => $doc_number,
            'title'           => trim($data['title']),
            'category_id'     => (int) $data['category_id'],
            'department'      => isset($data['department'])    ? trim($data['department'])    : '',
            'process_owner'   => isset($data['process_owner']) ? trim($data['process_owner']) : '',
            'retention_years' => isset($data['retention_years']) ? (int) $data['retention_years'] : 3,
            'is_active'       => 1,
            'created_by'      => $username,
        ];

        $ok = $this->db->insert('doc_masters', $insert);
        if (!$ok) {
            $err = $this->db->error();
            log_message('error', 'Document_model::create_master DB error: ' . json_encode($err));
            return ['success' => false, 'error' => 'Database insert failed. Check error logs.'];
        }
        return ['success' => true, 'data' => $this->db->insert_id()];
    }

    public function update_master($id, $data)
    {
        $id      = (int) $id;
        $current = $this->db->get_where('doc_masters', ['id' => $id])->row_array();
        if (!$current) {
            return ['success' => false, 'error' => 'Document not found.'];
        }

        $doc_number = strtoupper(trim($data['doc_number']));

        $this->db->where('doc_number', $doc_number)->where('id !=', $id);
        if ($this->db->count_all_results('doc_masters') > 0) {
            return ['success' => false, 'error' => 'Document number already used.'];
        }

        $update = [
            'doc_number'      => $doc_number,
            'title'           => trim($data['title']),
            'category_id'     => (int) $data['category_id'],
            'department'      => isset($data['department'])    ? trim($data['department'])    : '',
            'process_owner'   => isset($data['process_owner']) ? trim($data['process_owner']) : '',
            'retention_years' => isset($data['retention_years']) ? (int) $data['retention_years'] : 3,
            'is_active'       => isset($data['is_active']) ? (int) $data['is_active'] : 1,
        ];

        $this->db->where('id', $id)->update('doc_masters', $update);
        return ['success' => true, 'data' => $current]; // old state for audit
    }

    // ================================================================
    // DOCUMENT VERSIONS
    // ================================================================

    public function upload_version($master_id, $post, $file)
    {
        $master_id = (int) $master_id;

        // 1. Master must exist and be active
        $master = $this->db->get_where('doc_masters', [
            'id'        => $master_id,
            'is_active' => 1,
        ])->row_array();

        if (!$master) {
            return ['success' => false, 'error' => 'Document master not found or inactive.'];
        }

        // 2. Version format
        // FIX: use isset() not ?? — $post values from CI3 input->post(null,true)
        // may be empty string rather than null for missing optional fields.
        $version = isset($post['version']) ? trim($post['version']) : '';
        if (!preg_match('/^\d+\.\d+$/', $version)) {
            return ['success' => false, 'error' => 'Version must follow format X.Y (e.g. 1.0, 2.3).'];
        }

        // 3. Version must not already exist for this master
        $dup = $this->db->get_where('doc_versions', [
            'doc_master_id' => $master_id,
            'version'       => $version,
        ])->num_rows();
        if ($dup) {
            return ['success' => false, 'error' => "Version {$version} already exists for this document."];
        }

        // 4. Version must be higher than current
        $current_ver = $this->db->get_where('doc_versions', [
            'doc_master_id' => $master_id,
            'is_current'    => 1,
        ])->row_array();

        if ($current_ver && version_compare($version, $current_ver['version'], '<=')) {
            return [
                'success' => false,
                'error'   => "New version ({$version}) must be higher than current ({$current_ver['version']}).",
            ];
        }

        // 5. Validate the file
        $file_error = $this->_validate_file($file);
        if ($file_error) {
            return ['success' => false, 'error' => $file_error];
        }

        // 6. Store file on disk
        $store = $this->_store_file($file, $master['doc_number']);
        if (!$store['success']) {
            return $store;
        }

        // 7. Persist to DB inside a transaction
        $version_desc   = isset($post['version_desc'])   ? trim($post['version_desc'])   : '';
        $effective_date = isset($post['effective_date']) && $post['effective_date'] !== ''
                          ? $post['effective_date'] : null;

        $insert = [
            'doc_master_id'  => $master_id,
            'version'        => $version,
            'version_desc'   => $version_desc,
            'file_name'      => $store['original_name'],
            'stored_name'    => $store['stored_name'],
            'file_path'      => $store['file_path'],
            'file_size'      => $store['file_size'],
            'mime_type'      => $store['mime_type'],
            'checksum'       => $store['checksum'],
            'status'         => 'active',
            'effective_date' => $effective_date,
            'is_current'     => 1,
            'uploaded_by'    => $this->session->userdata('username'),
        ];

        $this->db->trans_start();
        $this->db->insert('doc_versions', $insert);
        $new_id = $this->db->insert_id();
        $this->db->trans_complete();

        // FIX: check trans_status() AFTER trans_complete(), not before.
        // Also assign it to a variable first — calling it twice can return
        // different values if CI resets the flag internally.
        $trans_ok = $this->db->trans_status();
        if ($trans_ok === false) {
            @unlink(FCPATH . $store['file_path'] . $store['stored_name']);
            $err = $this->db->error();
            log_message('error', 'Document_model::upload_version trans failed: ' . json_encode($err));
            return ['success' => false, 'error' => 'Database transaction failed. File has been removed.'];
        }

        $insert['id'] = $new_id;
        return [
            'success'  => true,
            'data'     => $insert,
            'previous' => $current_ver ? $current_ver : null,
        ];
    }

    public function get_versions($master_id)
    {
        return $this->db
            ->where('doc_master_id', (int) $master_id)
            ->order_by('id', 'DESC')
            ->get('doc_versions')
            ->result_array();
    }

    public function get_version($version_id)
    {
        $row = $this->db->get_where('doc_versions', ['id' => (int) $version_id])->row_array();
        return $row ? $row : null;
    }

    public function log_download($version_id)
    {
        $this->db->insert('doc_download_logs', [
            'doc_version_id' => (int) $version_id,
            'downloaded_by'  => $this->session->userdata('username'),
            'ip_address'     => $this->input->ip_address(),
        ]);
    }

    // ================================================================
    // PRIVATE HELPERS
    // ================================================================

    private function _validate_file($file)
    {
        // FIX: check error code first — on some PHP configs tmp_name is set
        // even when there is an upload error, leading to finfo crashing.
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            $codes = [
                UPLOAD_ERR_INI_SIZE   => 'File exceeds server upload_max_filesize limit.',
                UPLOAD_ERR_FORM_SIZE  => 'File exceeds form MAX_FILE_SIZE.',
                UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded.',
                UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Server temporary folder is missing.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION  => 'Upload blocked by a PHP extension.',
            ];
            $code = isset($file['error']) ? (int) $file['error'] : -1;
            return isset($codes[$code]) ? $codes[$code] : 'Unknown upload error (code ' . $code . ').';
        }

        if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return 'Invalid upload — file origin could not be verified.';
        }

        if ($file['size'] > self::$MAX_FILE_BYTES) {
            return 'File exceeds maximum allowed size of 20 MB.';
        }

        // Detect MIME from actual file content, not the browser-supplied type
        if (!function_exists('finfo_open')) {
            // Fallback if fileinfo extension is somehow disabled
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed_ext = ['pdf','doc','docx','xls','xlsx','ppt','pptx'];
            if (!in_array($ext, $allowed_ext, true)) {
                return 'File extension not allowed.';
            }
            return null;
        }

        $finfo     = new finfo(FILEINFO_MIME_TYPE);
        $real_mime = $finfo->file($file['tmp_name']);

        if (!in_array($real_mime, self::$ALLOWED_MIME, true)) {
            return 'File type not allowed (' . $real_mime . '). Permitted: PDF, Word, Excel, PowerPoint.';
        }

        return null; // OK
    }

    private function _store_file($file, $doc_number)
    {
        // Build year/month sub-directory for manageable folder sizes
        $rel_dir    = 'uploads/documents/' . date('Y') . '/' . date('m') . '/';
        $upload_dir = FCPATH . $rel_dir;

        if (!is_dir($upload_dir)) {
            // FIX: mkdir with recursive=true can still fail silently on permission errors.
            // Check again after the call and log clearly.
            if (!mkdir($upload_dir, 0755, true)) {
                log_message('error', 'Document_model::_store_file cannot create dir: ' . $upload_dir);
                return ['success' => false, 'error' => 'Upload directory could not be created. Check server permissions.'];
            }
        }

        if (!is_writable($upload_dir)) {
            log_message('error', 'Document_model::_store_file dir not writable: ' . $upload_dir);
            return ['success' => false, 'error' => 'Upload directory is not writable. Check server permissions.'];
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime  = $finfo->file($file['tmp_name']);
        $ext   = isset(self::$EXT_MAP[$mime]) ? self::$EXT_MAP[$mime] : 'bin';

        // Safe, collision-resistant filename: DOCNUM_YYYYMMDDHHIISS_RAND.ext
        $safe_num   = preg_replace('/[^A-Z0-9\-]/', '', strtoupper($doc_number));
        $rand_hex   = bin2hex(random_bytes(4));
        $stored     = $safe_num . '_' . date('YmdHis') . '_' . $rand_hex . '.' . $ext;
        $dest       = $upload_dir . $stored;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            log_message('error', 'Document_model::_store_file move_uploaded_file failed. dest=' . $dest);
            return ['success' => false, 'error' => 'Failed to save uploaded file on server.'];
        }

        return [
            'success'       => true,
            'original_name' => basename($file['name']),
            'stored_name'   => $stored,
            'file_path'     => $rel_dir,
            'file_size'     => (int) $file['size'],
            'mime_type'     => $mime,
            'checksum'      => hash_file('sha256', $dest),
        ];
    }
}
