<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    // Configuration constants
    const MAX_FAILED_ATTEMPTS = 3;
    const LOCKOUT_DURATION = 1; // minutes
    const RESET_ATTEMPTS_AFTER = 2; // minutes

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    
    public function index()
    {
        if ($this->session->userdata('nik')) {
            redirect('user');
        }

        $this->form_validation->set_rules('nik', 'username', 'trim|required');
        $this->form_validation->set_rules('password', 'password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $nik = $this->input->post('nik');
        $password = $this->input->post('password');
        
        $user = $this->db->get_where('user', ['nik' => $nik])->row_array();
        
        if (!$user) {
            $this->session->set_flashdata('message', 
                '<div class="alert alert-danger" role="alert">User is not registered!</div>');
            redirect('auth');
            return;
        }
        
        // Check if account is currently locked
        if ($this->_isAccountLocked($user)) {
            $lockout_remaining = $this->_getLockoutTimeRemaining($user);
            $this->session->set_flashdata('message', 
                '<div class="alert alert-danger" role="alert">
                    Account is locked due to too many failed attempts. 
                    Try again in ' . $lockout_remaining . ' minutes.
                </div>');
            redirect('auth');
            return;
        }
        
        // Check if user is active
        if ($user['is_active'] != 1) {
            $this->session->set_flashdata('message', 
                '<div class="alert alert-danger" role="alert">User is not active!</div>');
            redirect('auth');
            return;
        }
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Successful login - reset failed attempts
            $this->_resetFailedAttempts($nik);
            
            // Set session data
            $data = [
                'nik' => $user['nik'],
                'role_id' => $user['role_id']
            ];
            $this->session->set_userdata($data);
            redirect('user');
            
        } else {
            // Failed login - increment failed attempts
            $this->_recordFailedAttempt($nik);
            
            $user = $this->db->get_where('user', ['nik' => $nik])->row_array(); // Get updated data
            $remaining_attempts = self::MAX_FAILED_ATTEMPTS - $user['failed_attempts'];
            
            if ($remaining_attempts <= 0) {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-danger" role="alert">
                        Account locked due to too many failed attempts. 
                        Try again in ' . self::LOCKOUT_DURATION . ' minutes.
                    </div>');
            } else {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-danger" role="alert">
                        Wrong password! ' . $remaining_attempts . ' attempts remaining.
                    </div>');
            }
            redirect('auth');
        }
    }
    
    private function _isAccountLocked($user)
    {
        // Check if account has failed attempts
        if ($user['failed_attempts'] < self::MAX_FAILED_ATTEMPTS) {
            return false;
        }
        
        // Check if lockout period has expired
        if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
            return true;
        }
        
        // Lockout expired, reset the account
        if ($user['locked_until'] && strtotime($user['locked_until']) <= time()) {
            $this->_resetFailedAttempts($user['nik']);
            return false;
        }
        
        return false;
    }
    
    private function _getLockoutTimeRemaining($user)
    {
        if (!$user['locked_until']) {
            return 0;
        }
        
        $remaining_seconds = strtotime($user['locked_until']) - time();
        return max(0, ceil($remaining_seconds / 60)); // Convert to minutes
    }
    
    private function _recordFailedAttempt($nik)
    {
        // Get current failed attempts
        $user = $this->db->get_where('user', ['nik' => $nik])->row_array();
        $current_attempts = $user['failed_attempts'];
        
        // Check if we should reset attempts (if last attempt was too long ago)
        if ($user['last_failed_attempt']) {
            $last_attempt_time = strtotime($user['last_failed_attempt']);
            $reset_time = time() - (self::RESET_ATTEMPTS_AFTER * 60);
            
            if ($last_attempt_time < $reset_time) {
                $current_attempts = 0; // Reset if last attempt was more than 30 minutes ago
            }
        }
        
        $new_attempts = $current_attempts + 1;
        $now = date('Y-m-d H:i:s');
        
        $update_data = [
            'failed_attempts' => $new_attempts,
            'last_failed_attempt' => $now
        ];
        
        // If max attempts reached, set lockout time
        if ($new_attempts >= self::MAX_FAILED_ATTEMPTS) {
            $lockout_until = date('Y-m-d H:i:s', time() + (self::LOCKOUT_DURATION * 60));
            $update_data['locked_until'] = $lockout_until;
        }
        
        $this->db->where('nik', $nik);
        $this->db->update('user', $update_data);
    }
    
    private function _resetFailedAttempts($nik)
    {
        $update_data = [
            'failed_attempts' => 0,
            'locked_until' => null,
            'last_failed_attempt' => null
        ];
        
        $this->db->where('nik', $nik);
        $this->db->update('user', $update_data);
    }


    //fucntion callback for TOS and privacy
    function accept_terms()
    {
        //if (isset($_POST['accept_terms_checkbox']))
        if ($this->input->post('check_terms')) {
            return TRUE;
        } else {
            $error = 'Please read and accept our terms and conditions.';
            $this->form_validation->set_message('accept_terms', $error);
            return FALSE;
        }
    }
    public function registration()
    {
        if ($this->session->userdata('nik')) {
            redirect('user');
        }

        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('nik', 'username', 'required|trim|is_unique[user.nik]', [
            'is_unique' => 'This username has already been used!'
        ]);
        $this->form_validation->set_rules('address', 'address', 'required|trim');
        $this->form_validation->set_rules('city', 'city', 'required|trim');
        $this->form_validation->set_rules('province', 'province', 'required|trim');
        $this->form_validation->set_rules('country', 'country', 'required|trim');
        $this->form_validation->set_rules('postal', 'postal', 'required|trim');
        $this->form_validation->set_rules('noktp', 'ID card number', 'required|trim');
        $this->form_validation->set_rules('dob', 'date of birth', 'required|trim');
        $this->form_validation->set_rules('email', 'email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already been used!'
        ]);
        $this->form_validation->set_rules('hp', 'phone number', 'trim|numeric');
        $this->form_validation->set_rules('password1', 'password', 'required|trim|min_length[8]|matches[password2]', [
            'matches' => 'Password do not match!',
            'min_length' => 'Password too short! Min. 8 character.'
        ]);
        $this->form_validation->set_rules('password2', 'repeat password', 'required|trim|min_length[8]|matches[password1]');
        $this->form_validation->set_rules('check_terms', '', 'callback_accept_terms');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Account Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $name = $this->input->post('name', true);
            $email = $this->input->post('email', true);
            $nik = $this->input->post('email', true);
            $dob = $this->input->post('dob', true);
            $noktp = $this->input->post('noktp', true);
            $hp = $this->input->post('hp', true);
            $address = $this->input->post('address');
            $city = $this->input->post('city');
            $province = $this->input->post('province');
            $country = $this->input->post('country');
            $postal = $this->input->post('postal');
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

            $data = [
                'name' => htmlspecialchars($name),
                'nik' => htmlspecialchars($nik),
                'email' => htmlspecialchars($email),
                'noktp' => htmlspecialchars($noktp),
                'dob' => htmlspecialchars($dob),
                'phone_number' => htmlspecialchars($hp),
                'address' => htmlspecialchars($address),
                'city' => htmlspecialchars($city),
                'province' => htmlspecialchars($province),
                'country' => htmlspecialchars($country),
                'postal' => htmlspecialchars($postal),
                'image' => 'default.jpg',
                'password' => $password,
                'role_id' => 3,
                'is_active' => 0,
                'date_created' => time()
            ];

            //siapkan token login bilangan random
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Account successfully created! Check your email for activation.</div>');
            redirect('auth');
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'mail.plastikrukun.com',
            'smtp_user' => 'donotreply@plastikrukun.com',
            'smtp_pass' => 'donotreplyplastikrukun1!',
            'smtp_port' => 587,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'starttls'  => true,
            'newline'   => "\r\n"
        ];
        // $config = [
        //     'protocol'  => 'smtp',
        //     'smtp_host' => 'mail.plastikrukun.com',
        //     'smtp_user' => 'cs@plastikrukun.com',
        //     'smtp_pass' => 'csplastikrukun1!',
        //     'smtp_port' => 587,
        //     'mailtype'  => 'html',
        //     'charset'   => 'utf-8',
        //     'starttls'  => true,
        //     'newline'   => "\r\n"
        // ];   
        $this->email->initialize($config);
        $this->email->set_crlf("\r\n"); 

        //message body
        // $base_url = base_url();
        $tokenTo = urlencode($token);
        $emailTo = $this->input->post('email');

        $this->email->from('donotreply@plastikrukun.com', 'Administrator');
        $this->email->to($emailTo);
        if ($type == 'verify') {
            $this->email->subject('User Activation');
            $data['token'] = $tokenTo;
            $data['email'] = $emailTo;
            $this->email->message($this->load->view('templates/verify_email', $data, true));
            // $this->email->message('Click this link to activate your account : <a href="' . $base_url . 'auth/verify?email=' . $emailTo . '&token=' . $tokenTo . '">Activate</a>');
            if ($this->email->send()) {
                return true;
            } else {
                $message = $this->email->print_debugger();
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Sorry, message failed to send. Error: ' . $message . '</div>');
                redirect('auth/');
            }
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $data['token'] = $tokenTo;
            $data['email'] = $emailTo;
            $this->email->message($this->load->view('templates/forgot_password', $data, true));
            // $this->email->message('Click this link to reset your password : <a href="' . $base_url . 'auth/resetpassword?email=' . $emailTo . '&token=' . $tokenTo . '">Reset</a>');
            if ($this->email->send()) {
                return true;
            } else {
                $message = $this->email->print_debugger();
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Sorry, message failed to send. Error: ' . $message . '</div>');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' has been activated. Please login. </div>');
                    redirect('auth');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Token expired.</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Token invalid.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! E-mail is not registered.</div>');
            redirect('auth');
        }
    }

    public function resetpassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                if (time() - $user_token['date_created'] < (300)) {
                    $this->session->set_userdata('reset_email', $email);
                    $this->changePassword();
                } else {
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Token expired.</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Token invalid.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong email.</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('nik');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Log out successful!</div>');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">All is good, check your email to reset your password!</div>');
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Your e-mail has not been registered or activated yet!</div>');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'password', 'trim|required|min_length[8]|matches[password2]');
        $this->form_validation->set_rules('password2', 'password', 'trim|required|min_length[8]|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth_footer');
        } else {
            $inputPass = $this->input->post('password1');
            $password = password_hash($inputPass, PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed!</div>');
            redirect('auth');
        }
    }
}
