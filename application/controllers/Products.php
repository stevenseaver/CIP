<?php
class Products extends CI_Controller
{
    function plasticbag()
    {
        // index function, will load home-page
        // data['title'] will serve as title of the page
        $data['title'] = 'Plastic Bag';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/web-topbar', $data);
        $this->load->view('web/lp_product/plasticbag', $data);
        $this->load->view('templates/web-footer');
    }

    function inner()
    {
        // index function, will load home-page
        // data['title'] will serve as title of the page
        $data['title'] = 'Inner Bag';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/web-topbar', $data);
        $this->load->view('web/lp_product/innerbag', $data);
        $this->load->view('templates/web-footer');
    }
    function trashbag()
    {
        // index function, will load home-page
        // data['title'] will serve as title of the page
        $data['title'] = 'Trash Bag';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/web-topbar', $data);
        $this->load->view('web/lp_product/trashbag', $data);
        $this->load->view('templates/web-footer');
    }
}
