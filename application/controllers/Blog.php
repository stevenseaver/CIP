<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog extends CI_Controller
{
    //blog post per type
    public function featured()
    {
        //load user data per session
        $data['title'] = 'Featured';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get blog database
        $data['blogdata'] = $this->db->get_where('blogpost', ['parent_id' => 1, 'status' => 1])->result_array();
        $data['post_type'] = $this->db->get('blog_type')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/web-topbar', $data);
        $this->load->view('web/blog_lp/featured', $data);
        $this->load->view('templates/web-footer');
    }
    //blog post per type
    public function news()
    {
        //load user data per session
        $data['title'] = 'News';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get blog database
        $data['blogdata'] = $this->db->get_where('blogpost', ['parent_id' => 2, 'status' => 1])->result_array();
        $data['post_type'] = $this->db->get('blog_type')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/web-topbar', $data);
        $this->load->view('web/blog_lp/news', $data);
        $this->load->view('templates/web-footer');
    }
    //blog post per type
    public function education()
    {
        //load user data per session
        $data['title'] = 'Education';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get blog database
        $data['blogdata'] = $this->db->get_where('blogpost', ['parent_id' => 4, 'status' => 1])->result_array();
        $data['post_type'] = $this->db->get('blog_type')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/web-topbar', $data);
        $this->load->view('web/blog_lp/education', $data);
        $this->load->view('templates/web-footer');
    }
    //blog post per type
    public function promotion()
    {
        //load user data per session
        $data['title'] = 'Promotion';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        //get blog database
        $data['blogdata'] = $this->db->get_where('blogpost', ['parent_id' => 3, 'status' => 1])->result_array();
        $data['post_type'] = $this->db->get('blog_type')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/web-topbar', $data);
        $this->load->view('web/blog_lp/promotion', $data);
        $this->load->view('templates/web-footer');
    }

    //blog content
    public function content($id)
    {
        //load user data per session
        $data['title'] = 'Content';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $this->load->model('Blog_model', 'blog_id');
        //get blog database
        $data['blogdata'] = $this->blog_id->getBlogStatus();
        $data['post_type'] = $this->db->get('blog_type')->result_array();
        $data['products'] = $this->db->get('product_menu')->result_array();

        $data['contentToLoad'] = $id;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/web-topbar', $data);
        $this->load->view('web/blog_lp/content', $data);
        $this->load->view('templates/web-footer');
    }
}
