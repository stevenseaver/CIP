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

    public function deletemenu()
    {
        // get data on deleted menu
        $itemtoDelete = $this->input->post('delete_menu_id');
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

        $this->load->model('Menu_model', 'menu');
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

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

    public function deletesubmenu()
    {
        // get data on deleted menu
        $itemtoDelete = $this->input->post('sub_id');
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
            $this->load->view('menu/webmenu', $data);
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

    public function toggleWebMenuActive($webMenuToToggle, $is_active, $name)
    {
        if ($is_active == 1) {
            $this->db->set('is_active', 0);
            $this->db->where('id', $webMenuToToggle);
            $this->db->update('web_menu');
        } else if ($is_active == 0) {
            $this->db->set('is_active', 1);
            $this->db->where('id', $webMenuToToggle);
            $this->db->update('web_menu');
        }
        $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">' . urldecode($name) . ' status changed!</div>');
        redirect('menu/webmenu');
    }

    public function editwebmenu()
    {
        $data['title'] = 'Web Menu Management';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['webmenu'] = $this->db->get('web_menu')->result_array();

        $this->form_validation->set_rules('id', 'menu name', 'required|trim');
        $this->form_validation->set_rules('title', 'menu name', 'required|trim');
        $this->form_validation->set_rules('url', 'menu name', 'required|trim');
        $this->form_validation->set_rules('icon', 'menu name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/webmenu', $data);
            $this->load->view('templates/footer');
        } else {
            //read from input input
            $edit_id = $this->input->post('id');
            $edit_title = $this->input->post('title');
            $edit_url = $this->input->post('url');
            $edit_icon = $this->input->post('icon');
            //find edited submenu
            $editedWebMenu = $this->db->get_where('web_menu', array('id' => $edit_id))->row_array();
            // edit DB
            $data = [
                'title' => $edit_title,
                'url' => $edit_url,
                'icon' => $edit_icon
            ];
            $this->db->where('id', $edit_id);
            $this->db->update('web_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert"> Web Menu ' . $editedWebMenu["title"] . ' edited into ' . $edit_title . '!</div>');
            redirect('menu/webmenu');
        }
    }

    public function delete_webmenu()
    {
        // get item to delete
        $itemtoDelete = $this->input->post('delete_webmenu_id');
        // get data on deleted sub menu
        $deletedWebMenu = $this->db->get_where('web_menu', array('id' => $itemtoDelete))->row_array();
        // delete the sub menu
        $this->db->delete('web_menu', array('id' => $itemtoDelete));
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Submenu ' . $deletedWebMenu["title"] . ' deleted!</div>');
        redirect('menu/webmenu');
    }

    // product page menu management
    public function productmenu()
    {
        $data['title'] = 'Product Menu';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['productmenu'] = $this->db->get('product_menu')->result_array();

        $this->form_validation->set_rules('title', 'title', 'required|trim');
        $this->form_validation->set_rules('url', 'url', 'valid_url|required|trim');
        $this->form_validation->set_rules('icon', 'icon', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/productmenu', $data);
            $this->load->view('templates/footer');
        } else {
            $title = $this->input->post('title');
            $url = $this->input->post('url');
            $icon = $this->input->post('icon');
            $data = [
                'title' => $title,
                'url' => $url,
                'image' => $icon
            ];
            $this->db->insert('product_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Product spec item ' . $title . ' added!</div>');
            redirect('menu/productmenu');
        }
    }

    public function editproductmenu()
    {
        $data['title'] = 'Product Menu';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['productmenu'] = $this->db->get('product_menu')->result_array();

        $this->form_validation->set_rules('id', 'menu name', 'required|trim');
        $this->form_validation->set_rules('title', 'menu name', 'required|trim');
        $this->form_validation->set_rules('url', 'menu name', 'required|trim');
        $this->form_validation->set_rules('icon', 'menu name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/productmenu', $data);
            $this->load->view('templates/footer');
        } else {
            //read from input input
            $edit_id = $this->input->post('id');
            $edit_title = $this->input->post('title');
            $edit_url = $this->input->post('url');
            $edit_icon = $this->input->post('icon');
            //find edited submenu
            $editedWebMenu = $this->db->get_where('web_menu', array('id' => $edit_id))->row_array();
            // edit DB
            $data = [
                'title' => $edit_title,
                'url' => $edit_url,
                'image' => $edit_icon
            ];
            $this->db->where('id', $edit_id);
            $this->db->update('product_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert"> Product Menu ' . $editedWebMenu["title"] . ' edited into ' . $edit_title . '!</div>');
            redirect('menu/productmenu');
        }
    }

    public function delete_productmenu()
    {
        // get deleted item
        $itemtoDelete = $this->input->post('delete_productmenu_id');
        // get data on deleted sub menu
        $deletedWebMenu = $this->db->get_where('product_menu', array('id' => $itemtoDelete))->row_array();
        // delete the sub menu
        $this->db->delete('product_menu', array('id' => $itemtoDelete));
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Product menu ' . $deletedWebMenu["title"] . ' deleted!</div>');
        redirect('menu/productmenu');
    }

    public function product_spec($id)
    {
        $data['title'] = 'Product Specification';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        // $data['productmenu'] = $this->db->get_where('product_menu', ['id' => $id])->row_array();
        // //get product title from id value
        $data['id'] = $id;
        $data['productspec'] = $this->db->get_where('spec_sheet', ['prod_id' => $id])->result_array();

        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('id', 'id', 'required|trim'); //prod_name id, not database id
        $this->form_validation->set_rules('specification', 'specification', 'required|trim');
        $this->form_validation->set_rules('content', 'content', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/product_spec', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $prod_id = $this->input->post('id');
            $specification = $this->input->post('specification');
            $content = $this->input->post('content');

            $data = [
                'product_name' => $name,
                'prod_id' => $prod_id,
                'specification' => $specification,
                'items' => $content
            ];

            $this->db->insert('spec_sheet', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Specification for ' . $name . ' added!</div>');
            redirect('menu/product_spec/' . $id);
        }
    }

    public function edit_spec($id)
    {
        $data['title'] = 'Product Specification';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        // $data['productmenu'] = $this->db->get_where('product_menu', ['id' => $id])->row_array();
        // //get product title from id value
        $data['id'] = $id;
        $data['productspec'] = $this->db->get_where('spec_sheet', ['prod_id' => $id])->result_array();

        $this->form_validation->set_rules('edit_name', 'name', 'required|trim');
        $this->form_validation->set_rules('edit_id', 'ID', 'required|trim');
        $this->form_validation->set_rules('edit_spec', 'specification', 'required|trim');
        $this->form_validation->set_rules('edit_content', 'content', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/product_spec', $data);
            $this->load->view('templates/footer');
        } else {
            $edit_id = $this->input->post('edit_id');
            $name = $this->input->post('edit_name');
            $specification = $this->input->post('edit_spec');
            $content = $this->input->post('edit_content');

            $data = [
                'product_name' => $name,
                'specification' => $specification,
                'items' => $content
            ];

            $this->db->where('id', $edit_id);
            $this->db->update('spec_sheet', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> ' . $name . ' ' . $specification . ' specification edited!</div>');
            redirect('menu/product_spec/' . $id);
        }
    }

    public function delete_spec()
    {
        // get deleted item
        $idToDelete = $this->input->post('delete_id');
        $nameToDelete = $this->input->post('delete_name');
        $specToDelete = $this->input->post('delete_spec');
        // delete the sub menu
        $this->db->delete('spec_sheet', array('id' => $idToDelete));
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> ' . $nameToDelete . ' item of: ' . $specToDelete . ' deleted!</div>');
        redirect('menu/productmenu');
    }
}
