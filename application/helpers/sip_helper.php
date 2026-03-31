<?php
function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('nik')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $ci->db->get_where('user_access_menu', ['role_id' => $role_id, 'menu_id' => $menu_id]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}

function is_logged_in_no_authroized()
{
    $ci = get_instance();
    if (!$ci->session->userdata('nik')) {
        redirect('auth');
    } else {
        
    }
}

//check wether the checkbox is checked
function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);

    $result = $ci->db->get('user_access_menu');
    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function load_cart()
{
    $ci = get_instance();

    $result = $ci->db->get('cart')->result_array();
    return $result;
}

// function log_audit($table_name, $reference, $action, $old_value = null, $new_value = null) {
function log_audit($table_name, $reference, $action) {
    $ci = get_instance();
    $ci->db->insert('audit_trail', [
        'user_id'    => $ci->session->userdata('user_id'),
        'username'   => $ci->session->userdata('username'),
        'action'     => strtoupper($action),
        'table_name' => $table_name,
        'reference'  => $reference,
        // 'old_value'  => $old_value ? json_encode($old_value) : null,
        // 'new_value'  => $new_value ? json_encode($new_value) : null,
        'ip_address' => $ci->input->ip_address(),
    ]);
}
