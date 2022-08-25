<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog extends CI_Controller
{
    public function blogpost()
    {
        //load user data per session
        $data['title'] = 'Blog Posts';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $this->load->model('Blog_model', 'blog_id');
        //get blog database
        $data['blogdata'] = $this->blog_id->getBlogStatus();
        $data['post_type'] = $this->db->get('blog_type')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('employee/blog-post', $data);
        $this->load->view('templates/footer');
    }
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

    //add blog posts
    public function add_post()
    {
        //load user data per session
        $data['title'] = 'Blog Posts';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $this->load->model('Blog_model', 'blog_id');
        //get blog database
        $data['blogdata'] = $this->blog_id->getBlogStatus();
        $data['post_type'] = $this->db->get('blog_type')->result_array();

        $this->form_validation->set_rules('type', 'post type', 'trim|required');
        $this->form_validation->set_rules('title', 'post title', 'trim|required');
        $this->form_validation->set_rules('meta', 'meta title', 'trim|required');
        $this->form_validation->set_rules('summary', 'summary', 'trim|required');
        $this->form_validation->set_rules('content', 'content', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops some inputs are missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('employee/blog-post', $data);
            $this->load->view('templates/footer');
        } else {
            $author = $this->input->post('author_id');
            $type = $this->input->post('type');
            $title = $this->input->post('title');
            $meta = $this->input->post('meta');
            $summary = $this->input->post('summary');
            $date_created = time();
            $date_updated = time();
            $content = $this->input->post('content');

            $data = [
                'author_id' => $author,
                'parent_id' => $type,
                'title' => $title,
                'metaTitle' => $meta,
                'summary' => $summary,
                'status' => '0',
                'date_created' => $date_created,
                'updated_at' => $date_updated,
                'content' => $content
            ];
            $this->db->insert('blogpost', $data);

            //cek jika ada gambar yang akan di upload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['upload_path'] = './asset/img/blogs/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 5120;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', 'asset/img/blogs/' . $new_image);
                    $this->db->where('title', $title);
                    $this->db->update('blogpost');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('employee/blogpost');
                }
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Post saved!</div>');

            redirect('blog/blogpost');
        }
    }

    //edit blog posts
    public function edit_post()
    {
        //load user data per session
        $data['title'] = 'Blog Posts';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $this->load->model('Blog_model', 'blog_id');
        //get blog database
        $data['blogdata'] = $this->blog_id->getBlogStatus();
        $data['post_type'] = $this->db->get('blog_type')->result_array();

        $this->form_validation->set_rules('type', 'post type', 'trim|required');
        $this->form_validation->set_rules('title', 'post title', 'trim|required');
        $this->form_validation->set_rules('meta', 'meta title', 'trim|required');
        $this->form_validation->set_rules('summary', 'summary', 'trim|required');
        $this->form_validation->set_rules('content', 'content', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops some inputs are missing!</div>');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('employee/blog-post', $data);
            $this->load->view('templates/footer');
        } else {
            $id = $this->input->post('id');
            $type = $this->input->post('type');
            $title = $this->input->post('title');
            $meta = $this->input->post('meta');
            $summary = $this->input->post('summary');
            $date_updated = time();
            $content = $this->input->post('content');

            $data = [
                'parent_id' => $type,
                'title' => $title,
                'metaTitle' => $meta,
                'summary' => $summary,
                'status' => '0',
                'updated_at' => $date_updated,
                'content' => $content
            ];

            $this->db->where('id', $id);
            $this->db->update('blogpost', $data);

            //cek jika ada gambar yang akan di upload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['upload_path'] = './asset/img/blogs/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 5120;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', 'asset/img/blogs/' . $new_image);
                    $this->db->where('id', $id);
                    $this->db->update('blogpost');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('blog/blogpost');
                }
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Post saved!</div>');

            redirect('blog/blogpost');
        }
    }

    //blog posts approval
    public function approve($usertoToggle)
    {
        $this->db->set('status', 1);
        $this->db->where('id', $usertoToggle);
        $this->db->update('blogpost');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Upload approved!</div>');
        redirect('blog/blogpost');
    }

    //blog posts decline
    public function decline($usertoToggle)
    {
        $this->db->set('status', 2);
        $this->db->where('id', $usertoToggle);
        $this->db->update('blogpost');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Upload declined!</div>');
        redirect('blog/blogpost');
    }

    public function delete_post()
    {
        // get item to delete
        $itemtoDelete = $this->input->post('delete_id');
        // get data on deleted sub menu
        $deletedItem = $this->db->get_where('blogpost', array('id' => $itemtoDelete))->row_array();
        // delete the sub menu
        $this->db->delete('blogpost', array('id' => $itemtoDelete));
        // send message
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Post titled' . $deletedItem["title"] . ' deleted!</div>');
        redirect('blog/blogpost');
    }
}
