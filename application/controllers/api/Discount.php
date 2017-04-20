<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Discount extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header("Access-Control-Allow-Methods : POST,GET,PUT,DELETE");
        header("Access-Control-Allow-Headers : Authorization, Lang");
    }

    public function index() {
        $discount_structure = array();
        $discount = $this->obj_common->get_data(array(), 'Master.Discounts');
        foreach ($discount as $key => $val) {
            $from = $val['NumberofcontrolsFrom'];
            $to = $val['NumberofcontrolsTo'];
            $percent = $val['DiscountPercentage'];
            $discount_structure[$key]['from'] = "$from";
            $discount_structure[$key]['to'] = "$to";
            $discount_structure[$key]['percentage'] = "$percent";
        }
        $json['success'] = true;
        $json['discount'] = $discount_structure;
        $this->send_response($json);
    }

}
