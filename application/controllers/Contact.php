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
            redirect('web/contact_us');
        }
    }

    public function send_message()
    {
        $to = $this->input->post('email');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');

        $this->_sendEmail($to, $subject, $message);
        redirect('contact');
    }

    private function _sendEmail($to, $subject, $message)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.hostinger.com',
            'smtp_user' => 'email@seaverweb.com',
            'smtp_pass' => 'Anderson25?',
            'smtp_port' => 587,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'starttls'  => true,
            'newline'   => "\r\n"
        ];
        $this->email->initialize($config);

        $this->email->from('email@seaverweb.com', 'Administrator');
        $this->email->to($to);

        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Message sent.</div>');
            return true;
        } else {
            $message = $this->email->print_debugger();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Sorry, message failed to send. Error: ' . $message . '</div>');
            redirect('contact');
        }
        // ini_set('display_errors', 1);
        // error_reporting(E_ALL);

        // $email = $this->input->post('email');
        // $subject = $this->input->post('subject');
        // $message = $this->input->post('message');
        // $from = "email@seaverweb.com";

        // $headers = "From:" . $from;
        // if (mail($email, $subject, $message, $headers)) {
        //     return true;
        // } else {
        //     $message = $this->email->print_debugger();
        //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Sorry, message failed to send. Error: ' . $message . '</div>');
        //     redirect('contact');
        // }
    }

    public function deletemessage($itemtoDelete)
    {
        // get data on deleted menu
        $deletedmessage = $this->db->get_where('contact_us', array('id' => $itemtoDelete))->row_array();
        // delete menu
        $this->db->delete('contact_us', array('id' => $itemtoDelete));
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User ' . $deletedmessage["name"] . ' message deleted!</div>');
        redirect('contact');
    }
}
