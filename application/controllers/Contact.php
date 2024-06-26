<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in_no_authroized();
    }

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
            'smtp_host' => 'mail.plastikrukun.com',
            'smtp_user' => 'cs@plastikrukun.com',
            'smtp_pass' => 'csplastikrukun1!',
            'smtp_port' => 587,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'starttls'  => true,
            'newline'   => "\r\n"
        ];
        
        $this->email->initialize($config);
        $this->email->set_crlf("\r\n"); 

        $this->email->from('cs@plastikrukun.com', 'Administrator');
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

    public function close_ticket($id)
    {
        // get data on deleted menu
        $deletedmessage = $this->db->get_where('contact_us', array('id' => $id))->row_array();
        // delete menu
        $this->db->where('id', $id);
        $this->db->set('status', 1);
        $this->db->update('contact_us');

        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Ticket number ' . $deletedmessage["ticket"] . ' resolved!</div>');
        redirect('contact');
    }

    public function deletemessage()
    {
        // get data on deleted menu
        $id = $this->input->post('delete_id');
        $deletedmessage = $this->db->get_where('contact_us', array('id' => $id))->row_array();
        // delete menu
        $this->db->delete('contact_us', array('id' => $id));
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Ticket number ' . $deletedmessage["ticket"] . ' deleted!</div>');
        redirect('contact');
    }
}
