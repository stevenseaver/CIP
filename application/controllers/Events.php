<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Events extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['Guest_model']);
    }

    public function index()
    {
        $data['title'] = 'Event Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('events/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit_event_data(){
        $data['title'] = 'Event Details';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $this->form_validation->set_rules('event_id', 'event id', 'required|trim');
        $this->form_validation->set_rules('event_name', 'event name', 'required|trim');
        $this->form_validation->set_rules('event_start_date', 'event start date', 'required|trim');
        $this->form_validation->set_rules('event_end_date', 'event end date', 'required|trim');
        $this->form_validation->set_rules('event_location', 'event location', 'trim');
        $this->form_validation->set_rules('event_description', 'event description', 'trim');
        $this->form_validation->set_rules('address', 'address', 'required|trim');
        $this->form_validation->set_rules('city', 'city', 'trim');
        $this->form_validation->set_rules('province', 'province', 'trim');
        $this->form_validation->set_rules('country', 'country', 'trim');
        $this->form_validation->set_rules('postal', 'postal', 'trim');

        if($this->form_validation->run() == false){
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops something sure is missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('events/index', $data);
            $this->load->view('templates/footer');
        } else {
            $event_id = $this->input->post('event_id');
            $event_name = $this->input->post('event_name');
            $event_start_date = strtotime($this->input->post('event_start_date'));
            $event_end_date = strtotime($this->input->post('event_end_date'));
            $event_location = $this->input->post('event_location');
            $event_description = $this->input->post('event_description');
            $address = $this->input->post('address');
            $city = $this->input->post('city');
            $province = $this->input->post('province');
            $country = $this->input->post('country');
            $postal = $this->input->post('postal');

            $data = [
                'event_name' => $event_name,
                'event_start_date' => $event_start_date,
                'event_end_date' => $event_end_date,
                'event_location' => $event_location,
                'event_description' => $event_description,
                'address' => $address,
                'city' => $city,
                'province' => $province,
                'country' => $country,
                'postal' => $postal
            ];

            $this->db->where('event_id', $event_id);
            $this->db->update('user', $data);
            redirect('events/');
        };
    }

    public function guest_list()
    {
        $data['title'] = 'Guest List';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get guest database that correspond to the user's event_id
        $this->db->select('*');
        $this->db->from(`guests`);
        $this->db->join('guest_category', 'guest_category.id = guests.category');
        $data['guest_list'] = $this->db->get_where('guests', ['event_id' => $data['user']['event_id']])->result_array();

        $data['guest_cat'] = $this->db->get_where('guest_category', ['e_id' => $data['user']['event_id']])->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('events/guest_list', $data);
        $this->load->view('templates/footer');
    }
    
    public function add_guest(){
        $data['title'] = 'Guest List';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get guest database that correspond to the user's event_id
        $this->db->select('*');
        $this->db->from(`guests`);
        $this->db->join('guest_category', 'guest_category.id = guests.category');
        $data['guest_list'] = $this->db->get_where('guests', ['event_id' => $data['user']['event_id']])->result_array();

        $data['guest_cat'] = $this->db->get_where('guest_category', ['e_id' => $data['user']['event_id']])->result_array();

        $this->form_validation->set_rules('event_id', 'event id', 'required|trim');
        $this->form_validation->set_rules('guest_id', 'guest ID', 'required|trim|is_unique[guests.guest_id]');
        $this->form_validation->set_rules('full_name', 'guest name', 'required|trim');
        $this->form_validation->set_rules('num_pax', 'number of invitees', 'required|trim');
        $this->form_validation->set_rules('category', 'category', 'required|trim');
        $this->form_validation->set_rules('address', 'guest address', 'required|trim');
        $this->form_validation->set_rules('email', 'guest email', 'required|trim');
        $this->form_validation->set_rules('phone', 'guest phone', 'required|trim');
        $this->form_validation->set_rules('rsvp_status', 'city', 'required|trim');

        if($this->form_validation->run() == false){
            $this->session->set_flashdata('guest_list_message', '<div class="alert alert-danger" role="alert">Oops something sure is missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('events/guest_list', $data);
            $this->load->view('templates/footer');
        } else {
            $event_id = $this->input->post('event_id');
            $guest_id = $this->input->post('guest_id');
            $full_name = $this->input->post('full_name');
            $num_pax = $this->input->post('num_pax');
            $category = $this->input->post('category');
            $address = $this->input->post('address');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $rsvp_status = $this->input->post('rsvp_status');

            $guest_data = [
                'event_id' => $event_id,
                'guest_id' => $guest_id,
                'full_name' => $full_name,
                'num_pax' => $num_pax,
                'category' => $category,
                'address' => $address,
                'email' => $email,
                'phone' => $phone,
                'rsvp_status' => $rsvp_status
            ];

            $this->Guest_model->add_guest($guest_data);
            $this->session->set_flashdata('guest_list_message', '<div class="alert alert-success" role="alert">Hooray! The more the merrier.</div>');
            redirect('events/guest_list');
        };
    }

    public function edit_guest(){
        $data['title'] = 'Guest List';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get guest database that correspond to the user's event_id
        $this->db->select('*');
        $this->db->from(`guests`);
        $this->db->join('guest_category', 'guest_category.id = guests.category');
        $data['guest_list'] = $this->db->get_where('guests', ['event_id' => $data['user']['event_id']])->result_array();

        $data['guest_cat'] = $this->db->get_where('guest_category', ['e_id' => $data['user']['event_id']])->result_array();

        $this->form_validation->set_rules('event_id', 'event id', 'required|trim');
        $this->form_validation->set_rules('guest_id', 'guest ID', 'required|trim');
        $this->form_validation->set_rules('full_name', 'guest name', 'required|trim');
        $this->form_validation->set_rules('num_pax', 'number of invitees', 'required|trim');
        $this->form_validation->set_rules('category', 'category', 'required|trim');
        $this->form_validation->set_rules('address', 'guest address', 'required|trim');
        $this->form_validation->set_rules('email', 'guest email', 'required|trim');
        $this->form_validation->set_rules('phone', 'guest phone', 'required|trim');
        $this->form_validation->set_rules('rsvp_status', 'city', 'required|trim');

        if($this->form_validation->run() == false){
            $this->session->set_flashdata('guest_list_message', '<div class="alert alert-danger" role="alert">Oops something sure is missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('events/guest_list', $data);
            $this->load->view('templates/footer');
        } else {
            $event_id = $this->input->post('event_id');
            $guest_id = $this->input->post('guest_id');
            $full_name = $this->input->post('full_name');
            $num_pax = $this->input->post('num_pax');
            $category = $this->input->post('category');
            $address = $this->input->post('address');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $rsvp_status = $this->input->post('rsvp_status');

            $edit_data = [
                'full_name' => $full_name,
                'num_pax' => $num_pax,
                'category' => $category,
                'address' => $address,
                'email' => $email,
                'phone' => $phone,
                'rsvp_status' => $rsvp_status
            ];

            $this->db->where('guest_id', $guest_id);
            $this->db->update('guests', $edit_data);
            $this->session->set_flashdata('guest_list_message', '<div class="alert alert-success" role="alert">Guest ' . $full_name . ' with ID ' . $guest_id. ' edited.</div>');
            redirect('events/guest_list');
        };
    }

    public function delete_guest()
    {
        // get deleted item
        $itemtoDelete = $this->input->post('delete_guest_id');
        // get data on deleted sub menu
        $deletedGuest = $this->db->get_where('guests', array('guest_id' => $itemtoDelete))->row_array();
        // delete the sub menu
        $this->db->delete('guests', array('guest_id' => $itemtoDelete));
        // send message
        $this->session->set_flashdata('guest_list_message', '<div class="alert alert-success" role="alert">Guest ' . $deletedGuest["full_name"] . ' with guest ID ' . $deletedGuest["guest_id"] .' deleted!</div>');
        redirect('events/guest_list');
    }

    public function guest_check_in()
    {
        $data['title'] = 'Guest Check In';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('events/guest_check_in', $data);
        $this->load->view('templates/footer');
    }


    // Product category
    // Product category
    // Product category
    public function guest_category()
    {
        $data['title'] = 'Guest Category';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['prod_cat'] = $this->db->get_where('guest_category', ['e_id' => $data['user']['event_id']])->result_array();

        $this->form_validation->set_rules('event_id', 'event ID', 'required|trim');
        $this->form_validation->set_rules('title', 'title', 'required|trim');
        $this->form_validation->set_rules('seating', 'seating', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('events/guest_cat', $data);
            $this->load->view('templates/footer');
        } else {
            $event_id = $this->input->post('event_id');
            $title = $this->input->post('title');
            $unit = $this->input->post('seating');
            $data = [
                'e_id' => $event_id,
                'title' => $title,
                'seating' => $unit
            ];
            $this->db->insert('guest_category', $data);
            $this->session->set_flashdata('guest_cat_msg', '<div class="alert alert-success" role="alert">Guest category ' . $title . ' added!</div>');
            redirect('events/guest_category');
        }
    }
    
    public function edit_guest_category()
    {
        $data['title'] = 'Guest Category';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['prod_cat'] = $this->db->get_where('guest_category', ['e_id' => $data['user']['event_id']])->result_array();
        
        $this->form_validation->set_rules('id', 'id', 'required|trim');
        $this->form_validation->set_rules('title', 'title', 'required|trim');
        $this->form_validation->set_rules('seating', 'seating', 'required|trim');
        
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('events/guest_cat', $data);
            $this->load->view('templates/footer');
        } else {
            //read from input input
            $edit_id = $this->input->post('id');
            $edit_title = $this->input->post('title');
            $seating = $this->input->post('seating');
            $editedProdCategory = $this->db->get_where('guest_category', array('id' => $edit_id))->row_array();
            // edit DB
            $data = [
                'title' => $edit_title,
                'seating' => $seating
            ];
            $this->db->where('id', $edit_id);
            $this->db->update('guest_category', $data);
            $this->session->set_flashdata('guest_cat_msg', '<div class="alert alert-primary" role="alert">Guest category ' . $editedProdCategory["title"] . ' edited into ' . $edit_title . '!</div>');
            redirect('events/guest_category');
        }
    }

    public function delete_productmenu()
    {
        // get deleted item
        $itemtoDelete = $this->input->post('delete_cat_id');
        // get data on deleted sub menu
        $deletedWebMenu = $this->db->get_where('guest_category', array('id' => $itemtoDelete))->row_array();
        // delete the sub menu
        $this->db->delete('guest_category', array('id' => $itemtoDelete));
        // send guest_cat_msg
        $this->session->set_flashdata('guest_cat_msg', '<div class="alert alert-danger" role="alert">Guest category ' . $deletedWebMenu["title"] . ' deleted!</div>');
        redirect('events/guest_category');
    }
}
