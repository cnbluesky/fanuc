<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Service_request extends CI_Controller {

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
                $json['message'] = "User id is Required.";
                $this->send_response($json);
            } elseif (empty($requestjson['service_type'])) {
                $json['success'] = false;
                $json['message'] = "Service Type is Required";
                $this->send_response($json);
            } else {
                $service_data = array();
                $service_data = end($this->obj_common->get_data(array(), 'fanuc_service_request'));

                if (empty($service_data)) {
                    $service_id = "00000001";
                } else {
                    $service_id = preg_replace("/[^0-9,.]/", "", $service_data['service_request_number']);
                    $service_id = str_pad($service_id + 1, 8, '0', STR_PAD_LEFT);
                }
                $service_request_id = "FM" . $service_id;
                $user_data = end($this->obj_common->get_data(array('user_id' => $requestjson['user_id']), 'fanuc_user'));


                //print_r($content);exit;

                if ($requestjson['service_type'] == 'service') {
                    if ($requestjson['product_registered'] == '0') {
                        $content = "
                        <h4>New Service Request #" . $service_request_id . "</h4>  
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
                        $install_id = $requestjson['system_serial_number'];
                        $ins_arr = array('product_category_id' => $requestjson['product_category_id'], 'mtb_maker' => $requestjson['mtb_maker'],
                            'machine_model' => $requestjson['machine_model'], 'machine_serial_number' => $requestjson['machine_serial_number'],
                            'system_model' => $requestjson['system_model'], 'system_serial_number' => $requestjson['system_serial_number'],
                            'created_date' => date('Y-m-d H:i:s'), 'install_id' => $install_id, 'user_id' => $requestjson['user_id']);
                        $insert = $this->obj_common->insert($ins_arr, 'fanuc_product_registration');

                        $ins_arr1 = array('user_id' => $requestjson['user_id'], 'service_type' => $requestjson['service_type'],
                            'product_category_id' => $requestjson['product_category_id'], 'install_id' => $install_id, 'problem_details' => $requestjson['problem_details'],
                            'created_date' => date('Y-m-d H:i:s'), 'service_request_number' => $service_request_id, 'request_status' => '0');
                        $this->obj_common->insert($ins_arr1, 'fanuc_service_request');
                    }
                    if ($requestjson['product_registered'] == '1') {
                        $pr_data = end($this->obj_common->get_data(array('install_id' => $requestjson['install_id']), 'fanuc_service_request'));
                        $content = "
                        <h4>New Service Request #" . $service_request_id . "</h4>  
                        <table style='width:300px;'>
                        <tr><td>Customer Name</td><td>" . $user_data['name'] . "</td></tr>
                        <tr><td>Company Name</td><td>" . $user_data['company_name'] . "</td></tr>
                        <tr><td>Phone</td><td>" . $user_data['country_code'] . $user_data['mobile_number'] . "</td></tr>
                        <tr><td>Email</td><td>" . $user_data['email_address'] . "</td></tr>
                        <tr><td>Machine Model</td><td>" . $pr_data['machine_model'] . "</td></tr>
                        <tr><td>Machine Serial Number</td><td>" . $pr_data['machine_serial_number'] . "</td></tr>
                        <tr><td>System Model</td><td>" . $pr_data['system_model'] . "</td></tr>
                        <tr><td>System Serial Number</td><td>" . $pr_data['system_serial_number'] . "</td></tr>
                        </table>";
                        $ins_arr1 = array('user_id' => $requestjson['user_id'], 'service_type' => $requestjson['service_type'],
                            'product_category_id' => $requestjson['product_category_id'], 'install_id' => $requestjson['install_id'], 'problem_details' => $requestjson['problem_details'],
                            'created_date' => date('Y-m-d H:i:s'), 'request_status' => '0', 'service_request_number' => $service_request_id);
                        $this->obj_common->insert($ins_arr1, 'fanuc_service_request');
                    }

                    if ($user_data['country'] == '101') {
                        $state_data = end($this->obj_common->get_data(array('state_id' => $user_data['state']), 'fanuc_state'));
                        if ($state_data['state_zone'] == 'SZ') {
                            //$this->send_mail('servicesz@fanucindia.com', 'New Foc Registration Request', $content);
                            $this->send_mail('maneesh@focaloid.com', 'South Zone', $content);
                        }

                        if ($state_data['state_zone'] == 'EZ') {
                            //$this->send_mail('serviceez@fanucindia.com', 'New Foc Registration Request', $content);
                            $this->send_mail('maneesh@focaloid.com', 'East Zone', $content);
                        }

                        if ($state_data['state_zone'] == 'WZ') {
                            //$this->send_mail('servicewz@fanucindia.com', 'New Foc Registration Request', $content);
                            $this->send_mail('maneesh@focaloid.com', 'West Zone', $content);
                        }

                        if ($state_data['state_zone'] == 'NZ') {
                            // $this->send_mail('servicenz@fanucindia.com', 'New Foc Registration Request', $content);
                            $this->send_mail('maneesh@focaloid.com', 'North Zone', $content);
                        }
                    } else {
                        //$this->send_mail('servicesz@fanucindia.com', 'New Foc Registration Request', $content);
                        $this->send_mail('maneesh@focaloid.com', 'Other', $content);
                    }
                    
                }


                    if ($requestjson['service_type'] == 'spare_part') {
                        $content = "
                        <h4>New Spare Part Request #" . $service_request_id . "</h4>  
                        <table style='width:300px;'>
                        <tr><td>Customer Name</td><td>" . $user_data['name'] . "</td></tr>
                        <tr><td>Company Name</td><td>" . $user_data['company_name'] . "</td></tr>
                        <tr><td>Phone</td><td>" . $user_data['country_code'] . $user_data['mobile_number'] . "</td></tr>
                        <tr><td>Email</td><td>" . $user_data['email_address'] . "</td></tr>
                        <tr><td>Problem Details</td><td>" . $requestjson['problem_details'] . "</td></tr>
                        
                        </table>";
                        
                        $ins_arr2 = array('user_id' => $requestjson['user_id'], 'service_type' => $requestjson['service_type'],
                            'problem_details' => $requestjson['problem_details'], 'created_date' => date('Y-m-d H:i:s'),
                            'product_category_id' => '', 'install_id' => '', 'request_status' => '0', 'service_request_number' => $service_request_id);
                        $this->obj_common->insert($ins_arr2, 'fanuc_service_request');
                        // $this->send_mail('spareparts@fanucindia.com', 'New Service Request', $content);
                        $this->send_mail('maneesh@focaloid.com', 'Spare Part', $content);
                         
                    }

                    if ($requestjson['service_type'] == 'repair') {
                        $content = "
                        <h4>New Repair Request #" . $service_request_id . "</h4>  
                        <table style='width:300px;'>
                        <tr><td>Customer Name</td><td>" . $user_data['name'] . "</td></tr>
                        <tr><td>Company Name</td><td>" . $user_data['company_name'] . "</td></tr>
                        <tr><td>Phone</td><td>" . $user_data['country_code'] . $user_data['mobile_number'] . "</td></tr>
                        <tr><td>Email</td><td>" . $user_data['email_address'] . "</td></tr>
                        <tr><td>Problem Details</td><td>" . $requestjson['problem_details'] . "</td></tr>
                        
                        </table>";
                        
                        $ins_arr3 = array('user_id' => $requestjson['user_id'], 'service_type' => $requestjson['service_type'],
                            'problem_details' => $requestjson['problem_details'], 'created_date' => date('Y-m-d H:i:s'),
                            'product_category_id' => '', 'install_id' => '', 'request_status' => '0', 'service_request_number' => $service_request_id);
                        $this->obj_common->insert($ins_arr3, 'fanuc_service_request');
                        //$this->send_mail('repairs@fanucindia.com', 'New Service Request', $content);
                        $this->send_mail('maneesh@focaloid.com', 'Repair', $content);
                        
                    }

                    $json['success'] = true;
                    $json['message'] = "Your request has been successfully registered.";
                    $this->send_response($json);
                }
            }
         else {

            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function my_request() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);

            if (empty($requestjson['user_id'])) {
                $json['success'] = false;
                $json['message'] = "User id is Required.";
                $this->send_response($json);
            } else {
                $condition = array('user_id' => $requestjson['user_id']);
                $result = $this->obj_common->get_service_date($condition, $requestjson['limit'], $requestjson['page']);
                //echo $this->db->last_query();exit;
                $result_count = $this->obj_common->get_service_date_count($condition);
                $date_arr = array();
                if (!empty($result)) {
                    foreach ($result as $key => $val) {
                        $date_arr[$key]['date'] = $val['date'];
                        $request = $this->obj_common->get_service_by_date(array('CAST(created_date AS DATE) = ' => $val['date']), $requestjson['service_limit'], $requestjson['service_page'], $requestjson['user_id']);

                        $request_status = $this->obj_common->get_service_by_date_status(array('CAST(created_date AS DATE) = ' => $val['date'], 'request_status' => '1'));
                        //echo $this->db->last_query();exit;
                        if (!empty($request_status)) {
                            $date_arr[$key]['color_status'] = '1';
                        } else {
                            $date_arr[$key]['color_status'] = '0';
                        }
                        $service_count = $this->obj_common->get_service_c(array('CAST(created_date AS DATE) = ' => $val['date']), $requestjson['user_id']);
                        //echo $this->db->last_query();exit;
                        $date_arr[$key]['service_count'] = "$service_count";
                        $date_arr[$key]['service_page'] = $requestjson['service_page'];
                        foreach ($request as $key1 => $val1) {

                            $service_request_id = $val1['service_request_id'];
                            $request_status = $val1['request_status'];
                            $date_arr[$key]['request'][$key1]['service_request_id'] = "$service_request_id";
                            $date_arr[$key]['request'][$key1]['service_type'] = $val1['service_type'];
                            $date_arr[$key]['request'][$key1]['install_id'] = $val1['install_id'];
                            $date_arr[$key]['request'][$key1]['problem_details'] = $val1['problem_details'];
                            $date_arr[$key]['request'][$key1]['request_status'] = "$request_status";
                            $current_date = strtotime(date('Y-m-d H:i:s'));
                            $request_date = strtotime($val1['created_date']);
                            $time_difference = round(abs($current_date - $request_date) / 60, 2);

                            if ($time_difference > 1440) {
                                $date_arr[$key]['request'][$key1]['resend_status'] = "1";
                            } else {
                                $date_arr[$key]['request'][$key1]['resend_status'] = "0";
                            }
                        }
                    }
                }

                $json['success'] = true;
                $json['service_request'] = $date_arr;
                $json['service_count'] = "$result_count";
                $this->send_response($json);
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function resend() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);

            if (empty($requestjson['service_request_id'])) {
                $json['success'] = false;
                $json['message'] = "Service request id is required";
                $this->send_response($json);
            } else {


                $condition = array('service_request_id' => $requestjson['service_request_id']);
                $service_data = end($this->obj_common->get_data($condition, 'fanuc_service_request'));

                $content = "
                <h4>New Service Request</h4>  
                <table style='width:300px;'>
                <tr><td>Service Request Number</td><td>" . $service_data['service_request_number'] . "</td></tr>
                    <tr><td>Problem Details</td><td>" . $service_data['problem_details'] . "</td></tr>
                 </table>";
                //$this->send_mail('arun.hd@fanucindia.com', 'New Service Request', $content);
                //$this->send_mail('vinay.kumar@fanucindia.com', 'New Service Request', $content);
                $this->send_mail('maneesh@focaloid.com', 'New Foc Registration Request', $content);
                $data = array('created_date' => date('Y-m-d H:i:s'));
                $this->obj_common->update($condition, $data, 'fanuc_service_request');
                $json['success'] = true;
                $json['message'] = "Your request has been successfully send.";
                $this->send_response($json);
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function my_request_by_date() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);

            if (empty($requestjson['date'])) {
                $json['success'] = false;
                $json['message'] = "Date  is required";
                $this->send_response($json);
            }

            $request = $this->obj_common->get_service_by_date(array('CAST(created_date AS DATE) = ' => $requestjson['date']), $requestjson['service_limit'], $requestjson['service_page'], $requestjson['user_id']);

            $service_count = $this->obj_common->get_service_c(array('CAST(created_date AS DATE) = ' => $requestjson['date']), $requestjson['user_id']);
            $date_arr = array();
            foreach ($request as $key => $val) {

                $service_request_id = $val['service_request_id'];
                $request_status = $val['request_status'];
                $date_arr[$key]['service_request_id'] = "$service_request_id";
                $date_arr[$key]['service_type'] = $val['service_type'];
                $date_arr[$key]['install_id'] = $val['install_id'];
                $date_arr[$key]['problem_details'] = $val['problem_details'];
                $date_arr[$key]['request_status'] = "$request_status";
                $current_date = strtotime(date('Y-m-d H:i:s'));
                $request_date = strtotime($val['created_date']);
                $time_difference = round(abs($current_date - $request_date) / 60, 2);

                if ($time_difference > 1440) {
                    $date_arr[$key]['resend_status'] = "1";
                } else {
                    $date_arr[$key]['resend_status'] = "0";
                }
            }

            $json['success'] = true;
            $json['service_request'] = $date_arr;
            $json['service_count'] = "$service_count";
            $this->send_response($json);
        } else {

            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

}
