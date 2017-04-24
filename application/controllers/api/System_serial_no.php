<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class System_serial_no extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        
    }

    public function index() {
        $serial_no = end($this->obj_common->get_data(array(), 'system_serial_no'));
        $serial_no_text = $serial_no['serial_no_text'];
        $json['success'] = true;
        $json['serial_no_text'] = $serial_no_text;
        $this->send_response($json);
    }

}
