<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Audit_model extends CI_Model
{
    // function log_audit($table_name, $reference, $action, $state_before, $state_after) {
    // // public function log_audit($table_name, $reference, $action) {
    //     $ci = get_instance();
    //     $ci->db->insert('audit_trail', [
    //         'user_id'    => $ci->session->userdata('user_id'),
    //         'username'   => $ci->session->userdata('username'),
    //         'action'     => strtoupper($action),
    //         'table_name' => $table_name,
    //         'reference'  => $reference,
    //         'state_before'  => $state_before ? json_encode($state_before) : null,
    //         'state_after'  => $state_after ? json_encode($state_after) : null,
    //         'ip_address' => $ci->input->ip_address(),
    //     ]);
    // }
    public function log_audit($table_name, $row, $reference, $action, $state_before, $state_after) {
        // Validate required parameters
        if (empty($table_name) || empty($row) || empty($reference) || empty($action)) {
            log_message('error', 'Audit_model::log_audit - Missing required parameters: table_name, reference, or action.');
            return false;
        }

        $ci = get_instance();

        // Ensure session data exists
        $user_id  = $ci->session->userdata('user_id');
        $username = $ci->session->userdata('username');

        if (empty($user_id) || empty($username)) {
            log_message('error', 'Audit_model::log_audit - Missing session data: user_id or username.');
            return false;
        }

        $data = [
            'user_id'    => $user_id,
            'username'   => $username,
            'action'     => strtoupper($action),
            'table_name' => $table_name,
            'row' => $row,
            'reference'  => $reference,
            'state_before' => is_array($state_before) ? json_encode($state_before) : $state_before,
            'state_after'  => is_array($state_after)  ? json_encode($state_after)  : $state_after,
            'ip_address' => $ci->input->ip_address(),
        ];

        try {
            $inserted = $ci->db->insert('audit_trail', $data);

            if (!$inserted) {
                $db_error = $ci->db->error();
                log_message('error', 'Audit_model::log_audit - Insert failed. DB Error: ' . json_encode($db_error));
                return false;
            }

            return $ci->db->insert_id();

        } catch (Exception $e) {
            log_message('error', 'Audit_model::log_audit - Exception: ' . $e->getMessage());
            return false;
        }
    }
}
