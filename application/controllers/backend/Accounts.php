<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {

    function __construct() {

        parent::__construct();

        $this->lang->load('content', $_SESSION['lang']);

        if (!isset($_SESSION['user_auth']) || $_SESSION['user_auth'] != true) {
            redirect('login', 'refresh');
        }
        if ($_SESSION['userType'] != 'accounts')
            redirect('login', 'refresh');

        $this->load->model('AccountsModel');
        $this->load->library("pagination");
        $this->load->helper("url");
        $this->load->helper("text");
        date_default_timezone_set("Asia/Dhaka");
    }

    public function index() {


        $user_id = $this->session->userdata('userid');

        $data['total_tests'] = $this->db->count_all('tbl_tests');
        $data['report_submitted'] = $this->db->where('report_upload_time >', '0000-00-00 00:00:00')->count_all_results('tbl_tests_details');
        $data['total_doctor']       = $this->db->where('userType =', 'doctor')->count_all_results('user');

        $data['due_report_list'] = $this->AdminModel->get_due_report_dashboard();
        $data['report_submit_list'] = $this->AdminModel->report_to_submit_list();
        $data['total_patient']    = $this->db->count_all('tbl_patient');

        $data['title']      = 'User Panel • HRSOFTBD';
        $data['page']       = 'backEnd/accounts/accounts_dashboard';
        $data['activeMenu'] = 'dashboard_view';

        $this->load->view('backEnd/master_page', $data);
    }

    public function image_size_fix($filename, $width = 600, $height = 400, $destination = '') {

        // Content type
        // header('Content-Type: image/jpeg');
        // Get new dimensions
        list($width_orig, $height_orig) = getimagesize($filename);

        // Output 20 May, 2018 updated below part
        if ($destination == '' || $destination == null)
            $destination = $filename;

        $extention = pathinfo($destination, PATHINFO_EXTENSION);
        if ($extention != "png" && $extention != "PNG" && $extention != "JPEG" && $extention != "jpeg" && $extention != "jpg" && $extention != "JPG") {
 
            return true;
        }
        // Resample
        $image_p = imagecreatetruecolor($width, $height);
        $image   = imagecreatefromstring(file_get_contents($filename));
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

        

        if ($extention == "png" || $extention == "PNG") {
            imagepng($image_p, $destination, 9);
        } else if ($extention == "jpg" || $extention == "JPG" || $extention == "jpeg" || $extention == "JPEG") {
            imagejpeg($image_p, $destination, 70);
        } else {
            imagepng($image_p, $destination);
        }
        return true;
    }

    public function get_division() {

        $result = $this->db->select('id, name')->get('tbl_divission')->result();
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function get_zilla_from_division($division_id = 1) {

        $result = $this->db->select('id, name')->where('divission_id', $division_id)->get('tbl_zilla')->result();
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function get_upozilla_from_division_zilla($zilla_id = 1) {

        $result = $this->db->select('id, name')->where('zilla_id', $zilla_id)->get('tbl_upozilla')->result();
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function download_file($file_name = '', $fullpath='') {

        // echo $file_name; exit();
        $filePath = $file_name;

        if($file_name=='full' && ($fullpath != '' || $fullpath != null)) $filePath = $fullpath;

        if($_GET['file_path']) $filePath = $_GET['file_path'];
        // echo $filePath; exit();
        if (file_exists($filePath)) {
            $fileName = basename($filePath);
            $fileSize = filesize($filePath);

            // Output headers.
            header("Cache-Control: private");
            header("Content-Type: application/stream");
            header("Content-Length: " . $fileSize);
            header("Content-Disposition: attachment; filename=" . $fileName);

            // Output file.
            readfile($filePath);
            exit();
        } else {
            die('The provided file path is not valid.');
        }
    }
    
    public function profile($param1 = '')
    {

        $user_id            = $this->session->userdata('userid');
        $data['user_info']  = $this->AccountsModel->get_user($user_id);


        $myzilla_id         = $data['user_info']->zilla_id;
        $mydivision_id      = $data['user_info']->division_id;

        $data['divissions'] = $this->db->get('tbl_divission')->result();

        $data['distrcts']   = $this->db->get_where('tbl_zilla', array('divission_id' => $mydivision_id))->result();
        $data['upozilla']   = $this->db->get_where('tbl_upozilla', array('zilla_id'  => $myzilla_id))->result();



        if ($param1 == 'update_photo') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                   
                //exta work
                $path_parts               = pathinfo($_FILES["photo"]['name']);
                $newfile_name             = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
                $dir                      = date("YmdHis", time());
                $config['file_name']      = $newfile_name . '_' . $dir;
                $config['remove_spaces']  = TRUE;
                //exta work
                $config['upload_path']    = 'assets/userPhoto/';
                $config['max_size']       = '20000'; //  less than 20 MB
                $config['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('photo')) {

                    // case - failure
                    $upload_error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('message', "Failed to update image.");

                } else {

                    $upload                 = $this->upload->data();
                    $newphotoadd['photo']   = $config['upload_path'] . $upload['file_name'];

                    $old_photo              = $this->db->where('id', $user_id)->get('user')->row()->photo;
                    
                    if(file_exists($old_photo)) unlink($old_photo);

                    $this->image_size_fix($newphotoadd['photo'], 200, 200);

                    $this->db->where('id', $user_id)->update('user', $newphotoadd);

                    $this->session->set_userdata('userPhoto', $newphotoadd['photo']);
                    $this->session->set_flashdata('message', 'User Photo Updated Successfully!');
                    
                    redirect('accounts/profile','refresh');
                }
                
              }
              
        }else if($param1 == 'update_pass'){

           if ($_SERVER['REQUEST_METHOD'] == 'POST') {
               
               $old_pass    = sha1($this->input->post('old_pass', true)); 
               $new_pass    = sha1($this->input->post('new_pass', true)); 
               $user_id     = $this->session->userdata('userid');

               $get_user    = $this->db->get_where('user',array('id'=>$user_id, 'password'=>$old_pass));
               $user_exist  = $get_user->row();

               if($user_exist){
                   
                    $this->db->where('id',$user_id)
                            ->update('user',array('password'=>$new_pass));
                    $this->session->set_flashdata('message', 'Password Updated Successfully');
                    redirect('accounts/profile','refresh');
                    
               }else{
                   
                    $this->session->set_flashdata('message', 'Password Update Failed');
                    redirect('accounts/profile','refresh');
                   
               }
               
            }
            
        }else if($param1 == 'update_info'){

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                $update_data['firstname']   = $this->input->post('firstname', true);
                $update_data['lastname']    = $this->input->post('lastname', true);
                $update_data['roadHouse']   = $this->input->post('roadHouse', true);
                $update_data['address']     = $this->input->post('address', true);


                $db_email     = $this->db->where('id!=', $user_id)->where('email', $this->input->post('email', true))->get('user')->num_rows();
                $db_username  = $this->db->where('id!=', $user_id)->where('username', $this->input->post('username', true))->get('user')->num_rows();


                if ( $db_username == 0) {

                     $update_data['username']    = $this->input->post('username', true);
                     
                }if ( $db_email == 0) {

                     $update_data['email']       = $this->input->post('email', true);
                     
                }
                

                if ($this->AccountsModel->update_pro_info($update_data, $user_id)) {
                    
                    $this->session->set_userdata('username_first', $update_data['firstname']);
                    $this->session->set_userdata('username_last', $update_data['lastname']);
                    $this->session->set_userdata('username', $update_data['username']);
                    
                    $this->session->set_flashdata('message', 'Information Updated Successfully!');
                    redirect('accounts/profile', 'refresh');
                    
                } else {
                    
                    $this->session->set_flashdata('message', 'Information Update Failed!');
                    redirect('accounts/profile', 'refresh');
                    
                } 
                
            }
        }
        
        $data['title']      = 'Profile user Panel • HRSOFTBD News Portal user Panel';
        $data['activeMenu'] = 'Profile';
        $data['page']       = 'backEnd/accounts/profile';
        
        $this->load->view('backEnd/master_page',$data);
    }

     //test details
    public function test_details($param1 = 'add', $param2 = '', $param3 = '') {
        
        if ($param1 == 'list') {

            $data = array();

            $data['search']['invoice_number'] = '';
            $data['search']['start_date']     = '';
            $data['search']['end_date']       = '';
            $data['search']['print']          = false;

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                if ($this->input->post('start_date', true)){

                    $data['search']['start_date']     = date('Y-m-d', strtotime($this->input->post('start_date', true)));
                }

                if ($this->input->post('end_date', true)){

                    $data['search']['end_date']       = date('Y-m-d', strtotime($this->input->post('end_date', true)));
                }

                if ($this->input->post('invoice_number', true)){

                    $data['search']['invoice_number']    = $this->input->post('invoice_number', true);
                }

                $data['search']['print']          = true;   

            }


            $data['test_list']     =  $this->AccountsModel->test_list($data['search']);
            

            $data['invoice_number_list'] = $this->db->select('id, invoice_number')->get('tbl_tests')->result();

            $data['title']         = 'Test details List';
            $data['page']          = 'backEnd/accounts/test_list';
            $data['activeMenu']    = 'test_details_list';

        } elseif ($param1 == 'view' && (int) $param2 > 0) {

            $data['test']          = $this->AccountsModel->get_test_data($param2);

            $data['test_details']  = $this->AccountsModel->get_test_details_data($param2);
            $data['paid_amount']   = $this->AccountsModel->get_paid_amount($param2);
            

            $data['title']         = 'Test details List';
            $data['page']          = 'backEnd/accounts/test_view';
            $data['activeMenu']    = 'test_details_list';

        }  else {

            $this->session->set_flashdata('message','Wrong Attempt!');
            redirect('accounts/test-details/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //test invoice details print
    public function test_details_print($param2)
    {
        
        $data['test']          = $this->AdminModel->get_test_data($param2);

        $data['test_details']  = $this->AdminModel->get_test_details_data($param2);

        $data['paid_amount']   = $this->AdminModel->get_paid_amount($param2);

        $this->load->view('backEnd/print_page/test_details_print', $data);
        
    }


    //account head
    public function account_head($param1 = '', $param2 = '', $param3 = '')
    {

        if ($param1 == 'add') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $insert_account_head['account_head']  = $this->input->post('account_head', true);
                $insert_account_head['accounts_type'] = $this->input->post('accounts_type', true);
                $insert_account_head['readonly']      = $this->input->post('readonly', true);
                $insert_account_head['insert_by']     = $_SESSION['userid'];
                $insert_account_head['insert_time']   = date('Y-m-d H:i');

                $add_account_head = $this->db->insert('tbl_accounts_category', $insert_account_head);

                if ($add_account_head) {

                    $this->session->set_flashdata('message','Account Head Added Successfully!');
                    redirect('accounts/account-head','refresh');

                } else {

                    $this->session->set_flashdata('message','Account Head Add Failed!');
                    redirect('accounts/account-head','refresh');

                }
                
            }           

        } elseif ($param1 == 'edit' && $param2 > 0) {

            $data['edit_info'] = $this->db->get_where('tbl_accounts_category',array('id'=>$param2));

            if ($data['edit_info']->num_rows() > 0) {

                $data['edit_info']    = $data['edit_info']->row();
                $data['edit_info_id'] = $param2;

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $update_account_head['account_head']  = $this->input->post('account_head', true);
                    $update_account_head['accounts_type'] = $this->input->post('accounts_type', true);
                    $update_account_head['readonly']      = $this->input->post('readonly', true);

                    if ($this->AccountsModel->account_head_update($update_account_head, $param2)) {

                        $this->session->set_flashdata('message','Account Head Updated Successfully!');
                        redirect('accounts/account-head/list/','refresh');

                    } else {

                        $this->session->set_flashdata('message','Account Head Update Failed!');
                        redirect('accounts/account-head/edit/'.$param2,'refresh');

                    }
                    
                }

            } else {

                $this->session->set_flashdata('message','Wrong Attempt!');
                redirect('accounts/account-head','refresh');
            }
            

        } elseif ($param1 == 'delete' && $param2 > 0) {

            $account_head_delete = $this->db->where('id', $param2)->where('readonly', 0)->delete('tbl_accounts_category');
            

            if ($account_head_delete) {

                $this->session->set_flashdata('message','Account Head Deleted Successfully!');
                redirect('accounts/account-head','refresh');

            } else {

                $this->session->set_flashdata('message','Account Head Delete Failed!');
                redirect('accounts/account-head','refresh');

            }

        }

        $data['title']        = 'Account Head';
        $data['activeMenu']   = 'account_head';
        $data['page']         = 'backEnd/accounts/account_head';
        
        $data['account_head'] = $this->db->order_by('id','desc')->get('tbl_accounts_category')->result();

        $this->load->view('backEnd/master_page',$data);
    }

    //test payment
    public function test_payment($param1 = 'add', $param2 = '', $param3 = '') {
        
        if ($param1 == 'add') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $test_payment_data['tests_id']            = $this->input->post('tests_id', true);
                $test_payment_data['patient_id']          = $this->input->post('patient_id', true);
                $test_payment_data['paid_amount']         = $this->input->post('paid_amount', true);
                $test_payment_data['paid_date']           = date('Y-m-d', strtotime($this->input->post('paid_date', true)));
                $test_payment_data['payment_approved']    = 1;
                $test_payment_data['insert_by']           = $_SESSION['userid'];
                $test_payment_data['insert_time']         = date('Y-m-d H:i');

                $add_test_payment = $this->db->insert('tbl_test_payment', $test_payment_data);

                if ($add_test_payment) {

                    $this->session->set_flashdata('message','Test payment Created Successfully!');
                    redirect('accounts/test-payment/list', 'refresh');

                } else {

                    $this->session->set_flashdata('message','Test payment Failed!');
                    redirect('accounts/test-payment', 'refresh');
                }
            }

 
            $data['title']         = 'Test payment Add';
            $data['page']          = 'backEnd/accounts/test_payment_add';
            $data['activeMenu']    = 'test_payment_add';
            
        } elseif ($param1 == 'list') {

            $data = array();

            $data['search']['start_date'] = '';
            $data['search']['end_date']   = '';
            $data['search']['patient_id'] = '';
            $data['search']['tests_id']   = '';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                if ($this->input->post('start_date', true)){

                    $data['search']['start_date']     = date('Y-m-d', strtotime($this->input->post('start_date', true)));
                }

                if ($this->input->post('end_date', true)){

                    $data['search']['end_date']     = date('Y-m-d', strtotime($this->input->post('end_date', true)));
                }

                if ($this->input->post('patient_id', true)){

                    $data['search']['patient_id']     = $this->input->post('patient_id', true);
                }

                if ($this->input->post('tests_id', true)){

                    $data['search']['tests_id']     = $this->input->post('tests_id', true);
                }

    
            }

            
            $data['test_payment_list'] =  $this->AccountsModel->test_payment_list($data['search']);
            $data['patient_list']      = $this->db->select('id, patient_name, patient_phone')->order_by('insert_time', 'DESC')->get('tbl_patient')->result();
            $data['tests_list']        = $this->db->select('id, invoice_number')->order_by('insert_time', 'DESC')->get('tbl_tests')->result();

            $data['title']         = 'Test payment List';
            $data['page']          = 'backEnd/accounts/test_payment_list';
            $data['activeMenu']    = 'test_payment_list';

            
        }elseif ($param1 == 'due') {

            $data['search']['start_date'] = '';
            $data['search']['end_date']   = '';
            $data['search']['patient_id'] = '';

            $data['due_report_list'] = array();

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                if ($this->input->post('start_date', true)){

                    $data['search']['start_date']     = date('Y-m-d', strtotime($this->input->post('start_date', true)));
                }

                if ($this->input->post('end_date', true)){

                    $data['search']['end_date']     = date('Y-m-d', strtotime($this->input->post('end_date', true)));
                }

                if ($this->input->post('patient_id', true)){

                    $data['search']['patient_id']     = $this->input->post('patient_id', true);
                }

                $data['due_report_list'] = $this->AccountsModel->get_due_report($data['search']);
                
            }

            
          

            $data['patient_list']  = $this->db->select('id, patient_name, patient_phone')->order_by('insert_time', 'DESC')->get('tbl_patient')->result();

            $data['title']         = 'Due Report';
            $data['page']          = 'backEnd/accounts/due_report';
            $data['activeMenu']    = 'due_report';

        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

            $data['edit_info']    = $this->db->where('id', $param2)->get('tbl_test_payment')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $update_test_payment_data['tests_id']            = $this->input->post('tests_id', true);
                $update_test_payment_data['patient_id']          = $this->input->post('patient_id', true);
                $update_test_payment_data['paid_amount']         = $this->input->post('paid_amount', true);
                $update_test_payment_data['paid_date']           = date('Y-m-d', strtotime($this->input->post('paid_date', true)));
                $update_test_payment_data['payment_approved']    = $this->input->post('payment_approved', true);


                if ($this->AccountsModel->update_test_payment($update_test_payment_data, $param2)) {

                $this->session->set_flashdata('message','Test payment  Updated Successfully!');
                redirect('accounts/test-payment/list', 'refresh');

                } else {

                   $this->session->set_flashdata('message','Test payment Update Failed!');
                    redirect('accounts/test-payment/edit/'.$param2, 'refresh');
                }

            }

            $data['title']         = 'Test payment Update';
            $data['page']          = 'backEnd/accounts/test_payment_edit';
            $data['activeMenu']    = 'test_payment_edit';
            
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

            if ($this->AccountsModel->delete_test_payment($param2)) {

                $this->session->set_flashdata('message','Test payment Deleted Successfully!');
                redirect('accounts/test-payment/list', 'refresh');

            } else {

                $this->session->set_flashdata('message','Test payment Deleted Failed!');
                redirect('accounts/test-payment/list', 'refresh');
            }

        } elseif ($param1 == 'approved' && (int) $param2 > 0) {

            if ($this->AccountsModel->approved_test_payment($param2)) {

                $this->session->set_flashdata('message','Test payment approved Successfully!');
                redirect('accounts/test-payment/list', 'refresh');

            } else {

                $this->session->set_flashdata('message','Test payment approved Failed!');
                redirect('accounts/test-payment/list', 'refresh');
            }

        } else {

            $this->session->set_flashdata('message','Wrong Attempt!');
            redirect('accounts/test-payment/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //invoice list print for search
    public function tests_list_print()
    {

        $data['start_date'] = '';
        $data['end_date']   = '';
        $data['invoice_number']    = '';

        if($_SERVER['REQUEST_METHOD'] == 'GET'){


            if ($this->input->get('start_date', true)){

                $data['start_date']     = date('Y-m-d', strtotime($this->input->get('start_date', true)));
            }
            if ($this->input->get('end_date', true)){

                $data['end_date']     = date('Y-m-d', strtotime($this->input->get('end_date', true)));
            }
            if ($this->input->get('invoice_number', true)){

                $data['invoice_number']     = $this->input->get('invoice_number', true);
            }

        }

        $data['tests_list']     =  $this->AdminModel->tests_list($data);

        $this->load->view('backEnd/print_page/tests_list_print', $data);

        // echo "<pre>";
        // print_r($data['tests_list']);
        // exit;
    }

    //get patients data   for test payment
    public function get_patients_data()
    {
        
        $result = $this->db->select('id, patient_name, patient_phone')->order_by('insert_time', 'DESC')->get('tbl_patient')->result();
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    //get test data on change of patient for test payment
    public function get_tests_data($patient_id = 1)
    {
        
        $result = $this->db->select('id, invoice_number')->order_by('insert_time', 'DESC')->where('patient_id', $patient_id)->get('tbl_tests')->result();
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    //accounts
    public function accounts($param1 = 'add', $param2 = '', $param3 = '') {
        
        if ($param1 == 'add') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $accounts_data['accounts_type_id']     = $this->input->post('accounts_type', true);
                $accounts_data['accounts_date']        = date('Y-m-d', strtotime($this->input->post('accounts_date', true)));
                $accounts_data['invoice_number']       = date('YmdHis');
                $accounts_data['is_official_accounts'] = 1;
                $accounts_data['amount']               = $this->input->post('total_amount', true);
                $accounts_data['insert_by']            = $_SESSION['userid'];
                $accounts_data['insert_time']          = date('Y-m-d H:i');

                $this->db->insert('tbl_accounts', $accounts_data);

                $accounts_details_data['invoice_number'] = $accounts_data['invoice_number'];
                $accounts_details_data['insert_time']    = date('Y-m-d H:i');
                

                foreach ($this->input->post('amount', true) as $key => $value) {

                    if($value < 1) continue;

                    $accounts_details_data['accounts_category_id'] = $this->input->post('accounts_type_id', true)[$key];
                    $accounts_details_data['description']          = $this->input->post('description', true)[$key];
                    $accounts_details_data['quantity']             = $this->input->post('quantity', true)[$key];
                    $accounts_details_data['amount']               = $value;

                    $this->db->insert('tbl_accounts_details', $accounts_details_data);
                }

                if (true) {

                    $this->session->set_flashdata('message','Accounts Created Successfully!');
                    redirect('accounts/accounts/list', 'refresh');

                } else {

                    $this->session->set_flashdata('message','Accounts Failed!');
                    redirect('accounts/accounts', 'refresh');
                }
            }

            $data['accounts_head_list'] = $this->db->order_by('id', 'DESC')->get('tbl_accounts_category')->result();

            $data['title']         = 'Accounts Add';
            $data['page']          = 'backEnd/accounts/accounts_add';
            $data['activeMenu']    = 'accounts_add';
            
        } elseif ($param1 == 'list') {

            $data = array();

            $data['search']['date']     = '';
            $data['search']['end_date']       = '';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                if ($this->input->post('date', true)){

                    $data['search']['date']     = date('Y-m-d', strtotime($this->input->post('date', true)));
                }
    
            }

            $config = array();
            $config["base_url"] = base_url() . "accounts/accounts/list";
            $config["total_rows"] = $this->db->count_all('tbl_accounts');
            $config["per_page"] = 10;
            $config["uri_segment"] = 4;

            //custom
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            
            $config['first_link'] = "First";
            $config['last_link'] = "Last";
            
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
                
            $config['prev_link'] = '«';
            $config['prev_tag_open'] = '<li class="prev">';
            $config['prev_tag_close'] = '</li>';
            
            $config['next_link'] = '»';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            
            $config['cur_tag_open'] = '<li class="active"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $data["links"] = $this->pagination->create_links();

            $data['accounts_list']     =  $this->AccountsModel->accounts_list($config["per_page"], $page, $data['search']);

            $data['title']         = 'Accounts List';
            $data['page']          = 'backEnd/accounts/accounts_list';
            $data['activeMenu']    = 'accounts_list';
            
        } elseif ($param1 == 'view' && (int) $param2 > 0) {

            $data['accounts_info'] = $this->db->select('tbl_accounts.id, tbl_accounts.accounts_date, tbl_accounts.accounts_type_id, tbl_accounts.insert_time, tbl_accounts.invoice_number, user.firstname, user.lastname')->join('user', 'user.id = tbl_accounts.insert_by', 'left')->where('tbl_accounts.id', $param2)->get('tbl_accounts')->row();

            $invoice_number = $data['accounts_info']->invoice_number;

            $data['accounts_details'] = $this->AccountsModel->get_accounts_details_data($invoice_number);
            
            $data['title']         = 'Accounts View';
            $data['page']          = 'backEnd/accounts/accounts_view';
            $data['activeMenu']    = 'accounts_view';
            
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

            if ($this->AccountsModel->delete_accounts($param2)) {

                $this->session->set_flashdata('message','Accounts Deleted Successfully!');
                redirect('accounts/accounts/list', 'refresh');

            } else {

                $this->session->set_flashdata('message','Accounts Deleted Failed!');
                redirect('accounts/accounts/list', 'refresh');
            }

        } else {

            $this->session->set_flashdata('message','Wrong Attempt!');
            redirect('accounts/accounts/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //accounts print
    public function accounts_print($param2)
    {

        $data['accounts_info'] = $this->db->select('tbl_accounts.id, tbl_accounts.accounts_date, tbl_accounts.accounts_type_id, tbl_accounts.insert_time, tbl_accounts.invoice_number, user.firstname, user.lastname')->join('user', 'user.id = tbl_accounts.insert_by', 'left')->where('tbl_accounts.id', $param2)->get('tbl_accounts')->row();

        $invoice_number = $data['accounts_info']->invoice_number;

        $data['accounts_details'] = $this->AccountsModel->get_accounts_details_data($invoice_number);
        
        $this->load->view('backEnd/print_page/accounts_print', $data);
    }

    //ajax call for accounts head change on accounts type (income or expense)
    public function get_accounts_head_type($type = 1)
    {

        $result = $this->db->select('id, account_head')->where('accounts_type', $type)->get('tbl_accounts_category')->result();
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        
    }

    //referrer report
    public function referrer_report()
    {
        $data['search']['start_date'] = '';
        $data['search']['end_date']   = '';
        $data['search']['user_id']    = '';
        $data['search']['print'] = false;

        $data['referrer_report_list'] = array();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if ($this->input->post('start_date', true)){

                $data['search']['start_date']     = date('Y-m-d', strtotime($this->input->post('start_date', true)));
            }

            if ($this->input->post('end_date', true)){

                $data['search']['end_date']     = date('Y-m-d', strtotime($this->input->post('end_date', true)));
            }

            if ($this->input->post('user_id', true)){

                $data['search']['user_id']     = $this->input->post('user_id', true);
            }

            $data['search']['print'] = true;


            $data['referrer_report_list']  = $this->AccountsModel->get_referrer_report($data['search']);
        }

        
        
        $data['referred_list']      = $this->db->select('id, firstname, lastname')->where('userType', 'doctor')->get('user')->result();

        $data['title']         = 'Referrer Report';
        $data['page']          = 'backEnd/accounts/referrer_report';
        $data['activeMenu']    = 'referrer_report';
        
        $this->load->view('backEnd/master_page', $data);
    }

    //referrer list print
    public function referrer_list_print()
    {

        $data['start_date'] = '';
        $data['end_date']   = '';
        $data['user_id']    = '';

        if($_SERVER['REQUEST_METHOD'] == 'GET'){


            if ($this->input->get('start_date', true)){

                $data['start_date']     = date('Y-m-d', strtotime($this->input->get('start_date', true)));
            }
            if ($this->input->get('end_date', true)){

                $data['end_date']     = date('Y-m-d', strtotime($this->input->get('end_date', true)));
            }
            if ($this->input->get('user_id', true)){

                $data['user_id']     = $this->input->get('user_id', true);
            }

        }

        $data['referrer_report_list']  = $this->AccountsModel->get_referrer_report($data);
        
        $this->load->view('backEnd/print_page/referrer_report_print', $data);
     

    }

    //test view payment
    public function make_payment_from_invoice($tests_id, $patient_id, $paid_amount)
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $payment_data['tests_id']    = $tests_id;
            $payment_data['patient_id']  = $patient_id;
            $payment_data['paid_amount'] = $paid_amount;
            $payment_data['paid_date']           = date('Y-m-d');
            $payment_data['payment_approved']    = 1;
            $payment_data['insert_by']           = $_SESSION['userid'];
            $payment_data['insert_time']         = date('Y-m-d H:i');
            

            $add_test_payment = $this->db->insert('tbl_test_payment', $payment_data);

            if ($add_test_payment) {

                echo json_encode("ok");

            } else {

                echo json_encode("err");
            }
        }
        
        
    }

}
