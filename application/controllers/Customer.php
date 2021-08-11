<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        //load user data per session
        $data['title'] = 'Products List';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['leavetype'] = $this->db->get('leave_type')->result_array();

        //load database for table request per user
        // $this->db->where('user_nik', $data['user']['nik']);
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('customer/coming-soon', $data);
        $this->load->view('templates/footer');
    }

    public function cart()
    {
        //load user data per session
        $data['title'] = 'Cart';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['leavetype'] = $this->db->get('leave_type')->result_array();

        //load database for table request per user
        // $this->db->where('user_nik', $data['user']['nik']);
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('customer/coming-soon', $data);
        $this->load->view('templates/footer');
    }

    public function submit()
    {
        //load user data per session
        $data['title'] = 'Order Form';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['leavetype'] = $this->db->get('leave_type')->result_array();

        //load database for table request per user
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        // get input paramter
        $nik = $this->input->post('nik');
        $name = $this->input->post('name');
        $type = $this->input->post('leave_type');
        $start = $this->input->post('start_date');
        $finish = $this->input->post('finish_date');
        $reason = $this->input->post('reason');
        $status = 0;

        //set rules input
        $this->form_validation->set_rules('nik', 'ERN', 'trim|required');
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('leave_type', 'type', 'trim|required');
        $this->form_validation->set_rules('start_date', 'start date', 'trim|required');
        $this->form_validation->set_rules('finish_date', 'finish date', 'trim|required');
        $this->form_validation->set_rules('reason', 'reason', 'trim|required');
        if ($reason == 1) {
            $this->form_validation->set_rules('proof', 'document', 'required');
        };

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('customer/leave-form', $data);
            $this->load->view('templates/footer');
        } else {
            $upload_file = $_FILES['proof']['name'];

            if ($upload_file) {
                $config['upload_path']      = './document/leave_proof/';
                $config['allowed_types']    = 'pdf|jpg|png';
                $config['max_size']         = 2048;
                $config['file_name']        = "{$nik}" . "_" . "{$type}" . "_" . date("Ymd_His");

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('proof')) {
                    $new_file = $this->upload->data('file_name');

                    $input = [
                        'user_nik' => $nik,
                        'user_name' => $name,
                        'type' => $type,
                        'start_date' => $start,
                        'finish_Date' => $finish,
                        'reason' => $reason,
                        'status' => $status,
                        'document' => $new_file
                    ];
                    $this->db->insert('leave_list', $input);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Request submitted!</div>');

                    redirect('customer/leaveform');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('customer/leaveform');
                }
            }
        }
    }
}
