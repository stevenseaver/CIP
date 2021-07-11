<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web extends CI_Controller
{
	public function index()
	{
		// index function, will load home-page
		// data['title'] will serve as title of the page
		$data['title'] = 'Home';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/home-page', $data);
		$this->load->view('templates/web-footer');
	}

	public function product()
	{
		$data['title'] = 'Products';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/product', $data);
		$this->load->view('templates/web-footer');
	}

	public function contactUs()
	{
		$data['title'] = 'Contact Us';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/contact-us', $data);
		$this->load->view('templates/web-footer');
	}

	public function aboutUs()
	{
		$data['title'] = 'About Us';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/about-us', $data);
		$this->load->view('templates/web-footer');
	}
}
