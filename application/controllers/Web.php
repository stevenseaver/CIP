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
		$this->load->view('templates/homepage-footer');
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
	public function contact_us()
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

	public function contact_form()
	{
		$data['title'] = 'Customer Service Form';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['products'] = $this->db->get('product_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/complaint-form', $data);
		$this->load->view('templates/web-footer');
	}

	public function validate()
    {
        $data['title'] = 'Contact Us';
        $data['webmenu'] = $this->db->get('web_menu')->result_array();
        $data['products'] = $this->db->get('product_menu')->result_array();

        $this->form_validation->set_rules('invoice', 'invoice', 'required|trim');
        $this->form_validation->set_rules('email', 'email', 'required|trim');
        $this->form_validation->set_rules('phone', 'phone', 'required|trim');
        $this->form_validation->set_rules('message', 'message', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/web-topbar', $data);
            $this->load->view('web/complaint-form', $data);
            $this->load->view('templates/web-footer');
        } else {
            //capture captcha response
            $captcha_response = trim($this->input->post('g-recaptcha-response'));

            if ($captcha_response != '') {
                $keySecret = '6LfDc9ciAAAAAP15GqjPpohPOH8eTpljKTbGMnFc';

                $check = array(
                    'secret' => $keySecret,
                    'response' => $this->input->post('g-recaptcha-response')
                );

                $startProcess = curl_init();

                curl_setopt($startProcess, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");

                curl_setopt($startProcess, CURLOPT_POST, true);

                curl_setopt($startProcess, CURLOPT_POSTFIELDS, http_build_query($check));

                curl_setopt($startProcess, CURLOPT_SSL_VERIFYPEER, false);

                curl_setopt($startProcess, CURLOPT_RETURNTRANSFER, true);

                $receiveData = curl_exec($startProcess);

                $finalResponse = json_decode($receiveData, true);

                if ($finalResponse['success'] == true) {
                    $ticket = rand(0000,9999);
                    $invoice = $this->input->post('invoice');
                    $email = $this->input->post('email');
                    $phone = $this->input->post('phone');
                    $message = $this->input->post('message');

                    $data = [
                        'ticket' => $ticket,
                        'invoice' => 'INV-' . $invoice,
                        'email' => $email,
                        'phone' => $phone,
                        'message' => $message
                    ];

                    $this->db->insert('contact_us', $data);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Message sent!</div>');
                    redirect('web/contact_form');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Google API challenge failed!</div>');
                    redirect('web/contact_form');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User validation failed!</div>');
                redirect('web/contact_form');
            }
        }
    }

	//load page contact list
	public function contactList()
	{
		$data['title'] = 'Contact List';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['products'] = $this->db->get('product_menu')->result_array();
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/contact-list', $data);
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

	//load page about Us
	public function blogs()
	{
		$data['title'] = 'Blog';
		$data['webmenu'] = $this->db->get('web_menu')->result_array();
		$data['blog_type'] = $this->db->get('blog_type')->result_array();
		$data['blog_content'] = $this->db->get_where('blogpost', ['status' => 1])->result_array();
		$data['products'] = $this->db->get('product_menu')->result_array();
		//get user data
		$data['user'] = $this->db->get_where('user', ['nik' =>
		$this->session->userdata('nik')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/web-topbar', $data);
		$this->load->view('web/blog', $data);
		$this->load->view('templates/web-footer');
	}

	//** Landing Page from Main-Page 				*/
	//** Content:									*/
	//** Quality, Eco-Mindful, Highly Customizable 	*/
	//load page LP0_circulatry
	public function lp0_circulatry()
	{
		$data['title'] = 'Circular Economy';
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

	public function forgot_password()
	{
		$data['email'] = 'steven_seaver@me.com';
		$data['token'] = urlencode('KP3UsVFqMVvdxgAl1latrW571LtE3x8x3AFWjFN/BOY=');
		$this->load->view('templates/forgot_password', $data);
	}

	public function verify_account()
	{
		$data['email'] = 'steven_seaver@me.com';
		$data['token'] = urlencode('KP3UsVFqMVvdxgAl1latrW571LtE3x8x3AFWjFN/BOY=');
		$this->load->view('templates/verify_email', $data);
	}
}
