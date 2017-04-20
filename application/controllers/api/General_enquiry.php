<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class General_enquiry extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
        header('Access-Control-Allow-Origin: *'); 
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);

            if (empty($requestjson['user_id'])) {
                $json['success'] = false;
                $json['message'] = "User id is required.";
                $this->send_response($json);
            } elseif (empty($requestjson['enquiry_details'])) {
                $json['success'] = false;
                $json['message'] = "Enquiry details is required.";
                $this->send_response($json);
            } else {
                 $user_data = end($this->obj_common->get_data(array('user_id' => $requestjson['user_id']), 'fanuc_user'));
                $content = "
                <h4>New Enquiry Request</h4>  
                <table style='width:300px;'>
                <tr><td>Customer Name</td><td>" . $user_data['name'] . "</td></tr>
                <tr><td>Company Name</td><td>" . $user_data['company_name'] . "</td></tr>
                <tr><td>Phone</td><td>" . $user_data['country_code'] . $user_data['mobile_number'] . "</td></tr>
                <tr><td>Email</td><td>" . $user_data['email_address'] . "</td></tr>
                <tr><td>MTB Maker</td><td>" . $requestjson['enquiry_details'] . "</td></tr>
                </table>";
                
               
                    //print_r($user_data);exit;
                    if ($user_data['country'] == '101') {
                        $state_data = end($this->obj_common->get_data(array('state_id' => $user_data['state']), 'fanuc_state'));
                        if ($state_data['state_zone'] == 'SZ') {
                            //$this->send_mail('servicesz@fanucindia.com', 'New Enquiry Request', $content);
                            $this->send_mail('maneesh@focaloid.com', 'New Enquiry Request', $content);
                        }

                        if ($state_data['state_zone'] == 'EZ') {
                            //$this->send_mail('serviceez@fanucindia.com', 'New Enquiry Request', $content);
                            $this->send_mail('maneesh@focaloid.com', 'New Enquiry Request', $content);
                        }

                        if ($state_data['state_zone'] == 'WZ') {
                            //$this->send_mail('servicewz@fanucindia.com', 'New Enquiry Request', $content);
                            $this->send_mail('maneesh@focaloid.com', 'New Enquiry Request', $content);
                        }

                        if ($state_data['state_zone'] == 'NZ') {
                           // $this->send_mail('servicenz@fanucindia.com', 'New Enquiry Request', $content);
                            $this->send_mail('maneesh@focaloid.com', 'New Enquiry Request', $content);
                        }
                    } else {
                        //$this->send_mail('servicesz@fanucindia.com', 'New Foc Registration Request', $content);
                        $this->send_mail('maneesh@focaloid.com', 'New Enquiry Request', $content);
                    }
                
                
                $ins_arr = array('user_id' => $requestjson['user_id'], 'enquiry_details' => $requestjson['enquiry_details'],
                    'created_date' => date('Y-m-d H:i:s'));
                $insert = $this->obj_common->insert($ins_arr, 'fanuc_enquiry');
                $json['success'] = true;
                $json['message'] = "Enquiry has been successfully send.";
                $this->send_response($json);
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

}
