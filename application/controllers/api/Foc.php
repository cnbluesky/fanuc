<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Foc extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header("Access-Control-Allow-Methods : POST,GET,PUT,DELETE");
        header("Access-Control-Allow-Headers : Authorization, Lang");
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            if (empty($requestjson['user_id'])) {
                $json['success'] = false;
                $json['message'] = "User id is required.";
                $this->send_response($json);
            } else {


                $foc_data = array();
                $foc_data = end($this->obj_common->get_data(array(), 'fanuc_foc_request'));
                if (empty($foc_data)) {
                    $foc_id = "00000001";
                } else {
                    $foc_id = preg_replace("/[^0-9,.]/", "", $foc_data['foc_request_number']);
                    $foc_id = str_pad($foc_id + 1, 8, '0', STR_PAD_LEFT);
                }
                $foc_request_id = "FM" . $foc_id;


                $user_data = end($this->obj_common->get_data(array('user_id' => $requestjson['user_id']), 'fanuc_user'));
                $content = "
                <h4>New FOC Request #" . $foc_request_id . "</h4>  
                <table style='width:300px;'>
                <tr><td>Customer Name</td><td>" . $user_data['name'] . "</td></tr>
                <tr><td>Company Name</td><td>" . $user_data['company_name'] . "</td></tr>
                <tr><td>Phone</td><td>" . $user_data['country_code'] . $user_data['mobile_number'] . "</td></tr>
                <tr><td>Email</td><td>" . $user_data['email_address'] . "</td></tr>
                <tr><td>Machine Model</td><td>" . $requestjson['machine_model'] . "</td></tr>
                <tr><td>Machine Serial Number</td><td>" . $requestjson['machine_serial_number'] . "</td></tr>
                <tr><td>System Model</td><td>" . $requestjson['system_model'] . "</td></tr>
                <tr><td>System Serial Number</td><td>" . $requestjson['system_serial_number'] . "</td></tr>
                </table>";

                $foc_request_data = end($this->obj_common->get_data(
                                array('system_serial_number' => $requestjson['system_serial_number']), 'fanuc_foc_request'));

                if (empty($foc_request_data)) {

                    //print_r($user_data);exit;
                    if ($user_data['country'] == '101') {
                        $state_data = end($this->obj_common->get_data(array('state_id' => $user_data['state']), 'fanuc_state'));
                        if ($state_data['state_zone'] == 'SZ') {
                            //$this->send_mail('servicesz@fanucindia.com', 'New Foc Registration Request', $content);
                            $this->send_mail('maneesh@focaloid.com', 'New Foc Registration Request', $content);
                        }

                        if ($state_data['state_zone'] == 'EZ') {
                            //$this->send_mail('serviceez@fanucindia.com', 'New Foc Registration Request', $content);
                            $this->send_mail('maneesh@focaloid.com', 'New Foc Registration Request', $content);
                        }

                        if ($state_data['state_zone'] == 'WZ') {
                            //$this->send_mail('servicewz@fanucindia.com', 'New Foc Registration Request', $content);
                            $this->send_mail('maneesh@focaloid.com', 'New Foc Registration Request', $content);
                        }

                        if ($state_data['state_zone'] == 'NZ') {
                            // $this->send_mail('servicenz@fanucindia.com', 'New Foc Registration Request', $content);
                            $this->send_mail('maneesh@focaloid.com', 'New Foc Registration Request', $content);
                        }
                    } else {
                        //$this->send_mail('servicesz@fanucindia.com', 'New Foc Registration Request', $content);
                        $this->send_mail('maneesh@focaloid.com', 'New Foc Registration Request', $content);
                    }

                    $ins_arr = array('product_category_id' => $requestjson['product_category_id'], 'mtb_maker' => $requestjson['mtb_maker'],
                        'machine_model' => $requestjson['machine_model'], 'machine_serial_number' => $requestjson['machine_serial_number'],
                        'system_model' => $requestjson['system_model'], 'system_serial_number' => $requestjson['system_serial_number'],
                        'created_date' => date('Y-m-d H:i:s'), 'user_id' => $requestjson['user_id'], 'foc_request_number' => $foc_request_id);
                    $this->obj_common->insert($ins_arr, 'fanuc_foc_request');
                    $json['success'] = true;
                    $json['message'] = "Foc request has been successfully registered.";
                    $this->send_response($json);
                } else {
                    $json['success'] = false;
                    $json['message'] = "Request already registered.";
                    $this->send_response($json);
                }
            }
        } else {

            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

}
