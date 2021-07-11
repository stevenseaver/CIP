<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $addMenu = $this->input->post('menu');
            $this->db->insert('user_menu', ['menu' => $addMenu]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu added!</div>');
            redirect('menu');
        }
    }

    public function editmenu()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('edit_menu_id', 'menu id', 'required|trim');
        $this->form_validation->set_rules('edit_menu_name', 'menu name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            //read from input input
            $edit_id = $this->input->post('edit_menu_id');
            $edit_name = $this->input->post('edit_menu_name');
            $editedMenu = $this->db->get_where('user_menu', array('id' => $edit_id))->row_array();
            // edit DB
            $this->db->where('id', $edit_id);
            $this->db->update('user_menu', array('menu' => $edit_name));
            $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">Menu ' . $editedMenu["menu"] . ' edited into ' . $edit_name . '!</div>');
            redirect('menu');
        }
    }

    public function deletemenu($itemtoDelete)
    {
        // get data on deleted menu
        $deletedMenu = $this->db->get_where('user_menu', array('id' => $itemtoDelete))->row_array();
        // delete menu
        $this->db->delete('user_menu', array('id' => $itemtoDelete));
        // delete its submenu
        $this->db->delete('user_sub_menu', array('menu_id' => $itemtoDelete));
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Menu ' . $deletedMenu["menu"] . ' and its submenu deleted!</div>');
        redirect('menu');
    }

    // controller for submenu
    public function submenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();

        $this->load->model('Menu_model', 'menu');
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'title', 'required|trim');
        $this->form_validation->set_rules('menu_id', 'menu', 'required|trim');
        $this->form_validation->set_rules('url', 'url', 'required|trim');
        $this->form_validation->set_rules('icon', 'icon', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu added!</div>');
            redirect('menu/submenu');
        }
    }

    public function editsubmenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['submenu'] = $this->db->get('user_sub_menu')->result_array();

        $this->form_validation->set_rules('sub_id', 'menu name', 'required|trim');
        $this->form_validation->set_rules('title', 'menu name', 'required|trim');
        $this->form_validation->set_rules('menu_id', 'menu name', 'required|trim');
        $this->form_validation->set_rules('url', 'menu name', 'required|trim');
        $this->form_validation->set_rules('icon', 'menu name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            //read from input input
            $edit_id = $this->input->post('sub_id');
            $edit_menu_id = $this->input->post('menu_id');
            $edit_title = $this->input->post('title');
            $edit_url = $this->input->post('url');
            $edit_icon = $this->input->post('icon');
            //find edited submenu
            $editedSubmenu = $this->db->get_where('user_sub_menu', array('id' => $edit_id))->row_array();
            // edit DB
            $data = [
                'id' => $edit_id,
                'menu_id' => $edit_menu_id,
                'title' => $edit_title,
                'url' => $edit_url,
                'icon' => $edit_icon
            ];
            $this->db->where('id', $edit_id);
            $this->db->update('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert"> Submenu ' . $editedSubmenu["title"] . ' edited into ' . $edit_title . '!</div>');
            redirect('menu/submenu');
        }
    }

    public function toggleActive($submenuToToggle, $is_active, $name)
    {
        if ($is_active == 1) {
            $this->db->set('is_active', 0);
            $this->db->where('id', $submenuToToggle);
            $this->db->update('user_sub_menu');
        } else if ($is_active == 0) {
            $this->db->set('is_active', 1);
            $this->db->where('id', $submenuToToggle);
            $this->db->update('user_sub_menu');
        }
        $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">' . urldecode($name) . ' status changed!</div>');
        redirect('menu/submenu');
    }

    public function deletesubmenu($itemtoDelete)
    {
        // get data on deleted sub menu
        $deletedSubMenu = $this->db->get_where('user_sub_menu', array('id' => $itemtoDelete))->row_array();
        // delete the sub menu
        $this->db->delete('user_sub_menu', array('id' => $itemtoDelete));
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Submenu ' . $deletedSubMenu["title"] . ' deleted!</div>');
        redirect('menu/submenu');
    }

    // web menu management
    public function webmenu()
    {
        $data['title'] = 'Web Menu Management';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['webmenu'] = $this->db->get('web_menu')->result_array();

        $this->form_validation->set_rules('title', 'title', 'required|trim');
        $this->form_validation->set_rules('url', 'url', 'valid_url|required|trim');
        $this->form_validation->set_rules('icon', 'icon', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/web-menu', $data);
            $this->load->view('templates/footer');
        } else {
            $title = $this->input->post('title');
            $url = $this->input->post('url');
            $icon = $this->input->post('icon');
            $data = [
                'title' => $title,
                'url' => $url,
                'icon' => $icon
            ];
            $this->db->insert('web_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Web menu ' . $title . ' added!</div>');
            redirect('menu/webmenu');
        }
    }

    public function delete_webmenu($itemtoDelete)
    {
        // get data on deleted sub menu
        $deletedWebMenu = $this->db->get_where('web_menu', array('id' => $itemtoDelete))->row_array();
        // delete the sub menu
        $this->db->delete('web_menu', array('id' => $itemtoDelete));
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Submenu ' . $deletedWebMenu["title"] . ' deleted!</div>');
        redirect('menu/webmenu');
    }
}
