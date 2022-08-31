<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    //leave form
    public function leaveform()
    {
        //load user data per session
        $data['title'] = 'Employee Leave Form';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['leavetype'] = $this->db->get('leave_type')->result_array();

        //load database for table request per user
        // $this->db->where('user_nik', $data['user']['nik']);
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('employee/leave-form', $data);
        $this->load->view('templates/footer');
    }

    public function submit()
    {
        //load user data per session
        $data['title'] = 'Employee Leave Form';
        $data['user'] = $this->db->get_where('user', ['nik' =>
        $this->session->userdata('nik')])->row_array();
        $data['leavetype'] = $this->db->get('leave_type')->result_array();

        //load database for table request per user
        $this->load->model('Leave_model', 'leaveType');
        $data['leavedata'] = $this->leaveType->getLeaveType();

        // get input paramter
        $nik = $this->input->post('nik');
        $name = $this->input->post('name');
        $type = $this->input->post('leave_type');
        $start = $this->input->post('start_date');
        $finish = $this->input->post('finish_date');
        $reason = $this->input->post('reason');
        $status = 0;

        //set rules input
        $this->form_validation->set_rules('nik', 'ERN', 'trim|required');
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('leave_type', 'type', 'trim|required');
        $this->form_validation->set_rules('start_date', 'start date', 'trim|required');
        $this->form_validation->set_rules('finish_date', 'finish date', 'trim|required');
        $this->form_validation->set_rules('reason', 'reason', 'trim|required');
        if ($type == 1) {
            $this->form_validation->set_rules('proof', 'document', 'required');
        };

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('employee/leave-form', $data);
            $this->load->view('templates/footer');
        } else {
            $upload_file = $_FILES['proof']['name'];

            if ($upload_file) {
                $config['upload_path']      = './document/leave_proof/';
                $config['allowed_types']    = 'pdf|jpg|png';
                $config['max_size']         = 2048;
                $config['file_name']        = "{$nik}" . "_" . "{$type}" . "_" . date("Ymd_His");

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('proof')) {
                    $new_file = $this->upload->data('file_name');

                    $input = [
                        'user_nik' => $nik,
                        'user_name' => $name,
                        'type' => $type,
                        'start_date' => $start,
                        'finish_Date' => $finish,
                        'reason' => $reason,
                        'status' => $status,
                        'document' => $new_file
                    ];
                    $this->db->insert('leave_list', $input);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Request submitted!</div>');

                    redirect('employee/leaveform');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('employee/leaveform');
                }
            }
        }
    }

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

            redirect('employee/blogpost');
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
                    redirect('employee/blogpost');
                }
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Post saved!</div>');

            redirect('employee/blogpost');
        }
    }

    //blog posts approval
    public function approve($usertoToggle)
    {
        $this->db->set('status', 1);
        $this->db->where('id', $usertoToggle);
        $this->db->update('blogpost');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Upload approved!</div>');
        redirect('employee/blogpost');
    }

    //blog posts decline
    public function decline($usertoToggle)
    {
        $this->db->set('status', 2);
        $this->db->where('id', $usertoToggle);
        $this->db->update('blogpost');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Upload declined!</div>');
        redirect('employee/blogpost');
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
        redirect('employee/blogpost');
    }
}
