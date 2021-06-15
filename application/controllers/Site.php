<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

    function __construct() {

        parent::__construct();
    }

    public function index() {
        $data = array();
        $data['page'] = 'frontend/index';
        $this->load->view('frontend/welcome', $data);
    }

}
