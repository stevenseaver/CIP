<?php
class Products extends CI_Controller
{
    public function plasticbag()
    {
        $data['title'] = 'Products';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['products'] = $this->db->get('product_menu')->result_array();

        //get spec sheet
        $data['spec'] = $this->db->get('spec_sheet')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/web-topbar', $data);
        $this->load->view('web/lp_product/plasticbag', $data);
        $this->load->view('templates/web-footer');
    }

    public function inner()
    {
        $data['title'] = 'Products';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['products'] = $this->db->get('product_menu')->result_array();
        //get spec sheet
        $data['spec'] = $this->db->get('spec_sheet')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/web-topbar', $data);
        $this->load->view('web/lp_product/innerbag', $data);
        $this->load->view('templates/web-footer');
    }

    public function trashbag()
    {
        // data['title'] will serve as title of the page
        $data['title'] = 'Products';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['products'] = $this->db->get('product_menu')->result_array();

        //get spec sheet
        $data['spec'] = $this->db->get('spec_sheet')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/web-topbar', $data);
        $this->load->view('web/lp_product/trashbag', $data);
        $this->load->view('templates/web-footer');
    }

    public function shoppingbag()
    {
        $data['title'] = 'Products';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['products'] = $this->db->get('product_menu')->result_array();

        //get spec sheet
        $data['spec'] = $this->db->get('spec_sheet')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/web-topbar', $data);
        $this->load->view('web/lp_product/shoppingbag', $data);
        $this->load->view('templates/web-footer');
    }

    public function jumbobag()
    {
        $data['title'] = 'Products';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['products'] = $this->db->get('product_menu')->result_array();

        //get spec sheet
        $data['spec'] = $this->db->get('spec_sheet')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/web-topbar', $data);
        $this->load->view('web/lp_product/jumbobag', $data);
        $this->load->view('templates/web-footer');
    }

    public function bulks()
    {
        $data['title'] = 'Products';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['products'] = $this->db->get('product_menu')->result_array();

        //get spec sheet
        $data['spec'] = $this->db->get('spec_sheet')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/web-topbar', $data);
        $this->load->view('web/lp_product/bulks', $data);
        $this->load->view('templates/web-footer');
    }
}
