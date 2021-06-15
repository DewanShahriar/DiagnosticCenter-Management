<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {

        parent::__construct();

        if (isset($_SESSION['lang'])) {
            $this->lang->load('content', $_SESSION['lang']);
        } else {
            $this->lang->load('content', 'english');
        }
    }

    public function index() {

        if (isset($_SESSION['user_auth'])) {


            if ($_SESSION['user_auth'] == true && $_SESSION['userType'] == "admin") {

                $this->session->set_flashdata('message', 'Welcome to Admin Panel.');
                redirect('admin', 'refresh');
            }

           
            if ($_SESSION['user_auth'] == true && $_SESSION['userType'] == "user") {

                $this->session->set_flashdata('message', 'Welcome to Operator Panel.');
                redirect('user', 'refresh');
            }

            if ($_SESSION['user_auth'] == true && $_SESSION['userType'] == "accounts") {

                $this->session->set_flashdata('message', 'Welcome to Accounts Panel.');
                redirect('accounts', 'refresh');
            }

            if ($_SESSION['user_auth'] == true && $_SESSION['userType'] == "lab") {

                $this->session->set_flashdata('message', 'Welcome to Lab Panel.');
                redirect('lab', 'refresh');
            }

            if ($_SESSION['user_auth'] == true && $_SESSION['userType'] == "doctor") {

                $this->session->set_flashdata('message', 'Welcome to Doctor Panel.');
                redirect('doctor', 'refresh');
            }
            
        }

        $this->load->view('backEnd/login_view');
    }

    public function login_validation() {

        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $remember_me = $this->input->post('remember_me');

        if ($remember_me == "on") {

            $this->db->where('password', sha1($password));
            $this->db->group_start()
                    ->where('status', 1)
                    ->where('email', $email)
                    ->or_where('username', $email)
                    ->group_end();
            $savedLoginQuery = $this->db->get('user');
            $user = $savedLoginQuery->num_rows();

            if ($user > 0) {

                $this->session->set_userdata('user_auth', true);

                $this->session->set_userdata('loginname', $email);
                $this->session->set_userdata('userid', $savedLoginQuery->row()->id);
                $this->session->set_userdata('username', $savedLoginQuery->row()->username);
                $this->session->set_userdata('username_first', $savedLoginQuery->row()->firstname);
                $this->session->set_userdata('username_last', $savedLoginQuery->row()->lastname);

                $this->session->set_userdata('userType', $savedLoginQuery->row()->userType);
                $this->session->set_userdata('userPhoto', $savedLoginQuery->row()->photo);

                $this->lang_set();
                redirect('login', 'refresh');
            } else {

                //flash data wrong username or password
                $this->session->set_flashdata('message', 'Login Failed !');
                redirect('login', 'refresh');
            }
        } else {
            $this->session->set_flashdata('message', 'Login Failed !');
            redirect('login', 'refresh');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login', 'refresh');
    }

    public function lang_set($lang = 'english') {
        $this->session->set_userdata('lang', $lang);
        redirect('login', 'refresh');
    }

    public function setting_change() {
        redirect('login', 'refresh');
    }

    public function forgot_password()
    {
        $this->load->view('backEnd/forgot_password');
    }

    public function send_mail()
    {

        $email = $this->input->post('email_phone', true);
       
        $valid_email = $this->db->where('email', $email)->get('user');

        if ($valid_email->num_rows() > 0) {

            $valid_email = $valid_email->row();

            $date        = date('Y-m-d H:i:s', strtotime('-1 day'));
            $ip_address  = $this->input->ip_address();

            $check_user_request = $this->db->where('userId', $valid_email->id)->where('ipaddress', $ip_address)->where('status !=', 2)->where('request_time >', $date)->get('password_recovery')->num_rows();

            if ($check_user_request > 2) {

                echo 'You are block for 24 hour. Please Try again after 24 hour.';

            } else { 

                $recovery_data['userId']       = $valid_email->id;
                $recovery_data['ipaddress']    = $ip_address;
                $recovery_data['request_time'] = date('Y-m-d H:i:s');
                $recovery_data['method']       = 'Phone';
                $recovery_data['status']       = 1;

                $this->db->insert('password_recovery', $recovery_data);

                $request_id = $this->db->insert_id();

                if ($request_id) {

                    $cofig_value = $this->db->get('tbl_mail_send_setting')->result();

                    $config = array();
                    foreach ($cofig_value as $key => $value) {

                        if($value->value) $config[$value->setting_name] = $value->value;
                    }

                    $mydomain = $this->get_domain_name(base_url());
                    $message  = "Dear\n\r\n\rWe have got a 'forgot password' request for your account $email at $mydomain from IP address ".$recovery_data['ipaddress'].", If you do not recognize this request you might simply ignore this link, your account is still safe.\n\r\n\r In order to change your password please follow this link: \n\r\n\r";

                    $message .= base_url()."login/reset-password?req=forgot-password&reqs=".$request_id."&time=".sha1(rand(99, 999));

                    $message .= "\n\r\n\rYour support \n\rHRSOFTBD.";

                    $this->load->library('email', $config);

                    $this->email->set_newline("\r\n");
                    $this->email->from('info@northernfertilizer.com'); 
                    $this->email->to($email);
                    $this->email->subject('Forgot Password Reset');
                    $this->email->message($message);

                    if($this->email->send()) {

                        echo 'An Email has been sent to *'. $email;

                    } else {

                        $this->db->where('id', $request_id)->update('password_recovery', array('status'=>0));

                        echo 'Your email has not found in valid user list.';
                    }

                } else {

                    echo 'System Failed. Please Try Again.';
                }
            }

        } else {

            $valid_email_phone = null;
        }

        


        
    }

    public function reset_password()
    {

        $data['request_id'] = $this->input->get('reqs', true);

        $data['user_id']    = $this->db->where('id', $data['request_id'])->get('password_recovery')->row()->userId;

        $data['reset_password'] = 'yes';

        $this->load->view('backEnd/login_view', $data);
        
    }

    public function save_reset_password()
    {
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id           = $this->input->post('user_id', true);
            $new_password = sha1($this->input->post('new_password', true));
            $request_id   = $this->input->post('request_id', true);

                $this->db->where('id', $id)->update('user', array('password'=>$new_password));

                $this->db->where('id', $request_id)->update('password_recovery', array('status'=>2));

                echo "Your Password Changed Successfully! You can <a href='".base_url('login')."'>Login </a> Now";
        }
    }

    public function get_domain_name($url){

        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
        }
        return "HRSOFTBD";
    }

}
