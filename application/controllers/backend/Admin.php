<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {

		parent::__construct();

		$this->lang->load('content', $_SESSION['lang']);

		if (!isset($_SESSION['user_auth']) || $_SESSION['user_auth'] != true) {
			redirect('login', 'refresh');
		}
		if ($_SESSION['userType'] != 'admin')
			redirect('login', 'refresh');
		//Model Loading
		$this->load->model('AdminModel');
		$this->load->library("pagination");
		$this->load->helper("url");
		$this->load->helper("text");

		date_default_timezone_set("Asia/Dhaka");
	}

	//Index
	public function index() {

		$data['total_tests'] = $this->db->count_all('tbl_tests');
		$data['report_submitted'] = $this->db->where('report_upload_time >', '0000-00-00 00:00:00')->count_all_results('tbl_tests_details');
		$data['total_doctor']       = $this->db->where('userType =', 'doctor')->count_all_results('user');

		$data['due_report_list'] = $this->AdminModel->get_due_report_dashboard();
		$data['report_submit_list'] = $this->AdminModel->report_to_submit_list();
		$data['total_patient']    = $this->db->count_all('tbl_patient');
		
		$data['title']      = 'Admin Panel • HRSOFTBD News Portal Admin Panel';
		$data['page']       = 'backEnd/dashboard_view';
		$data['activeMenu'] = 'dashboard_view';
		
		$this->load->view('backEnd/master_page', $data);
	}

	//Theme Setting
	public function theme_setting($param1 = '', $param2 = '', $param3 = ''){

		$theme_data_temp    = $this->db->get('tbl_backend_theme')->result();
		$data['theme_data'] = array();
		foreach($theme_data_temp as $value){
			$data['theme_data'][$value->name]	= $value->value;
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$long_title = $this->input->post('long_title', true);
			$this->AdminModel->theme_text_update('long_title', $long_title);

			$short_title = $this->input->post('short_title', true);
			$this->AdminModel->theme_text_update('short_title', $short_title);
			
			$tagline = $this->input->post('tagline', true);
			$this->AdminModel->theme_text_update('tagline', $tagline);
			
			$share_title = $this->input->post('share_title', true);
			$this->AdminModel->theme_text_update('share_title', $share_title);

			$share_title = $this->input->post('version', true);
			$this->AdminModel->theme_text_update('version', $share_title);

			$share_title = $this->input->post('organization', true);
			$this->AdminModel->theme_text_update('organization', $share_title);

			if (!empty($_FILES['logo']['name'])) {

				$path_parts                 = pathinfo($_FILES["logo"]['name']);
				$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
				$dir                        = date("YmdHis", time());
				$config_c['file_name']      = $newfile_name . '_' . $dir;
				$config_c['remove_spaces']  = TRUE;
				$config_c['upload_path']    = 'assets/themeLogo/';
				$config_c['max_size']       = '20000'; //  less than 20 MB
				$config_c['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

				$this->load->library('upload', $config_c);
				$this->upload->initialize($config_c);
				if (!$this->upload->do_upload('logo')) {

				} else {

					$upload_c = $this->upload->data();
					$logo['logo'] = $config_c['upload_path'] . $upload_c['file_name'];
					$this->image_size_fix($logo['logo'], 300, 300);
				}
				$this->AdminModel->theme_text_update('logo',$logo['logo']);
			}

			if (!empty($_FILES['share_banner']['name'])) {

				$path_parts                 = pathinfo($_FILES["share_banner"]['name']);
				$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
				$dir                        = date("YmdHis", time());
				$config['file_name']      = $newfile_name . '_' . $dir;
				$config['remove_spaces']  = TRUE;
				$config['upload_path']    = 'assets/themeBanner/';
				$config['max_size']       = '20000'; //  less than 20 MB
				$config['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG';

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('share_banner')) {

				} else {

					$upload = $this->upload->data();
					$share_banner['share_banner'] = $config['upload_path'] . $upload['file_name'];
					$this->image_size_fix($share_banner['share_banner'], 600, 315);
				}
				$this->AdminModel->theme_text_update('share_banner',$share_banner['share_banner']);
				
			}
			
			$this->session->set_flashdata('message', 'Theme Info Updated Successfully!');
			redirect('admin/theme-setting','refresh');
		}

		$data['page']       = 'backEnd/admin/theme_setting';
		$data['activeMenu'] = 'theme_setting';

		$this->load->view('backEnd/master_page', $data);
	}

	//User Add
	public function add_user($param1 = '') 
	{
		$messagePage['divissions'] = $this->db->get('tbl_divission')->result_array();
		$messagePage['userType']   = $this->db->get('user_type')->result();

		$messagePage['title']      = 'Add User Admin Panel • HRSOFTBD News Portal Admin Panel';
		$messagePage['page']       = 'backEnd/admin/add_user';
		$messagePage['activeMenu'] = 'add_user';
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$saveData['firstname'] = $this->input->post('first_name', true);
			$saveData['lastname']  = $this->input->post('last_name', true);
			$saveData['username']  = $this->input->post('user_name', true);
			$saveData['email']     = $this->input->post('email', true);
			$saveData['phone']     = $this->input->post('phone', true);
			$saveData['password']  = sha1($this->input->post('password', true));
			$saveData['address']   = $this->input->post('address', true);
			$saveData['roadHouse'] = $this->input->post('road_house', true);
			$saveData['userType']  = $this->input->post('user_type', true);
			$saveData['photo']     = 'assets/userPhoto/defaultUser.jpg';

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
					$saveData['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
					$this->image_size_fix($saveData['photo'], 400, 400);
				}
				
			}

			//This will returns as third parameter num_rows, result_array, result
			$username_check = $this->AdminModel->isRowExist('user', array('username' => $saveData['username']), 'num_rows');
			$email_check = $this->AdminModel->isRowExist('user', array('email' => $saveData['email']), 'num_rows');

			if ($username_check > 0 || $email_check > 0) {
				//Invalid message
				$messagePage['page'] = 'backEnd/admin/insertFailed';
				$messagePage['noteMessage'] = "<hr> UserName: " . $saveData['username'] . " can not be create.";
				if ($username_check > 0) {

					$messagePage['noteMessage'] .= '<br> Cause this username is already exist.';
				} else if ($email_check > 0) {

					$messagePage['noteMessage'] .= '<br> Cause this email is already exist.';
				}
			} else {
				//success
				$insertId = $this->AdminModel->saveDataInTable('user', $saveData, 'true');

				$messagePage['page'] = 'backEnd/admin/insertSuccessfull';
				$messagePage['noteMessage'] = "<hr> UserName: " . $saveData['username'] . " has been created successfully.";

				// Category allocate for users
				if (!empty($this->input->post('selectCategory', true))) {

					foreach ($this->input->post('selectCategory', true) as $cat_value) {

						$this->db->insert('category_user', array('userId' => $insertId, 'categoryId' => $cat_value));
					}
				}
			}
		}


		$this->load->view('backEnd/master_page', $messagePage);
	}

	//User Update
	public function edit_user($param1 = '') 
	{
		// Update using post method 
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			if(strlen($this->input->post('password', true)) > 3){
                $saveData['password']  = sha1($this->input->post('password', true));
            }

			$saveData['firstname'] = $this->input->post('first_name', true);
			$saveData['lastname']  = $this->input->post('last_name', true);
			$saveData['phone']     = $this->input->post('phone', true);
			$saveData['address']   = $this->input->post('address', true);
			$saveData['roadHouse'] = $this->input->post('road_house', true);
			$saveData['userType']  = $this->input->post('user_type', true);
			$user_id               = $param1;

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
					$saveData['photo'] = $config_c['upload_path'] . $upload_c['file_name'];
					$this->image_size_fix($saveData['photo'], 400, 400);
				}
				
			}

			if (isset($saveData['photo']) && file_exists($saveData['photo'])) {
	
				$result = $this->db->select('photo')->from('user')->where('id',$user_id)->get()->row()->photo;

				if (file_exists($result)) {
					unlink($result);
				}  
			}

			$this->db->where('id', $user_id);
			$this->db->update('user', $saveData);
			
			$data['page']        = 'backEnd/admin/insertSuccessfull';
			$data['noteMessage'] = "<hr> Data has been Updated successfully.";

		} else if ($this->AdminModel->isRowExist('user', array('id' => $param1), 'num_rows') > 0) {

			$data['userDetails']   = $this->AdminModel->isRowExist('user', array('id' => $param1), 'result_array');

			$myupozilla_id         = $this->db->get_where('tbl_upozilla', array("id"=>$data['userDetails'][0]['address']))->row();

			$data['myzilla_id']    = $myupozilla_id->zilla_id;
			$data['mydivision_id'] = $myupozilla_id->division_id;

			$data['divissions']    = $this->db->get('tbl_divission')->result();
		
			$data['distrcts']      = $this->db->get_where('tbl_zilla',array('divission_id'=>$data['mydivision_id']))->result();
			$data['upozilla']      = $this->db->get_where('tbl_upozilla',array('zilla_id'=>$data['myzilla_id']))->result();

			$data['userType'] = $this->db->get('user_type')->result_array();
			$data['user_id']  = $param1;
			$data['page']     = 'backEnd/admin/edit_user';

		} else {

			$data['page']        = 'errors/invalidInformationPage';
			$data['noteMessage'] = $this->lang->line('wrong_info_search');
		}

		$data['user_type'] 	= $this->db->select('id, value, name')->get('user_type')->result();
		$data['title']      = 'Users List Admin Panel • HRSOFTBD News Portal Admin Panel';
		$data['activeMenu'] = 'user_list';
		$this->load->view('backEnd/master_page', $data);
	}

	//Suspend User
	public function suspend_user($id, $setvalue)
	{
		$this->db->where('id', $id);
		$this->db->update('user', array('status' => $setvalue));
		$this->session->set_flashdata('message', 'Data Saved Successfully.');
		
		redirect('admin/user_list', 'refresh');
	}

	//Delete User
	public function delete_user($id)
	{
		$old_image_url=$this->db->where('id', $id)->get('user')->row();
		$this->db->where('id', $id)->delete('user');
		if(isset($old_image_url->photo)){
			unlink($old_image_url->photo);
		}

		$this->session->set_flashdata('message', 'Data Deleted.');
		redirect('admin/user_list', 'refresh');
	}

	//User List
	public function user_list() 
	{
		$this->db->where('userType !=', 'admin');
		$data['myUsers']    = $this->db->get('user')->result_array();
		$data['title']      = 'Users List Admin Panel • HRSOFTBD News Portal Admin Panel';
		$data['page']       = 'backEnd/admin/user_list';
		$data['activeMenu'] = 'user_list';
		$this->load->view('backEnd/master_page', $data);
	}

	//Image Size Fix
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

	//Ajax Part Start 
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
	//Ajax Part End

	//File Download
	public function download_file($file_name = '', $fullpath='') {

		$this->load->helper('download');

		$filePath = $file_name;

		if($file_name=='full' && ($fullpath != '' || $fullpath != null)) $filePath = $fullpath;

		if($_GET['file_path']) $filePath = $_GET['file_path'];
		
		if (file_exists($filePath)) {

			force_download($filePath, NULL);

		} else {

			die('The provided file path is not valid.');
		}
	}
	
	//User Prifile
	public function profile($param1 = '')
	{

		$user_id            = $this->session->userdata('userid');
		$data['user_info']  = $this->AdminModel->get_user($user_id);


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
					
					redirect('admin/profile','refresh');
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
					redirect('admin/profile','refresh');
					
			   	}else{
			       
				    $this->session->set_flashdata('message', 'Password Update Failed');
				    redirect('admin/profile','refresh');
				   
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


				$current_password = sha1($this->input->post('password', true));

				$db_password      = $data['user_info']->password;

				if ($current_password == $db_password) {

					if ($this->AdminModel->update_pro_info($update_data, $user_id)) {
    			    
	    			    $this->session->set_userdata('username_first', $update_data['firstname']);
	    			    $this->session->set_userdata('username_last', $update_data['lastname']);
	    			    $this->session->set_userdata('username', $update_data['username']);
	    			    
	    				$this->session->set_flashdata('message', 'Information Updated Successfully!');
	    				redirect('admin/profile', 'refresh');
	    				
	    			} else {
	    			    
	    				$this->session->set_flashdata('message', 'Information Update Failed!');
	    				redirect('admin/profile', 'refresh');
	    				
	    			} 

				} else {

					$this->session->set_flashdata('message', 'Current Password Does Not Match!');
	    			redirect('admin/profile', 'refresh');
				}
				
				
			}
		}
		
		$data['title']      = 'Profile Admin Panel • HRSOFTBD News Portal Admin Panel';
		$data['activeMenu'] = 'Profile';
		$data['page']       = 'backEnd/admin/profile';
		
		$this->load->view('backEnd/master_page',$data);
	}

	//Page Setting
	public function page_settings($param1 = 'add', $param2 = '', $param3 = '') {
        
    	if ($param1 == 'add') {

    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	    		$page_settings_data['name']           = $this->input->post('name', true);
	    		$page_settings_data['title']          = $this->input->post('title', true);
	    		$page_settings_data['body']           = $this->input->post('body');
	    		$page_settings_data['is_menu']        = $this->input->post('is_menu', true);
	    		$page_settings_data['priority']       = $this->input->post('priority', true);
	    		$page_settings_data['parent_page_id'] = $this->input->post('parent_page_id', true);

	    		if (!empty($_FILES["attatched"]['name'])){

					//exta work
					$path_parts                 = pathinfo($_FILES["attatched"]['name']);
					$newfile_name               = preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
					$dir                        = date("YmdHis", time());
					$config['file_name']      = $newfile_name . '_' . $dir;
					$config['remove_spaces']  = TRUE;
					$config['upload_path']    = 'assets/pageSettings/';
					$config['max_size']       = '20000'; //  less than 20 MB
					$config['allowed_types']  = 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG|pdf|docx';

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('attatched')) {

					} else {

						$upload = $this->upload->data();
						$page_settings_data['attatched']   = $config['upload_path'] . $upload['file_name'];

						$file_parts = pathinfo($page_settings_data['attatched']);
	                    if ($file_parts['extension'] != "pdf") {
	                        $this->image_size_fix($page_settings_data['attatched'], $width = 440, $height = 320);
	                    }
					}
				}

				$check_name_exist = $this->db->where('name', $page_settings_data['name'])->get('tbl_common_pages');
				if ($check_name_exist->num_rows() > 0) {

					$this->session->set_flashdata('message','This Page Already Exists!');
					redirect('admin/page_settings', 'refresh');

				}else{

					$page_settings = $this->db->insert('tbl_common_pages', $page_settings_data);

					if ($page_settings) {

						$this->session->set_flashdata('message','Page Created Successfully!');
						redirect('admin/page_settings', 'refresh');

					} else {

						$this->session->set_flashdata('message','Page Create Failed!');
						redirect('admin/page_settings', 'refresh');
					}
					
				}
			}

			$data['title']         = 'Page Setting Add';
            $data['page']          = 'backEnd/admin/page_settings_add';
            $data['activeMenu']    = 'page_settings_add';
            $data['page_settings'] = $this->db->select('id, name')->get('tbl_common_pages')->result();

    	} elseif ($param1 == 'edit' && (int) $param2 > 0) {

			$data['table_info']    = $this->db->where('id', $param2)->get('tbl_common_pages')->row();
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                //exta work
				$path_parts                 	= pathinfo($_FILES["attatched"]['name']);
				$newfile_name               	= preg_replace('/[^A-Za-z]/', "", $path_parts['filename']);
				$dir                        	= date("YmdHis", time());
				$config['file_name']        	= $newfile_name . '_' . $dir;
				$config['remove_spaces']    	= TRUE;
				$config['max_size']         	= '20000'; //  less than 20 MB
				$config['allowed_types']    	= 'jpg|png|jpeg|jpg|JPG|JPG|PNG|JPEG|pdf|docx';
                $config['upload_path']      	= 'assets/pageSettings';

                $old_file_url                   = $data['table_info'];
                $update_data['title']           = $this->input->post('title', true);
                $update_data['body']            = $this->input->post('body');
                $update_data['is_menu']         = $this->input->post('is_menu', true);
	    		$update_data['priority']        = $this->input->post('priority', true);
	    		$update_data['parent_page_id']  = $this->input->post('parent_page_id', true);

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('attatched')) {

                    $this->session->set_flashdata('message', 'Data Updated Successfully');
                    $this->db->where('id', $param2)->update('tbl_common_pages', $update_data);
					
                    redirect('admin/page_settings/list','refresh');
                } else {

                    $upload = $this->upload->data();

                    $update_data['attatched'] = $config['upload_path'] . '/' . $upload['file_name'];
                    $this->db->where('id', $param2)->update('tbl_common_pages', $update_data);
                    $file_parts = pathinfo($update_data['attatched']);
                    if ($file_parts['extension'] != "pdf") {
                        $this->image_size_fix($update_data['attatched'], $width = 440, $height = 320);
                    }
                    if(file_exists($old_file_url->attatched)) unlink($old_file_url->attatched);
                    $this->session->set_flashdata('message', 'Data Updated Successfully');
                	redirect('admin/page_settings/list', 'refresh');

                }
            }

           
            $data['page_settings'] = $this->db->select('id, name')->where('id !=', $param2)->get('tbl_common_pages')->result();



			$data['title']         = 'Page Setting Update';
            $data['page']          = 'backEnd/admin/page_settings_edit';
			$data['activeMenu']    = 'page_settings_edit';
			
        } elseif ($param1 == 'list') {

        	$data['title']      = 'Page Setting List';
            $data['page']       = 'backEnd/admin/page_settings_list';
            $data['activeMenu'] = 'page_settings_list';
			$data['table_info'] = $this->db->get('tbl_common_pages')->result_array();
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	$attatched = $this->db->where('id', $param2)->get('tbl_common_pages')->row()->attatched;

        	if (file_exists($attatched)) {

        		unlink($attatched);
        	}

        	$page_settings_delete = $this->db->where('id', $param2)->delete('tbl_common_pages');

			if ($page_settings_delete) {

				$this->session->set_flashdata('message','Page Deleted Successfully!');
				redirect('admin/page_settings/list','refresh');

			} else {

				$this->session->set_flashdata('message','Page Delete Failed!');
				redirect('admin/page_settings/list','refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/page_settings/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

	//Sms Send
    public function sms_send($param1 = 'list', $param2 = '', $param3 = '')
	{
		if ($param1 == 'list') {

			$data['title']         = 'SMS Send';
			$data['activeMenu']    = 'sms_send';
			$data['page']          = 'backEnd/admin/sms_send_list';
			//$data['sms_send_list'] = $this->db->order_by('send_date_time','desc')->get('tbl_sms_send_list')->result();


		} elseif ($param1 == 'setting') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$setting_data['username'] = $this->input->post('username', true);
				$setting_data['password'] = $this->input->post('password', true);

				$update_setting = $this->db->where('id', 1)->update('tbl_sms_send_setting', $setting_data);

				if ($update_setting) {

					$this->session->set_flashdata('message','SMS Setting Updated Successfully!');
					redirect('admin/sms_send/setting','refresh');

				} else {

					$this->session->set_flashdata('message','SMS Setting Update Failed!');
					redirect('admin/sms_send/setting','refresh');

				}
				
			}

			$data['title']        = 'SMS Send';
			$data['activeMenu']   = 'sms_send';
			$data['page']         = 'backEnd/admin/sms_send_setting';
			//$data['setting_info'] = $this->db->where('id',1)->get('tbl_sms_send_setting')->row();

		} elseif ($param1 == 'new_sms') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$sms_send_data['send_date_time']   = date('Y-m-d H:i:s');
				$sms_send_data['message']          = $this->input->post('message', true);
				$sms_send_data['receiver_numbers'] = $this->input->post('receiver_numbers', true);
				$sms_send_data['insert_by']        = $_SESSION['userid'];

				$sms_send_add = $this->db->insert('tbl_sms_send_list', $sms_send_data);

				if ($sms_send_add) {

					$this->session->set_flashdata('message','Message Send Successfully!');
					redirect('admin/sms_send/new_sms','refresh');

				} else {

					$this->session->set_flashdata('message','Message Send Failed!');
					redirect('admin/sms_send/new_sms','refresh');

				}
				
			}

			$data['title']         = 'SMS Send';
			$data['activeMenu']    = 'sms_send';
			$data['page']          = 'backEnd/admin/sms_send_new';
			
		} else{

			$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/sms_send/list','refresh');
		}

		$this->load->view('backEnd/master_page', $data);
	}

	//Get Sms
	public function get_sms_number($sms_to)
	{
		if ($sms_to == 1) {

			$result = $this->db->select('mobile')->get('tbl_members')->result();

			$mobile = '';

			foreach ($result as $key => $value) {

				if($mobile != '') if($value->mobile != '') $mobile .= ',';
				$mobile .= $value->mobile;
				
			}

			echo json_encode($mobile, JSON_UNESCAPED_UNICODE);

		} else {

			$result = $this->db->select('phone as mobile')->get('tbl_committee')->result();

			$mobile = '';

			foreach ($result as $key => $value) {

				if($mobile != '') if($value->mobile != '') $mobile .= ',';
				$mobile .= $value->mobile;
				
			}
			echo json_encode($mobile, JSON_UNESCAPED_UNICODE);
		}
		
	}

	//Mail Setting
	public function mail_setting()
	{

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			foreach ($this->input->post('mail_setting_id', true) as $key => $id_value) {

				$id    = $id_value;
				$value = $this->input->post('value', true)[$key];

				$this->db->where('id', $id)->update('tbl_mail_send_setting', array('value'=>$value));

			}

			$this->session->set_flashdata('message','Mail Send Setting Updated Successfully!');
			redirect('admin/mail_setting','refresh');
		}

		$data['title']             = 'Mail Setting';
		$data['activeMenu']        = 'mail_setting';
		$data['page']              = 'backEnd/admin/mail_setting';
		$data['mail_setting_info'] = $this->db->get('tbl_mail_send_setting')->result();
		$this->load->view('backEnd/master_page', $data);
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
					redirect('admin/test-category/list', 'refresh');

				} else {

					$this->session->set_flashdata('message','Test Category Failed!');
					redirect('admin/test-category', 'refresh');
				}
			}

			$data['title']         = 'Test Category Add';
            $data['page']          = 'backEnd/admin/test_category_add';
            $data['activeMenu']    = 'test_category_add';
            
    	} elseif ($param1 == 'list') {

        	$data['title']         = 'Test Category List';
            $data['page']          = 'backEnd/admin/test_category_list';
            $data['activeMenu']    = 'test_category_list';

			$data['test_category_list'] =  $this->db->order_by('id', 'DESC')->get('tbl_test_category')->result();
			
        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

			$data['edit_info']    = $this->db->where('id', $param2)->get('tbl_test_category')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            	$update_test_category_data['name']           = $this->input->post('name', true);

	    		if ($this->AdminModel->update_test_category($update_test_category_data, $param2)) {

				$this->session->set_flashdata('message','Test Category  Updated Successfully!');
				redirect('admin/test-category/list', 'refresh');

				} else {

				   $this->session->set_flashdata('message','Test Category Update Failed!');
					redirect('admin/test-category/edit/'.$param2, 'refresh');
				}

            }

			$data['title']         = 'Test Category Update';
            $data['page']          = 'backEnd/admin/test_category_edit';
			$data['activeMenu']    = 'test_category_edit';
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_test_category($param2)) {

				$this->session->set_flashdata('message','Test Category  Deleted Successfully!');
				redirect('admin/test-category/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Test Category Deleted Failed!');
				redirect('admin/test-category/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/test-category/list','refresh');
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
					redirect('admin/test-name/list', 'refresh');

				} else {

					$this->session->set_flashdata('message','Test Name Failed!');
					redirect('admin/test-name', 'refresh');
				}
			}

			$data['test_category_list'] = $this->db->order_by('id', 'DESC')->get('tbl_test_category')->result();

			$data['title']         = 'Test Name Add';
            $data['page']          = 'backEnd/admin/test_name_add';
            $data['activeMenu']    = 'test_name_add';
            
    	} elseif ($param1 == 'list') {

        	$data['title']         = 'Test Name List';
            $data['page']          = 'backEnd/admin/test_name_list';
            $data['activeMenu']    = 'test_name_list';

			$data['test_name_list'] =  $this->AdminModel->test_name_list();
			
        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

			$data['edit_info']    = $this->db->where('id', $param2)->get('tbl_test_name')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            	$update_test_name_data['test_category_id']           = $this->input->post('test_category_id', true);
	    		$update_test_name_data['test_name']           = $this->input->post('test_name', true);
	    		$update_test_name_data['price']           = $this->input->post('price', true);
	    		$update_test_name_data['referral_commission']           = $this->input->post('referral_commission', true);
	    		$update_test_name_data['report_format']           = $this->input->post('report_format', true);


	    		if ($this->AdminModel->update_test_name($update_test_name_data, $param2)) {

				$this->session->set_flashdata('message','Test Name  Updated Successfully!');
				redirect('admin/test-name/list', 'refresh');

				} else {

				   $this->session->set_flashdata('message','Test Name Update Failed!');
					redirect('admin/test-name/edit/'.$param2, 'refresh');
				}

            }

            $data['test_category_list'] = $this->db->order_by('id', 'DESC')->get('tbl_test_category')->result();

			$data['title']         = 'Test Name Update';
            $data['page']          = 'backEnd/admin/test_name_edit';
			$data['activeMenu']    = 'test_name_edit';
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_test_name($param2)) {

				$this->session->set_flashdata('message','Test Name Deleted Successfully!');
				redirect('admin/test-name/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Test Name Deleted Failed!');
				redirect('admin/test-name/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/test-name/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //test name print
    public function test_name_print()
    {
    	$data['test_name_list'] =  $this->AdminModel->test_name_list();
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
					redirect('admin/patient/list', 'refresh');

				} else {

					$this->session->set_flashdata('message','Patient Failed!');
					redirect('admin/patient', 'refresh');
				}
			}

			$data['test_category_list'] = $this->db->order_by('id', 'DESC')->get('tbl_test_category')->result();

			$data['title']         = 'Patient Add';
            $data['page']          = 'backEnd/admin/patient_add';
            $data['activeMenu']    = 'patient_add';
            
    	} elseif ($param1 == 'list') {

        	$data['title']         = 'Patient List';
            $data['page']          = 'backEnd/admin/patient_list';
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
	    		$patient_update_data['gender']           = $this->input->post('gender', true);

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


	    		if ($this->AdminModel->update_patient($patient_update_data, $param2)) {

				$this->session->set_flashdata('message','Patient  Updated Successfully!');
				redirect('admin/patient/list', 'refresh');

				} else {

				   $this->session->set_flashdata('message','Patient Update Failed!');
					redirect('admin/patient/edit/'.$param2, 'refresh');
				}

            }

            $data['test_category_list'] = $this->db->order_by('id', 'DESC')->get('tbl_test_category')->result();

			$data['title']         = 'Patient Update';
            $data['page']          = 'backEnd/admin/patient_edit';
			$data['activeMenu']    = 'test_name_edit';
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_patient($param2)) {

				$this->session->set_flashdata('message','Patient Deleted Successfully!');
				redirect('admin/patient/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Patient Deleted Failed!');
				redirect('admin/patient/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/patient/list','refresh');
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
		    		$patient_data['gender']           = $this->input->post('gender', true);
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
					redirect('admin/test-details/list', 'refresh');

				} else {

					$this->session->set_flashdata('message','Test Details target Failed!');
					redirect('admin/test-details', 'refresh');
				}
	    		
			}

			$data['discount_option_list'] = $this->db->get('tbl_discount_option')->result();

			$data['test_category_list'] = $this->db->order_by('id', 'DESC')->get('tbl_test_category')->result();
			$data['referred_list']      = $this->db->select('id, firstname, lastname')->where('userType', 'doctor')->get('user')->result();
			$data['test_name_list']     = $this->db->select('id, test_name')->get('tbl_test_name')->result();

 
			$data['title']         = 'Test details Add';
            $data['page']          = 'backEnd/admin/test_details_add';
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


			$data['test_list']     =  $this->AdminModel->test_list($data['search']);
			// echo "<pre>";
			// print_r($data['test_list']);
			// exit;

			$data['invoice_number_list'] = $this->db->select('id, invoice_number')->get('tbl_tests')->result();

        	$data['title']         = 'Test details List';
            $data['page']          = 'backEnd/admin/test_list';
            $data['activeMenu']    = 'test_details_list';

        } elseif ($param1 == 'view' && (int) $param2 > 0) {

        	$data['test']          = $this->AdminModel->get_test_data($param2);

        	$data['test_details']  = $this->AdminModel->get_test_details_data($param2);
        	$data['paid_amount']   = $this->AdminModel->get_paid_amount($param2);
        	// echo "<pre>";
        	// print_r($data['paid_amount']);
        	// exit;

        	$data['title']         = 'Test details List';
            $data['page']          = 'backEnd/admin/test_view';
            $data['activeMenu']    = 'test_details_list';

        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_tests($param2)) {

				$this->session->set_flashdata('message','Test details Deleted Successfully!');
				redirect('admin/test-details/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Test details Deleted Failed!');
				redirect('admin/test-details/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/test-details/list','refresh');
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

		$data['tests_list']     =  $this->AdminModel->tests_list($data);

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
		$result      = $this->AdminModel->patient_data_search($search_data);
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	//test details report details update
	public function report_format_update()
	{
		$test_details_id  = $this->input->post('test_details_id', true);
		$test_id          = $this->input->post('test_id', true);
		$update_data['test_report_details'] = $this->input->post('report_format', true);
		$update_data['report_upload_time']  = date('Y-m-d H:s');

		$this->db->where('id',$test_details_id)->update('tbl_tests_details', $update_data);

		if(true){
			$this->session->set_flashdata('message','Test Report  
			Format Successfully Updated');
			redirect('admin/test-details/view/'.$test_id, 'refresh');
		} else{
			$this->session->set_flashdata('message','Test Report  Report Update Failed');
			redirect('admin/test-details/view/'.$test_id, 'refresh');
		}

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
					redirect('admin/account-head','refresh');

				} else {

					$this->session->set_flashdata('message','Account Head Add Failed!');
					redirect('admin/account-head','refresh');

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

					if ($this->AdminModel->account_head_update($update_account_head, $param2)) {

						$this->session->set_flashdata('message','Account Head Updated Successfully!');
						redirect('admin/account-head/list/','refresh');

					} else {

						$this->session->set_flashdata('message','Account Head Update Failed!');
						redirect('admin/account-head/edit/'.$param2,'refresh');

					}
					
				}

			} else {

				$this->session->set_flashdata('message','Wrong Attempt!');
				redirect('admin/account-head','refresh');
			}
			

		} elseif ($param1 == 'delete' && $param2 > 0) {

			$account_head_delete = $this->db->where('id', $param2)->where('readonly', 0)->delete('tbl_accounts_category');
			// echo "<pre>";
			// print_r($account_head_delete);
			// exit;

			if ($account_head_delete) {

				$this->session->set_flashdata('message','Account Head Deleted Successfully!');
				redirect('admin/account-head','refresh');

			} else {

				$this->session->set_flashdata('message','Account Head Delete Failed!');
				redirect('admin/account-head','refresh');

			}

		}

		$data['title']        = 'Account Head';
		$data['activeMenu']   = 'account_head';
		$data['page']         = 'backEnd/admin/account_head';
		
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
					redirect('admin/test-payment/list', 'refresh');

				} else {

					$this->session->set_flashdata('message','Test payment Failed!');
					redirect('admin/test-payment', 'refresh');
				}
			}

 
			$data['title']         = 'Test payment Add';
            $data['page']          = 'backEnd/admin/test_payment_add';
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

			

			$data['test_payment_list'] =  $this->AdminModel->test_payment_list($data['search']);
			$data['patient_list']      = $this->db->select('id, patient_name, patient_phone')->order_by('insert_time', 'DESC')->get('tbl_patient')->result();
			$data['tests_list']        = $this->db->select('id, invoice_number')->order_by('insert_time', 'DESC')->get('tbl_tests')->result();

        	$data['title']         = 'Test payment List';
            $data['page']          = 'backEnd/admin/test_payment_list';
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

				$data['due_report_list'] = $this->AdminModel->get_due_report($data['search']);
				
	    	}

	    	
	    	// echo "<pre>";
	    	// print_r($data['due_report_list']);
	    	// exit;

	    	$data['patient_list']  = $this->db->select('id, patient_name, patient_phone')->order_by('insert_time', 'DESC')->get('tbl_patient')->result();

	    	$data['title']         = 'Due Report';
	        $data['page']          = 'backEnd/admin/due_report';
			$data['activeMenu']    = 'due_report';

        } elseif ($param1 == 'edit' && (int) $param2 > 0) {

			$data['edit_info']    = $this->db->where('id', $param2)->get('tbl_test_payment')->row();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            	$update_test_payment_data['tests_id']            = $this->input->post('tests_id', true);
	    		$update_test_payment_data['patient_id']          = $this->input->post('patient_id', true);
	    		$update_test_payment_data['paid_amount']         = $this->input->post('paid_amount', true);
	    		$update_test_payment_data['paid_date']           = date('Y-m-d', strtotime($this->input->post('paid_date', true)));
	    		$update_test_payment_data['payment_approved']    = $this->input->post('payment_approved', true);


	    		if ($this->AdminModel->update_test_payment($update_test_payment_data, $param2)) {

				$this->session->set_flashdata('message','Test payment  Updated Successfully!');
				redirect('admin/test-payment/list', 'refresh');

				} else {

				   $this->session->set_flashdata('message','Test payment Update Failed!');
					redirect('admin/test-payment/edit/'.$param2, 'refresh');
				}

            }

			$data['title']         = 'Test payment Update';
            $data['page']          = 'backEnd/admin/test_payment_edit';
			$data['activeMenu']    = 'test_payment_edit';
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_test_payment($param2)) {

				$this->session->set_flashdata('message','Test payment Deleted Successfully!');
				redirect('admin/test-payment/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Test payment Deleted Failed!');
				redirect('admin/test-payment/list', 'refresh');
			}

        } elseif ($param1 == 'approved' && (int) $param2 > 0) {

        	if ($this->AdminModel->approved_test_payment($param2)) {

				$this->session->set_flashdata('message','Test payment approved Successfully!');
				redirect('admin/test-payment/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Test payment approved Failed!');
				redirect('admin/test-payment/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/test-payment/list','refresh');
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
					redirect('admin/accounts/list', 'refresh');

				} else {

					$this->session->set_flashdata('message','Accounts Failed!');
					redirect('admin/accounts', 'refresh');
				}
			}

			$data['accounts_head_list'] = $this->db->order_by('id', 'DESC')->get('tbl_accounts_category')->result();

			$data['title']         = 'Accounts Add';
            $data['page']          = 'backEnd/admin/accounts_add';
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
	        $config["base_url"] = base_url() . "admin/accounts/list";
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

			$data['accounts_list']     =  $this->AdminModel->accounts_list($config["per_page"], $page, $data['search']);

        	$data['title']         = 'Accounts List';
            $data['page']          = 'backEnd/admin/accounts_list';
            $data['activeMenu']    = 'accounts_list';
			
        } elseif ($param1 == 'view' && (int) $param2 > 0) {

        	$data['accounts_info'] = $this->db->select('tbl_accounts.id, tbl_accounts.accounts_date, tbl_accounts.accounts_type_id, tbl_accounts.insert_time, tbl_accounts.invoice_number, user.firstname, user.lastname')->join('user', 'user.id = tbl_accounts.insert_by', 'left')->where('tbl_accounts.id', $param2)->get('tbl_accounts')->row();

        	$invoice_number = $data['accounts_info']->invoice_number;

        	$data['accounts_details'] = $this->AdminModel->get_accounts_details_data($invoice_number);
			
			$data['title']         = 'Accounts View';
            $data['page']          = 'backEnd/admin/accounts_view';
			$data['activeMenu']    = 'accounts_view';
			
        } elseif ($param1 == 'delete' && (int) $param2 > 0) {

        	if ($this->AdminModel->delete_accounts($param2)) {

				$this->session->set_flashdata('message','Accounts Deleted Successfully!');
				redirect('admin/accounts/list', 'refresh');

			} else {

			    $this->session->set_flashdata('message','Accounts Deleted Failed!');
				redirect('admin/accounts/list', 'refresh');
			}

        } else {

        	$this->session->set_flashdata('message','Wrong Attempt!');
			redirect('admin/accounts/list','refresh');
        }

        $this->load->view('backEnd/master_page', $data);
    }

    //accounts print
    public function accounts_print($param2)
    {

    	$data['accounts_info'] = $this->db->select('tbl_accounts.id, tbl_accounts.accounts_date, tbl_accounts.accounts_type_id, tbl_accounts.insert_time, tbl_accounts.invoice_number, user.firstname, user.lastname')->join('user', 'user.id = tbl_accounts.insert_by', 'left')->where('tbl_accounts.id', $param2)->get('tbl_accounts')->row();

    	$invoice_number = $data['accounts_info']->invoice_number;

    	$data['accounts_details'] = $this->AdminModel->get_accounts_details_data($invoice_number);
		
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


			$data['referrer_report_list']  = $this->AdminModel->get_referrer_report($data['search']);
    	}

    	
    	
    	$data['referred_list']      = $this->db->select('id, firstname, lastname')->where('userType', 'doctor')->get('user')->result();

    	$data['title']         = 'Referrer Report';
        $data['page']          = 'backEnd/admin/referrer_report';
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

    	$data['referrer_report_list']  = $this->AdminModel->get_referrer_report($data);
    	// echo "<pre>";
    	// print_r($data['referrer_report_list']);
    	// exit;
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
