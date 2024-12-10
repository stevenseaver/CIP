<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        //periode tracker
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $periode_id = $this->input->get('name');

        if($this->input->get('start_date') == null){
            //show data in current periode
            $current_time = time();
            $current_year = date('Y', $current_time);
            
            $data['periode'] = $this->db->get_where('periode_counter', ['year <=' => $current_year])->result_array();
            
            foreach($data['periode'] as $per) :
                if ($current_time >= $per['start_date'] and $current_time <= $per['end_date']){
                    $data['current_periode'] = $per['period'];
                    $data['start_date'] = $per['start_date'];
                    $data['end_date'] = $per['end_date'];
                };
            endforeach;
            
            $start_date = $data['start_date'];
            $end_date = $data['end_date'];
        } else {
            //get data parameters
            $current_time = time();
            $current_year = date('Y', $current_time);
            
            $data['periode'] = $this->db->get_where('periode_counter', ['year <=' => $current_year])->result_array();
            $data['selectedMonth'] = $this->db->get_where('periode_counter', ['id' => $periode_id])->row_array();

            $data['current_periode'] = $data['selectedMonth']['period'];
        };

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function my_profile()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/my_profile', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        // set rules to input form validation
        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('email', 'email', 'required|trim|valid_email', [
            'is_unique' => 'This email has already been used!'
        ]);
        $this->form_validation->set_rules('noktp', 'ID number', 'trim|numeric');
        $this->form_validation->set_rules('hp', 'phone number', 'required|trim|numeric');
        $this->form_validation->set_rules('address', 'address', 'required|trim');
        $this->form_validation->set_rules('city', 'city', 'required|trim');
        $this->form_validation->set_rules('province', 'province', 'required|trim');
        $this->form_validation->set_rules('country', 'country', 'required|trim');
        $this->form_validation->set_rules('postal', 'postal', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $nik = $this->input->post('nik');

            //cek jika ada gambar yang akan di upload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['upload_path']          = './asset/img/profile/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg|heif';
                $config['max_size']             = 4096;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'asset/img/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                    $this->db->where('nik', $nik);
                    $this->db->update('user');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('user/my_profile');
                }
            }

            $data = [
                'name' => $this->input->post('name'),
                'noktp' => $this->input->post('noktp'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'province' => $this->input->post('province'),
                'country' => $this->input->post('country'),
                'postal' => $this->input->post('postal'),
                'phone_number' => $this->input->post('hp')
            ];

            $this->db->where('nik', $nik);
            $this->db->update('user', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profile successfully updated!</div>');
            redirect('user/my_profile');
        }
    }

    public function changepassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $this->form_validation->set_rules('current_password', 'current password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'new password', 'required|trim|min_length[8]');
        $this->form_validation->set_rules('new_password2', 'repeat password', 'required|trim|min_length[8]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password!</div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password must not be similar to old password!</div>');
                    redirect('user/changepassword');
                } else {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $nik = $this->session->userdata('nik');

                    $this->db->set('password', $password_hash);
                    $this->db->where('nik', $nik);
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password changed!</div>');
                    redirect('user/changepassword');
                }
            }
        }
    }
}
