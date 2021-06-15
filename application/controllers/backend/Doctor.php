<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {

        parent::__construct();

        $this->lang->load('content', $_SESSION['lang']);

        if (!isset($_SESSION['user_auth']) || $_SESSION['user_auth'] != true) {
            redirect('login', 'refresh');
        }
        if ($_SESSION['userType'] != 'user')
            redirect('login', 'refresh');

        $this->load->model('UserModel');
        $this->load->library("pagination");
        $this->load->helper("url");
        $this->load->helper("text");
        date_default_timezone_set("Asia/Dhaka");
    }

    public function index() {


        $user_id = $this->session->userdata('userid');

        $data['title']      = 'User Panel • HRSOFTBD';
        $data['page']       = 'backEnd/user/user_dashboard';
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
        $data['user_info']  = $this->UserModel->get_user($user_id);


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
                    
                    redirect('user/profile','refresh');
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
                    redirect('user/profile','refresh');
                    
               }else{
                   
                    $this->session->set_flashdata('message', 'Password Update Failed');
                    redirect('user/profile','refresh');
                   
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
                

                if ($this->UserModel->update_pro_info($update_data, $user_id)) {
                    
                    $this->session->set_userdata('username_first', $update_data['firstname']);
                    $this->session->set_userdata('username_last', $update_data['lastname']);
                    $this->session->set_userdata('username', $update_data['username']);
                    
                    $this->session->set_flashdata('message', 'Information Updated Successfully!');
                    redirect('user/profile', 'refresh');
                    
                } else {
                    
                    $this->session->set_flashdata('message', 'Information Update Failed!');
                    redirect('user/profile', 'refresh');
                    
                } 
                
            }
        }
        
        $data['title']      = 'Profile user Panel • HRSOFTBD News Portal user Panel';
        $data['activeMenu'] = 'Profile';
        $data['page']       = 'backEnd/user/profile';
        
        $this->load->view('backEnd/master_page',$data);
    }

}
