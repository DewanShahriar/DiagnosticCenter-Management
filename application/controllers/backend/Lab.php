<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lab extends CI_Controller {

    function __construct() {

        parent::__construct();

        $this->lang->load('content', $_SESSION['lang']);

        if (!isset($_SESSION['user_auth']) || $_SESSION['user_auth'] != true) {
            redirect('login', 'refresh');
        }
        if ($_SESSION['userType'] != 'lab')
            redirect('login', 'refresh');

        $this->load->model('LabModel');
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

        $data['title']      = 'Lab Panel • HRSOFTBD';
        $data['page']       = 'backEnd/lab/lab_dashboard';
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
        $data['user_info']  = $this->LabModel->get_user($user_id);


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
                    
                    redirect('lab/profile','refresh');
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
                    redirect('lab/profile','refresh');
                    
               }else{
                   
                    $this->session->set_flashdata('message', 'Password Update Failed');
                    redirect('lab/profile','refresh');
                   
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
                

                if ($this->LabModel->update_pro_info($update_data, $user_id)) {
                    
                    $this->session->set_userdata('username_first', $update_data['firstname']);
                    $this->session->set_userdata('username_last', $update_data['lastname']);
                    $this->session->set_userdata('username', $update_data['username']);
                    
                    $this->session->set_flashdata('message', 'Information Updated Successfully!');
                    redirect('lab/profile', 'refresh');
                    
                } else {
                    
                    $this->session->set_flashdata('message', 'Information Update Failed!');
                    redirect('lab/profile', 'refresh');
                    
                } 
                
            }
        }
        
        $data['title']      = 'Profile user Panel • HRSOFTBD News Portal user Panel';
        $data['activeMenu'] = 'Profile';
        $data['page']       = 'backEnd/lab/profile';
        
        $this->load->view('backEnd/master_page',$data);
    }

    //test category
    public function test_category($param1 = 'add', $param2 = '', $param3 = '') {
        
        if ($param1 == 'add') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $test_category_data['name']           = $this->input->post('name', true);
                $test_category_data['insert_by']      = $_SESSION['userid'];
                $test_category_data['insert_time']    = date('Y-m-d H:i');

                $add_test_category = $this->db->insert('tbl_test_category', $test_category_data);

                if ($add_test_category) {

                    $this->session->set_flashdata('message','Test Category Created Successfully!');
                    redirect('lab/test-category/list', 'refresh');

                } else {

                    $this->session->set_flashdata('message','Test Category Failed!');
                    redirect('lab/test-category', 'refresh');
                }
            }

            $data['title']         = 'Test Category Add';
            $data['page']          = 'backEnd/lab/test_category_add';
            $data['activeMenu']    = 'test_category_add';
            
        } elseif ($param1 == 'list') {

            $data['title']         = 'Test Category List';
            $data['page']          = 'backEnd/lab/test_category_list';
            $data['activeMenu']    = 'test_category_list';

            $data['test_category_list'] =  $this->db->order_by('id', 'DESC')->get('tbl_test_category')->result();
            
        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

            $data['edit_info']    = $this->db->where('id', $param2)->get('tbl_test_category')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $update_test_category_data['name']           = $this->input->post('name', true);

                if ($this->LabModel->update_test_category($update_test_category_data, $param2)) {

                $this->session->set_flashdata('message','Test Category  Updated Successfully!');
                redirect('lab/test-category/list', 'refresh');

                } else {

                   $this->session->set_flashdata('message','Test Category Update Failed!');
                    redirect('lab/test-category/edit/'.$param2, 'refresh');
                }

            }

            $data['title']         = 'Test Category Update';
            $data['page']          = 'backEnd/lab/test_category_edit';
            $data['activeMenu']    = 'test_category_edit';
            
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

            if ($this->LabModel->delete_test_category($param2)) {

                $this->session->set_flashdata('message','Test Category  Deleted Successfully!');
                redirect('lab/test-category/list', 'refresh');

            } else {

                $this->session->set_flashdata('message','Test Category Deleted Failed!');
                redirect('lab/test-category/list', 'refresh');
            }

        } else {

            $this->session->set_flashdata('message','Wrong Attempt!');
            redirect('lab/test-category/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //test Name
    public function test_name($param1 = 'add', $param2 = '', $param3 = '') {
        
        if ($param1 == 'add') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $test_name_data['test_category_id']           = $this->input->post('test_category_id', true);
                $test_name_data['test_name']           = $this->input->post('test_name', true);
                $test_name_data['price']           = $this->input->post('price', true);
                $test_name_data['referral_commission']           = $this->input->post('referral_commission', true);
                $test_name_data['report_format']           = $this->input->post('report_format', true);
                $test_name_data['insert_by']      = $_SESSION['userid'];
                $test_name_data['insert_time']    = date('Y-m-d H:i');

                $add_test_name = $this->db->insert('tbl_test_name', $test_name_data);

                if ($add_test_name) {

                    $this->session->set_flashdata('message','Test Name Created Successfully!');
                    redirect('lab/test-name/list', 'refresh');

                } else {

                    $this->session->set_flashdata('message','Test Name Failed!');
                    redirect('lab/test-name', 'refresh');
                }
            }

            $data['test_category_list'] = $this->db->order_by('id', 'DESC')->get('tbl_test_category')->result();

            $data['title']         = 'Test Name Add';
            $data['page']          = 'backEnd/lab/test_name_add';
            $data['activeMenu']    = 'test_name_add';
            
        } elseif ($param1 == 'list') {

            $data['title']         = 'Test Name List';
            $data['page']          = 'backEnd/lab/test_name_list';
            $data['activeMenu']    = 'test_name_list';

            $data['test_name_list'] =  $this->LabModel->test_name_list();
            
        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

            $data['edit_info']    = $this->db->where('id', $param2)->get('tbl_test_name')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $update_test_name_data['test_category_id']           = $this->input->post('test_category_id', true);
                $update_test_name_data['test_name']           = $this->input->post('test_name', true);
                $update_test_name_data['price']           = $this->input->post('price', true);
                $update_test_name_data['referral_commission']           = $this->input->post('referral_commission', true);
                $update_test_name_data['report_format']           = $this->input->post('report_format', true);


                if ($this->LabModel->update_test_name($update_test_name_data, $param2)) {

                $this->session->set_flashdata('message','Test Name  Updated Successfully!');
                redirect('lab/test-name/list', 'refresh');

                } else {

                   $this->session->set_flashdata('message','Test Name Update Failed!');
                    redirect('lab/test-name/edit/'.$param2, 'refresh');
                }

            }

            $data['test_category_list'] = $this->db->order_by('id', 'DESC')->get('tbl_test_category')->result();

            $data['title']         = 'Test Name Update';
            $data['page']          = 'backEnd/lab/test_name_edit';
            $data['activeMenu']    = 'test_name_edit';
            
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

            if ($this->LabModel->delete_test_name($param2)) {

                $this->session->set_flashdata('message','Test Name Deleted Successfully!');
                redirect('lab/test-name/list', 'refresh');

            } else {

                $this->session->set_flashdata('message','Test Name Deleted Failed!');
                redirect('lab/test-name/list', 'refresh');
            }

        } else {

            $this->session->set_flashdata('message','Wrong Attempt!');
            redirect('lab/test-name/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //test name print
    public function test_name_print()
    {
        $data['test_name_list'] =  $this->LabModel->test_name_list();
        $this->load->view('backEnd/print_page/test_name_print', $data);

    }

    //patient
    public function patient($param1 = 'add', $param2 = '', $param3 = '') {
        
        if ($param1 == 'add') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $patient_data['patient_name']      = $this->input->post('patient_name', true);
                $patient_data['patient_phone']     = $this->input->post('patient_phone', true);
                $patient_data['father_name']       = $this->input->post('father_name', true);
                $patient_data['mother_name']       = $this->input->post('mother_name', true);
                $patient_data['patient_nid']       = $this->input->post('patient_nid', true);
                $patient_data['birth_date']        = date('Y-m-d', strtotime($this->input->post('birth_date', true)));
                $patient_data['address']           = $this->input->post('address', true);
                $patient_data['gender']            = $this->input->post('gender', true);
                $patient_data['insert_by']         = $_SESSION['userid'];
                $patient_data['insert_time']       = date('Y-m-d H:i');

                if (!empty($_FILES['photo']['name'])) {

                    $path_parts                 = pathinfo($_FILES["photo"]['name']);
                    $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
                    $dir                        = date("YmdHis", time());
                    $config_c['file_name']      = $newfile_name . '_' . $dir;
                    $config_c['remove_spaces']  = TRUE;
                    $config_c['upload_path']    = 'assets/userPhoto/';
                    $config_c['max_size']       = '20000'; //  less than 20 MB
                    $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

                    $this->load->library('upload', $config_c);
                    $this->upload->initialize($config_c);
                    if (!$this->upload->do_upload('photo')) {

                    } else {

                        $upload_c = $this->upload->data();
                        $patient_data['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
                        $this->image_size_fix($patient_data['photo'], 400, 400);
                    }
                    
                }

                $add_patient = $this->db->insert('tbl_patient', $patient_data);

                if ($add_patient) {

                    $this->session->set_flashdata('message','Patient Created Successfully!');
                    redirect('lab/patient/list', 'refresh');

                } else {

                    $this->session->set_flashdata('message','Patient Failed!');
                    redirect('lab/patient', 'refresh');
                }
            }

            $data['test_category_list'] = $this->db->order_by('id', 'DESC')->get('tbl_test_category')->result();

            $data['title']         = 'Patient Add';
            $data['page']          = 'backEnd/lab/patient_add';
            $data['activeMenu']    = 'patient_add';
            
        } elseif ($param1 == 'list') {

            $data['title']         = 'Patient List';
            $data['page']          = 'backEnd/lab/patient_list';
            $data['activeMenu']    = 'patient_list';

            $data['patient_list'] =  $this->db->order_by('insert_time', 'DESC')->get('tbl_patient')->result();
            
        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

            $data['edit_info']    = $this->db->where('id', $param2)->get('tbl_patient')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $patient_update_data['patient_name']      = $this->input->post('patient_name', true);
                $patient_update_data['patient_phone']     = $this->input->post('patient_phone', true);
                $patient_update_data['father_name']       = $this->input->post('father_name', true);
                $patient_update_data['mother_name']       = $this->input->post('mother_name', true);
                $patient_update_data['patient_nid']       = $this->input->post('patient_nid', true);
                $patient_update_data['birth_date']        = date('Y-m-d', strtotime($this->input->post('birth_date', true)));
                $patient_update_data['address']           = $this->input->post('address', true);
                $patient_update_data['gender']            = $this->input->post('gender', true);

                if (!empty($_FILES['photo']['name'])) {

                    $path_parts                 = pathinfo($_FILES["photo"]['name']);
                    $newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
                    $dir                        = date("YmdHis", time());
                    $config_c['file_name']      = $newfile_name . '_' . $dir;
                    $config_c['remove_spaces']  = TRUE;
                    $config_c['upload_path']    = 'assets/userPhoto/';
                    $config_c['max_size']       = '20000'; //  less than 20 MB
                    $config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

                    $this->load->library('upload', $config_c);
                    $this->upload->initialize($config_c);
                    if (!$this->upload->do_upload('photo')) {

                    } else {

                        $upload_c = $this->upload->data();
                        $patient_update_data['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
                        $this->image_size_fix($patient_update_data['photo'], 400, 400);
                    }
                    
                }


                if ($this->LabModel->update_patient($patient_update_data, $param2)) {

                $this->session->set_flashdata('message','Patient  Updated Successfully!');
                redirect('lab/patient/list', 'refresh');

                } else {

                   $this->session->set_flashdata('message','Patient Update Failed!');
                    redirect('lab/patient/edit/'.$param2, 'refresh');
                }

            }

            $data['test_category_list'] = $this->db->order_by('id', 'DESC')->get('tbl_test_category')->result();

            $data['title']         = 'Patient Update';
            $data['page']          = 'backEnd/lab/patient_edit';
            $data['activeMenu']    = 'test_name_edit';
            
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

            if ($this->LabModel->delete_patient($param2)) {

                $this->session->set_flashdata('message','Patient Deleted Successfully!');
                redirect('lab/patient/list', 'refresh');

            } else {

                $this->session->set_flashdata('message','Patient Deleted Failed!');
                redirect('lab/patient/list', 'refresh');
            }

        } else {

            $this->session->set_flashdata('message','Wrong Attempt!');
            redirect('lab/patient/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //test details
    public function test_details($param1 = 'add', $param2 = '', $param3 = '') {
        
        if ($param1 == 'add') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $tests_data = array();
                $tests_data['issue_date']           = date('Y-m-d', strtotime($this->input->post('issue_date', true)));
                $tests_data['referred_by']          = $this->input->post('referred_by', true);
                $tests_data['total_amount']         = $this->input->post('total_amount_id', true);
                $tests_data['discount_amount']      = $this->input->post('discount_amount', true);
                $tests_data['invoice_number']       = date('YmdHis');
                $tests_data['discount_option_id']   = $this->input->post('discount_option_id', true);
                $tests_data['discount_permit_by']   = $this->input->post('discount_permit_by', true);
                $tests_data['insert_time']          = date('Y-m-d H:i');
                $tests_data['insert_by']            = $_SESSION['userid'];

                $patient_type    = '';
                $patient_type    = $this->input->post('patient_type', true);
                $tests_data['patient_id']       = '';

                if ($patient_type == 0){
                    $tests_data['patient_id']       = $this->input->post('hiddenid', true);

                } else {

                    $patient_data['patient_name']      = $this->input->post('patient_name', true);
                    $patient_data['patient_phone']     = $this->input->post('patient_phone', true);
                    $patient_data['father_name']       = $this->input->post('father_name', true);
                    $patient_data['mother_name']       = $this->input->post('mother_name', true);
                    $patient_data['patient_nid']       = $this->input->post('patient_nid', true);
                    $patient_data['birth_date']        = date('Y-m-d', strtotime($this->input->post('birth_date', true)));
                    $patient_data['address']           = $this->input->post('address', true);
                    $patient_data['gender']            = $this->input->post('gender', true);
                    $patient_data['insert_by']         = $_SESSION['userid'];
                    $patient_data['insert_time']       = date('Y-m-d H:i');

                    $this->db->insert('tbl_patient', $patient_data);
                    $tests_data['patient_id']          = $this->db->insert_id();

                }

                $this->db->insert('tbl_tests', $tests_data);
                $last_id = $this->db->insert_id();
                $test_details_data['tests_id'] = $last_id;
                $test_details_data['insert_time'] = date('Y-m-d H:i');
                

                foreach ($this->input->post('amount', true) as $key => $value) {

                    if($value < 1) continue;

                    $test_details_data['tests_name_id'] = $this->input->post('tests_name_id', true)[$key];
                    $test_details_data['referrer_fee']  = $this->input->post('referrer_fee', true)[$key];
                    $test_details_data['test_report_details']  = $this->db->select('report_format')->where('id', $test_details_data['tests_name_id'])->get('tbl_test_name')->row()->report_format;
                    $test_details_data['test_bill']     = $value;
                    $test_details_data['report_publish_date'] = date('Y-m-d', strtotime($this->input->post('report_publish_date', true)[$key]));

                    $this->db->insert('tbl_tests_details', $test_details_data);

                }

                $patient_name = $this->db->select('tbl_patient.patient_name')->join('tbl_patient', 'tbl_patient.id = tbl_tests.patient_id', 'left')->where('tbl_tests.id', $last_id)->get('tbl_tests')->row()->patient_name;

                $accounts_data['accounts_date'] = date('Y-m-d');
                $accounts_data['accounts_type_id'] = 1;
                $accounts_data['invoice_number'] = $tests_data['invoice_number'];
                $accounts_data['is_official_accounts'] = 0;
                $accounts_data['amount'] = $tests_data['total_amount'] - $tests_data['discount_amount'];
                $accounts_data['insert_time'] = date('Y-m-d H:i');
                $accounts_data['insert_by'] = $_SESSION['userid'];

                
                $accounts_details_data['accounts_category_id'] = 1;
                $accounts_details_data['invoice_number'] = $tests_data['invoice_number'];
                $accounts_details_data['quantity'] = 1;
                $accounts_details_data['amount'] = $accounts_data['amount'];
                $accounts_details_data['description'] = 'Bill of Mr. '.$patient_name;
                $accounts_details_data['insert_time'] = date('Y-m-d H:i');
                
                $this->db->insert('tbl_accounts', $accounts_data);
                $this->db->insert('tbl_accounts_details', $accounts_details_data);
 
                if (true) {

                    $this->session->set_flashdata('message','Test Details target Created Successfully!');
                    redirect('lab/test-details/list', 'refresh');

                } else {

                    $this->session->set_flashdata('message','Test Details target Failed!');
                    redirect('lab/test-details', 'refresh');
                }
                
            }

            $data['discount_option_list'] = $this->db->get('tbl_discount_option')->result();

            $data['test_category_list'] = $this->db->order_by('id', 'DESC')->get('tbl_test_category')->result();
            $data['referred_list']      = $this->db->select('id, firstname, lastname')->where('userType', 'doctor')->get('user')->result();
            $data['test_name_list']     = $this->db->select('id, test_name')->get('tbl_test_name')->result();

 
            $data['title']         = 'Test details Add';
            $data['page']          = 'backEnd/lab/test_details_add';
            $data['activeMenu']    = 'test_details_add';
            
        } elseif ($param1 == 'list') {

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


            $data['test_list']     =  $this->LabModel->test_list($data['search']);
            // echo "<pre>";
            // print_r($data['test_list']);
            // exit;

            $data['invoice_number_list'] = $this->db->select('id, invoice_number')->get('tbl_tests')->result();

            $data['title']         = 'Test details List';
            $data['page']          = 'backEnd/lab/test_list';
            $data['activeMenu']    = 'test_details_list';

        } elseif ($param1 == 'view' && (int) $param2 > 0) {

            $data['test']          = $this->LabModel->get_test_data($param2);

            $data['test_details']  = $this->LabModel->get_test_details_data($param2);
            $data['paid_amount']   = $this->LabModel->get_paid_amount($param2);
            // echo "<pre>";
            // print_r($data['paid_amount']);
            // exit;

            $data['title']         = 'Test details List';
            $data['page']          = 'backEnd/lab/test_view';
            $data['activeMenu']    = 'test_details_list';

        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

            if ($this->LabModel->delete_tests($param2)) {

                $this->session->set_flashdata('message','Test details Deleted Successfully!');
                redirect('lab/test-details/list', 'refresh');

            } else {

                $this->session->set_flashdata('message','Test details Deleted Failed!');
                redirect('lab/test-details/list', 'refresh');
            }

        } else {

            $this->session->set_flashdata('message','Wrong Attempt!');
            redirect('lab/test-details/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //test invoice details print
    public function test_details_print($param2)
    {
        
        $data['test']          = $this->LabModel->get_test_data($param2);

        $data['test_details']  = $this->LabModel->get_test_details_data($param2);

        $data['paid_amount']   = $this->LabModel->get_paid_amount($param2);

        $this->load->view('backEnd/print_page/test_details_print', $data);
        
    }

    public function test_report_print()
    {

        $test_details_id  = $this->input->get('test_details_id', true);
        $test_id          = $this->input->get('test_id', true);
        $patient_id       = $this->input->get('patient_id', true);
        $data['patient_details'] = $this->db->where('id', $patient_id)->get('tbl_patient')->row();
        $data['test_invoice'] = $this->db->select('invoice_number')->where('id', $test_id)->get('tbl_tests')->row()->invoice_number;
        $data['test_details_report'] = $this->db->select('test_report_details')->where('id', $test_details_id)->get('tbl_tests_details')->row()->test_report_details;
        $data['test_name'] = $this->db->select('tbl_test_name.test_name')->join('tbl_test_name', 'tbl_test_name.id = tbl_tests_details.tests_name_id', 'left')->where('tbl_tests_details.id', $test_details_id)->get('tbl_tests_details')->row()->test_name;
        
        // echo "<pre>";
        // print_r($test_details_id);
        // exit;
        $this->load->view('backEnd/print_page/test_report_print', $data);
        
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

        $data['tests_list']     =  $this->LabModel->tests_list($data);

        $this->load->view('backEnd/print_page/tests_list_print', $data);

        // echo "<pre>";
        // print_r($data['tests_list']);
        // exit;
    }


    //get test print and referrer commission for invoice generate
    public function get_test_amount($test_name_id){
        
        $result = $this->db->select('price, referral_commission')->where('id', $test_name_id)->get('tbl_test_name')->row(); 
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        
    }

    //get patient list for autocomplete
    public function patient_search()
    {
        $search_data = strtolower($this->input->post('search', true));
        $result      = $this->LabModel->patient_data_search($search_data);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    //test details report details update
    public function report_format_update()
    {
        $test_details_id  = $this->input->post('test_details_id', true);
        $test_id          = $this->input->post('test_id', true);
        $update_data['test_report_details'] = $this->input->post('report_format', true);
        $update_data['report_upload_time']  = date('Y-m-d H:s');
        // echo "<pre>";
        // print_r($test_details_id);
        // exit;
        $this->db->where('id',$test_details_id)->update('tbl_tests_details', $update_data);

        if(true){
            $this->session->set_flashdata('message','Test Report  Format Successfully Updated');
            redirect('lab/test-details/view/'.$test_id, 'refresh');
        } else{
            $this->session->set_flashdata('message','Test Report  Format Update Failed');
            redirect('lab/test-details/view/'.$test_id, 'refresh');
        }

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
                    redirect('lab/test-payment/list', 'refresh');

                } else {

                    $this->session->set_flashdata('message','Test payment Failed!');
                    redirect('lab/test-payment', 'refresh');
                }
            }

 
            $data['title']         = 'Test payment Add';
            $data['page']          = 'backEnd/lab/test_payment_add';
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

            

            $data['test_payment_list'] =  $this->LabModel->test_payment_list($data['search']);
            $data['patient_list']      = $this->db->select('id, patient_name, patient_phone')->order_by('insert_time', 'DESC')->get('tbl_patient')->result();
            $data['tests_list']        = $this->db->select('id, invoice_number')->order_by('insert_time', 'DESC')->get('tbl_tests')->result();

            $data['title']         = 'Test payment List';
            $data['page']          = 'backEnd/lab/test_payment_list';
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

                $data['due_report_list'] = $this->LabModel->get_due_report($data['search']);
                
            }

            
            // echo "<pre>";
            // print_r($data['due_report_list']);
            // exit;

            $data['patient_list']  = $this->db->select('id, patient_name, patient_phone')->order_by('insert_time', 'DESC')->get('tbl_patient')->result();

            $data['title']         = 'Due Report';
            $data['page']          = 'backEnd/lab/due_report';
            $data['activeMenu']    = 'due_report';

        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

            $data['edit_info']    = $this->db->where('id', $param2)->get('tbl_test_payment')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $update_test_payment_data['tests_id']            = $this->input->post('tests_id', true);
                $update_test_payment_data['patient_id']          = $this->input->post('patient_id', true);
                $update_test_payment_data['paid_amount']         = $this->input->post('paid_amount', true);
                $update_test_payment_data['paid_date']           = date('Y-m-d', strtotime($this->input->post('paid_date', true)));
                $update_test_payment_data['payment_approved']    = $this->input->post('payment_approved', true);


                if ($this->LabModel->update_test_payment($update_test_payment_data, $param2)) {

                $this->session->set_flashdata('message','Test payment  Updated Successfully!');
                redirect('lab/test-payment/list', 'refresh');

                } else {

                   $this->session->set_flashdata('message','Test payment Update Failed!');
                    redirect('lab/test-payment/edit/'.$param2, 'refresh');
                }

            }

            $data['title']         = 'Test payment Update';
            $data['page']          = 'backEnd/lab/test_payment_edit';
            $data['activeMenu']    = 'test_payment_edit';
            
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

            if ($this->LabModel->delete_test_payment($param2)) {

                $this->session->set_flashdata('message','Test payment Deleted Successfully!');
                redirect('lab/test-payment/list', 'refresh');

            } else {

                $this->session->set_flashdata('message','Test payment Deleted Failed!');
                redirect('lab/test-payment/list', 'refresh');
            }

        } elseif ($param1 == 'approved' && (int) $param2 > 0) {

            if ($this->LabModel->approved_test_payment($param2)) {

                $this->session->set_flashdata('message','Test payment approved Successfully!');
                redirect('lab/test-payment/list', 'refresh');

            } else {

                $this->session->set_flashdata('message','Test payment approved Failed!');
                redirect('lab/test-payment/list', 'refresh');
            }

        } else {

            $this->session->set_flashdata('message','Wrong Attempt!');
            redirect('lab/test-payment/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
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
            // echo "<pre>";
            // print_r($payment_data);
            // exit;

            $add_test_payment = $this->db->insert('tbl_test_payment', $payment_data);

            if ($add_test_payment) {

                echo json_encode("ok");

            } else {

                echo json_encode("err");
            }
        }
        
        
    }

    public function modal_data($test_details_id)
    {
        $test_details_report = $this->db->select('test_report_details')->where('id', $test_details_id)->get('tbl_tests_details')->row()->test_report_details;
        echo json_encode($test_details_report);
    }

}
