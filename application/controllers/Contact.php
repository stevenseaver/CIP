<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'Customer Message';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $data['message'] = $this->db->get('contact_us')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('message/message_view', $data);
        $this->load->view('templates/footer');
    }

    public function add_message()
    {
        $data['title'] = 'Contact Us';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        // $data['user'] = $this->db->get_where('user', ['nik' =>
        // $this->session->userdata('nik')])->row_array();

        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('email', 'email', 'required|trim');
        $this->form_validation->set_rules('message', 'message', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/web-topbar', $data);
            $this->load->view('web/contact-us', $data);
            $this->load->view('templates/web-footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $message = $this->input->post('message');

            $data = [
                'name' => $name,
                'email' => $email,
                'message' => $message
            ];

            $this->db->insert('contact_us', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Message sent!</div>');
            redirect('web/contactus');
        }
    }

    public function send_message()
    {
        $this->_sendEmail();

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Message sent.</div>');
        redirect('contact');
    }

    private function _sendEmail()
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'cipsbp.donotreply@gmail.com',
            'smtp_pass' => 'adminganteng1?',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        $email = $this->input->post('email');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');

        $this->email->initialize($config);

        $this->email->from('cipsbp.donotreply@gmail.com', 'Administrator CIP/SBP');
        $this->email->to($email);

        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            return true;
        } else {
            $message = $this->email->print_debugger();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Sorry, message failed to send. Error: ' . $message . '</div>');
            redirect('contact');
        }
    }

    public function deletemessage($itemtoDelete)
    {
        // get data on deleted menu
        $deletedmessage = $this->db->get_where('contact_us', array('id' => $itemtoDelete))->row_array();
        // delete menu
        $this->db->delete('contact_us', array('id' => $itemtoDelete));
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User ' . $deletedmessage["name"] . ' message deleted!</div>');
        redirect('contact/message');
    }
}
