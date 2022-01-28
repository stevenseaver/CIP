<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web extends CI_Controller
{
	//load homepage
	public function index()
	{
		// index function, will load home-page
		// data['title'] will serve as title of the page
		$data['title'] = 'Home';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['products'] = $this->db->get('product_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/home-page', $data);
		$this->load->view('templates/web-footer');
	}

	//load view product
	public function product()
	{
		$data['title'] = 'Products';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();
		$data['products'] = $this->db->get('product_menu')->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/product', $data);
		$this->load->view('templates/web-footer');
	}
	//load page contact us
	public function contactUs()
	{
		$data['title'] = 'Contact Us';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['products'] = $this->db->get('product_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/contact-us', $data);
		$this->load->view('templates/web-footer');
	}
	//load page about Us
	public function aboutUs()
	{
		$data['title'] = 'About';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['products'] = $this->db->get('product_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/about-us', $data);
		$this->load->view('templates/web-footer');
	}

	//** Landing Page from Main-Page 				*/
	//** Content:									*/
	//** Quality, Eco-Mindful, Highly Customizable 	*/
	//load page LP0_circulatry
	public function lp0_circulatry()
	{
		$data['title'] = 'Circulatry Economics';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['products'] = $this->db->get('product_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/landing_page/lp0-circulatry', $data);
		$this->load->view('templates/web-footer');
	}

	//load page LP1_quality
	public function lp1_quality()
	{
		$data['title'] = 'High Quality';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['products'] = $this->db->get('product_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/landing_page/lp1-quality', $data);
		$this->load->view('templates/web-footer');
	}
	//load page LP2_eco
	public function lp2_eco()
	{
		$data['title'] = 'Eco-Mindful';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['products'] = $this->db->get('product_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/landing_page/lp2-eco', $data);
		$this->load->view('templates/web-footer');
	}
	//load page LP3_guideline
	public function lp3_guideline()
	{
		$data['title'] = 'Highly Customizable';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['products'] = $this->db->get('product_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/landing_page/lp3-guideline', $data);
		$this->load->view('templates/web-footer');
	}

	//** Landing Page from Footer 		*/
	//** Content: 				  		*/
	//** Privacy Policy, Sitemap, T&C 	*/
	//load page privacy policy
	public function privacy_policy()
	{
		$data['title'] = 'Privacy Policy';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['products'] = $this->db->get('product_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/footer_lp/privacy-policy', $data);
		$this->load->view('templates/web-footer');
	}
	//load page terms
	public function terms()
	{
		$data['title'] = 'Terms and Conditions';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['products'] = $this->db->get('product_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/footer_lp/terms', $data);
		$this->load->view('templates/web-footer');
	}
	//load page site map
	public function site_map()
	{
		$data['title'] = 'Site Map';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['products'] = $this->db->get('product_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/footer_lp/site-map', $data);
		$this->load->view('templates/web-footer');
	}
	//load page legal standing
	public function legal()
	{
		$data['title'] = 'Legal Standing';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['products'] = $this->db->get('product_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/footer_lp/legal-standing', $data);
		$this->load->view('templates/web-footer');
	}
}
