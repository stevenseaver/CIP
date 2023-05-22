<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Admin Dashboard';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['employeeLeaveCount'] = $this->db->count_all_results('leave_list');
        $data['custMessage'] = $this->db->count_all_results('contact_us');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function roleaccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function addRole()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('role', 'role', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        } else {
            $addNewRole = $this->input->post('role');
            $this->db->insert('user_role', ['role' => $addNewRole]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role added!</div>');
            redirect('admin/role');
        }
    }
    //function untuk change access berdasarkan role yang dipilih
    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);
        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">Access changed!</div>');
    }
    //function edit role
    public function editrole()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('id', 'id', 'required|trim');
        $this->form_validation->set_rules('role', 'role', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        } else {
            //read from input input
            $edit_id = $this->input->post('id');
            $edit_role = $this->input->post('role');
            $editedMenu = $this->db->get_where('user_role', array('id' => $edit_id))->row_array();
            // edit DB
            $this->db->where('id', $edit_id);
            $this->db->update('user_role', array('role' => $edit_role));
            $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">Role ' . $editedMenu["role"] . ' edited into ' . $edit_role . '!</div>');
            redirect('admin/role');
        }
    }

    // function untuk delete role
    public function deleterole($itemtoDelete)
    {
        $deleteditem = $this->db->get_where('user_role', array('id' => $itemtoDelete))->row_array();

        //Delete DB
        $this->db->delete('user_role', array('id' => $itemtoDelete));
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Role ' . $deleteditem["role"] . ' deleted!</div>');
        redirect('admin/role');
    }

    public function userManagement()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $this->load->model('Admin_model', 'role_id');
        $data['userdata'] = $this->role_id->getUserRole();
        $data['role'] = $this->db->get('user_role')->result_array();

        // $data['userdata'] = $this->db->get('user')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/user-management', $data);
        $this->load->view('templates/footer');
    }

    public function adduser()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $this->load->model('Admin_model', 'role_id');
        $data['userdata'] = $this->role_id->getUserRole();
        $data['role'] = $this->db->get('user_role')->result_array();
        //form validation rules
        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('nik', 'ERN', 'required|trim|is_unique[user.nik]', [
            'is_unique' => 'This ERN has already been used!'
        ]);
        $this->form_validation->set_rules('noktp', 'ID card number', 'required|trim');
        $this->form_validation->set_rules('dob', 'date of birth', 'required|trim');
        $this->form_validation->set_rules('address', 'address', 'required|trim');
        $this->form_validation->set_rules('email', 'email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already been used!'
        ]);
        $this->form_validation->set_rules('noktp', 'ID card number', 'required|trim');
        $this->form_validation->set_rules('dob', 'date of birth', 'required|trim');
        $this->form_validation->set_rules('hp', 'phone number', 'required|trim|numeric');
        $this->form_validation->set_rules('role_id', 'role', 'required');
        $this->form_validation->set_rules('password1', 'password', 'required|trim|min_length[8]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short! Min. 8 character.'
        ]);
        $this->form_validation->set_rules('password2', 'password', 'required|trim|min_length[8]|matches[password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/user-management', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name', true);
            $email = $this->input->post('email', true);
            $nik = $this->input->post('nik', true);
            $dob = $this->input->post('dob', true);
            $noktp = $this->input->post('noktp', true);
            $hp = $this->input->post('hp', true);
            $role_id = $this->input->post('role_id', true);
            $address = $this->input->post('address');
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

            $data = [
                'name' => htmlspecialchars($name),
                'nik' => htmlspecialchars($nik),
                'email' => htmlspecialchars($email),
                'noktp' => htmlspecialchars($noktp),
                'dob' => htmlspecialchars($dob),
                'phone_number' => htmlspecialchars($hp),
                'address' => htmlspecialchars($address),
                'image' => 'default.jpg',
                'password' => $password,
                'role_id' => $role_id,
                'is_active' => 1,
                'leave_count' => 12,
                'date_created' => time()
            ];
            $this->db->insert('user', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Account successfully created and is active!</div>');
            redirect('admin/usermanagement');
        }
    }
    //blank page
    public function blankpage()
    {
        $this->load->view('admin/blank');
    }

    public function toggleActive($usertoToggle, $is_active, $name)
    {
        if ($is_active == 1) {
            $this->db->set('is_active', 0);
            $this->db->where('id', $usertoToggle);
            $this->db->update('user');
        } else if ($is_active == 0) {
            $this->db->set('is_active', 1);
            $this->db->where('id', $usertoToggle);
            $this->db->update('user');
        }
        $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">' . urldecode($name) . ' status changed!</div>');
        redirect('admin/usermanagement');
    }

    // public function deleteuser($itemtoDelete, $name)
    public function deleteuser()
    {
        $itemtoDelete = $this->input->post('delete_id');
        $name = $this->input->post('delete_name');

        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        if ($itemtoDelete == $data['user']['id']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Deleting logged in user are forbidden! </div>');
            redirect('admin/usermanagement');
        } else {
            $this->db->delete('user', array('id' => $itemtoDelete));
            $this->db->delete('cart', array('customer' => $itemtoDelete));
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert"> ' . urldecode($name) . ' deleted!</div>');
            redirect('admin/usermanagement');
        }
    }

    public function settings(){
        echo 'hello';
    }
}
