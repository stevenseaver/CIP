<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HR extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'User Leave';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get leave type by combining database table leave_list and leave_type
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('hr/leave', $data);
        $this->load->view('templates/footer');
    }

    public function approve($nik, $start, $finish)
    {
        //send message
        $this->session->set_flashdata('approval', '<div class="alert alert-success" role="alert">Request approved!</div>');

        $this->db->set('status', 1);
        $array = array('user_nik' => $nik,  'start_date' => $start, 'finish_date' => $finish);
        $this->db->where($array);
        $this->db->update('leave_list');

        redirect('hr');
    }

    public function decline($nik, $start, $finish)
    {
        //send message
        $this->session->set_flashdata('approval', '<div class="alert alert-danger" role="alert">Request declined!</div>');

        $this->db->set('status', 2);
        $array = array('user_nik' => $nik,  'start_date' => $start, 'finish_date' => $finish);
        $this->db->where($array);
        $this->db->update('leave_list');

        redirect('hr');
    }
    //load employee list
    public function employee()
    {
        $data['title'] = 'Employee List';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $this->load->model('Admin_model', 'role_id');
        $data['userdata'] = $this->role_id->getEmployeeRole();
        $data['role'] = $this->db->get('user_role')->result_array();

        // $data['userdata'] = $this->db->get('user')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('hr/list', $data);
        $this->load->view('templates/footer');
    }

    public function addEmployee()
    {
        $data['title'] = 'Employee List';
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
            $role = $this->input->post('role_id', true);
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
                'role_id' => $role,
                'is_active' => 1,
                'leave_count' => 12,
                'date_created' => time()
            ];
            $this->db->insert('user', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Account for ' . $name . ' successfully created and is active!</div>');
            redirect('hr/employee');
        }
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
        redirect('hr/employee');
    }

    // public function deleteuser($itemtoDelete, $name)
    public function deleteEmployee()
    {
        $itemtoDelete = $this->input->post('delete_id');
        $name = $this->input->post('delete_name');

        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        if ($itemtoDelete == $data['user']['id']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Deleting logged in user are forbidden! </div>');
            redirect('hr/employee');
        } else {
            $this->db->delete('user', array('id' => $itemtoDelete));
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert"> ' . $name . ' deleted!</div>');
            redirect('hr/employee');
        }
    }
}
