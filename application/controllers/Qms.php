<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Qms extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Audit_model',    'audit');
        $this->load->model('Document_model', 'docmodel');

        // FIX: is_logged_in() must NOT redirect on AJAX — it outputs HTML
        // which corrupts the JSON response and causes a 500 on the client side.
        // Check session manually here; AJAX endpoints return JSON 401 instead.
        if ($this->input->is_ajax_request()) {
            if (!$this->session->userdata('nik')) {
                $this->_json(['success' => false, 'error' => 'Session expired. Please log in again.'], 401);
                exit;
            }
        } else {
            is_logged_in(); // normal redirect for page views is fine
        }
    }

    // ────────────────────────────────────────────────────────────────
    // PAGE VIEWS
    // ────────────────────────────────────────────────────────────────

    public function document_control()
    {
        $data['title']      = 'Document Control';
        $data['user']       = $this->db->get_where('user', [
            'nik' => $this->session->userdata('nik'),
        ])->row_array();
        $data['categories'] = $this->docmodel->get_categories();

        $this->load->view('templates/header',     $data);
        $this->load->view('templates/sidebar',    $data);
        $this->load->view('templates/topbar',     $data);
        $this->load->view('qms/document_control', $data);
        $this->load->view('templates/footer');
    }

    public function document_structure()
    {
        $data['title'] = 'Document Structure';
        $data['user']  = $this->db->get_where('user', [
            'nik' => $this->session->userdata('nik'),
        ])->row_array();

        $this->load->view('templates/header',        $data);
        $this->load->view('templates/sidebar',       $data);
        $this->load->view('templates/topbar',        $data);
        $this->load->view('qms/document_structure',  $data);
        $this->load->view('templates/footer');
    }

    // ────────────────────────────────────────────────────────────────
    // AJAX – DOCUMENT LIST  (server-side DataTable)
    // ────────────────────────────────────────────────────────────────

    public function ajax_doc_list()
    {
        $this->_require_ajax();

        // FIX: CI3 input->post() returns FALSE (not NULL) for missing keys,
        // so use explicit isset/ternary instead of ?? operator throughout.
        $raw_search = $this->input->post('search');
        $filters = [
            'search'      => ($raw_search && is_array($raw_search) && isset($raw_search['value']))
                                ? $raw_search['value']        // DataTables sends search[value]
                                : (is_string($raw_search) ? $raw_search : ''),
            'category_id' => $this->input->post('category_id') ?: '',
            'is_active'   => $this->input->post('is_active'),   // may be '0', keep as-is
            'status'      => $this->input->post('status')  ?: '',
        ];

        $length = $this->input->post('length');
        $start  = $this->input->post('start');
        $limit  = ($length !== false && (int) $length > 0) ? (int) $length : 15;
        $offset = ($start  !== false && (int) $start  > 0) ? (int) $start  : 0;

        $result = $this->docmodel->get_masters_paginated($filters, $limit, $offset);

        $this->_json([
            'draw'            => (int) $this->input->post('draw'),
            'recordsTotal'    => $result['total'],
            'recordsFiltered' => $result['total'],
            'data'            => $result['rows'],
        ]);
    }

    // ────────────────────────────────────────────────────────────────
    // AJAX – GET SINGLE MASTER
    // ────────────────────────────────────────────────────────────────

    public function ajax_doc_master_get($id)
    {
        $this->_require_ajax();
        $master = $this->docmodel->get_master_with_versions((int) $id);
        if (!$master) {
            $this->_json(['success' => false, 'error' => 'Record not found.']);
            return;
        }
        $this->_json(['success' => true, 'data' => $master]);
    }

    // ────────────────────────────────────────────────────────────────
    // AJAX – SAVE MASTER  (create or update)
    // ────────────────────────────────────────────────────────────────

    public function ajax_doc_master_save()
    {
        $this->_require_ajax('POST');

        $id   = (int) $this->input->post('id');
        $post = $this->input->post(null, true); // XSS-cleaned full POST array

        if ($id > 0) {
            $result = $this->docmodel->update_master($id, $post);
            if ($result['success']) {
                $after = $this->docmodel->get_master_with_versions($id);
                $this->audit->log_audit(
                    'doc_masters', $id, $after['doc_number'],
                    'UPDATE', $result['data'], $after
                );
            }
        } else {
            $result = $this->docmodel->create_master($post);
            if ($result['success']) {
                $new_id = (int) $result['data'];
                $after  = $this->docmodel->get_master_with_versions($new_id);
                $this->audit->log_audit(
                    'doc_masters', $new_id, $after['doc_number'],
                    'CREATE', null, $after
                );
            }
        }

        $this->_json($result);
    }

    // ────────────────────────────────────────────────────────────────
    // AJAX – UPLOAD NEW VERSION
    // ────────────────────────────────────────────────────────────────

    public function ajax_doc_upload()
    {
        $this->_require_ajax('POST');

        $master_id = (int) $this->input->post('master_id');
        if ($master_id < 1) {
            $this->_json(['success' => false, 'error' => 'Invalid document ID.']);
            return;
        }

        // FIX: check $_FILES directly — CI3 input library does not expose files
        if (empty($_FILES['document']['tmp_name'])) {
            $this->_json(['success' => false, 'error' => 'No file received.']);
            return;
        }

        $post   = $this->input->post(null, true);
        $result = $this->docmodel->upload_version($master_id, $post, $_FILES['document']);

        if ($result['success']) {
            $master = $this->docmodel->get_master_with_versions($master_id);
            $this->audit->log_audit(
                'doc_versions',
                $result['data']['id'],
                $master['doc_number'] . ' v' . $result['data']['version'],
                'UPLOAD',
                isset($result['previous']) ? $result['previous'] : null,
                $result['data']
            );
        }

        $this->_json($result);
    }

    // ────────────────────────────────────────────────────────────────
    // AJAX – VERSION HISTORY
    // ────────────────────────────────────────────────────────────────

    public function ajax_doc_versions($master_id)
    {
        $this->_require_ajax();
        $versions = $this->docmodel->get_versions((int) $master_id);
        $this->_json(['success' => true, 'data' => $versions]);
    }

    // ────────────────────────────────────────────────────────────────
    // DOWNLOAD  (streamed, tracked)
    // ────────────────────────────────────────────────────────────────

    public function ajax_doc_download($version_id)
    {
        // Not an AJAX endpoint — browser navigates here directly for download
        $version = $this->docmodel->get_version((int) $version_id);
        if (!$version) {
            show_404();
            return;
        }

        $full_path = FCPATH . $version['file_path'] . $version['stored_name'];
        if (!file_exists($full_path)) {
            show_error('File not found on server.', 404);
            return;
        }

        $this->docmodel->log_download((int) $version_id);

        $master = $this->docmodel->get_master_with_versions((int) $version['doc_master_id']);
        $this->audit->log_audit(
            'doc_versions',
            $version_id,
            ($master ? $master['doc_number'] : '') . ' v' . $version['version'],
            'DOWNLOAD',
            null,
            ['downloaded_by' => $this->session->userdata('username')]
        );

        $this->load->helper('download');
        force_download($version['file_name'], file_get_contents($full_path));
        exit; // FIX: prevent any CI3 post-output after force_download
    }

    // ────────────────────────────────────────────────────────────────
    // AJAX – CATEGORIES
    // ────────────────────────────────────────────────────────────────

    public function ajax_cat_list()
    {
        $this->_require_ajax();
        $cats = $this->docmodel->get_categories(false);
        $this->_json(['success' => true, 'data' => $cats]);
    }

    public function ajax_cat_get($id)
    {
        $this->_require_ajax();
        $cat = $this->docmodel->get_category((int) $id);
        if (!$cat) {
            $this->_json(['success' => false, 'error' => 'Not found.']);
            return;
        }
        $this->_json(['success' => true, 'data' => $cat]);
    }

    public function ajax_cat_save()
    {
        $this->_require_ajax('POST');

        $id   = (int) $this->input->post('id');
        $post = $this->input->post(null, true);

        if ($id > 0) {
            $result = $this->docmodel->update_category($id, $post);
            if ($result['success']) {
                $after = $this->docmodel->get_category($id);
                $this->audit->log_audit(
                    'doc_categories', $id, $after['code'],
                    'UPDATE', $result['data'], $after
                );
            }
        } else {
            $result = $this->docmodel->create_category($post);
            if ($result['success']) {
                $new_id = (int) $result['data'];
                $after  = $this->docmodel->get_category($new_id);
                $this->audit->log_audit(
                    'doc_categories', $new_id, $after['code'],
                    'CREATE', null, $after
                );
            }
        }

        $this->_json($result);
    }

    // ────────────────────────────────────────────────────────────────
    // PRIVATE HELPERS
    // ────────────────────────────────────────────────────────────────

    /**
     * Output JSON and stop all further CI3 output.
     *
     * FIX: The original used set_output() which lets CI3 append profiler
     * HTML, session cookies, and other output AFTER the JSON — corrupting
     * the response and causing parse errors / 500s on the client.
     * We bypass the output class entirely and use header() + echo + exit.
     */
    private function _json($data, $status = 200)
    {
        // Clear any buffered output that might be sitting in CI3's output class
        // (e.g. from a partially-rendered view or a stray var_dump left in)
        if (ob_get_level() > 0) {
            ob_end_clean();
        }

        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        header('X-Content-Type-Options: nosniff');
        // Prevent CI3 from appending profiler or session output after we exit
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Gate: only allow proper AJAX requests through.
     *
     * FIX: The original called show_error() on failure, which outputs an HTML
     * page. On AJAX calls this HTML gets treated as the JSON body, causing a
     * parse error on the client even though the actual operation may have
     * succeeded. We now always respond with JSON here.
     */
    private function _require_ajax($method = 'GET')
    {
        if (!$this->input->is_ajax_request()) {
            $this->_json(['success' => false, 'error' => 'Direct access not allowed.'], 403);
        }
        if ($method === 'POST' && $this->input->server('REQUEST_METHOD') !== 'POST') {
            $this->_json(['success' => false, 'error' => 'Method not allowed.'], 405);
        }
    }
}
