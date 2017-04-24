<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        
    }

    public function registration() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            if (empty($requestjson['user_id'])) {
                $json['success'] = false;
                $json['message'] = "User id is required.";
                $this->send_response($json);
            } else {
                $content = "
                <h4>New Product Registration Request</h4>  
                <table style='width:300px;'>
                <tr><td>MTB Maker</td><td>" . $requestjson['mtb_maker'] . "</td></tr>
                <tr><td>Machine Model</td><td>" . $requestjson['machine_model'] . "</td></tr>
                <tr><td>Machine Serial Number</td><td>" . $requestjson['machine_serial_number'] . "</td></tr>
                <tr><td>System Model</td><td>" . $requestjson['system_model'] . "</td></tr>
                <tr><td>System Serial Number</td><td>" . $requestjson['system_serial_number'] . "</td></tr>
                </table>";

                $product_data = end($this->obj_common->get_data(
                                array('system_serial_number' => $requestjson['system_serial_number']), 'fanuc_product_registration'));
                if (empty($product_data)) {
                    
                    $install_id = $requestjson['system_serial_number'];
                    $ins_arr = array('product_category_id' => $requestjson['product_category_id'], 'mtb_maker' => $requestjson['mtb_maker'],
                        'machine_model' => $requestjson['machine_model'], 'machine_serial_number' => $requestjson['machine_serial_number'],
                        'system_model' => $requestjson['system_model'], 'system_serial_number' => $requestjson['system_serial_number'],
                        'created_date' => date('Y-m-d H:i:s'), 'install_id' => $install_id, 'user_id' => $requestjson['user_id']);
                    $insert = $this->obj_common->insert($ins_arr, 'fanuc_product_registration');
                    $json['success'] = true;
                    $json['message'] = "Product has been successfully registered.";
                    $json['install_id'] = "$install_id";
                    $this->send_response($json);
                } else {
                    $json['success'] = false;
                    $json['message'] = "Product already registered.";
                    $this->send_response($json);
                }
            }
        } else {

            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function categories() {
        $product = $this->obj_common->get_data(array(), 'fanuc_product_category');
        foreach ($product as $key => $val) {
            $p_id = $val['product_category_id'];
            $product_category[$key]['product_category_id'] = "$p_id";
            $product_category[$key]['product_category_name'] = $val['product_category_name'];
            $product_category[$key]['product_category_description'] = $val['product_category_description'];
        }
        $json['success'] = true;
        $json['categories'] = $product_category;
        $this->send_response($json);
    }

    public function my_products() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            if (empty($requestjson['user_id'])) {
                $json['success'] = false;
                $json['message'] = "User id is required.";
                $this->send_response($json);
            } else {
                $condition = array('pd.user_id' => $requestjson['user_id']);
                $catgaries = $this->obj_common->get_product_categories($condition, $requestjson['limit'], $requestjson['page']);
                $catgaries_count = $this->obj_common->get_product_categories_count($condition);

                $products = array();
                if (!empty($catgaries)) {
                    //$products['product_category_count'] = $catgaries_count;
                    foreach ($catgaries as $key => $val) {
                        $product_category_id = $val['product_category_id'];
                        $products[$key]['product_category_id'] = "$product_category_id";
                        $products[$key]['product_category_name'] = $val['product_category_name'];
                        $products[$key]['products'] = array();
                        $condition = array('product_category_id' => $val['product_category_id'], 'user_id' => $requestjson['user_id']);
                        $product = $this->obj_common->get_data_pagination($condition, 'fanuc_product_registration', $requestjson['product_limit'], $requestjson['product_page']);


                        $products[$key]['product_page'] = $requestjson['product_page'];
                        $products[$key]['product_limit'] = $requestjson['product_limit'];
                        $condition4 = array('product_category_id' => $val['product_category_id'], 'user_id' => $requestjson['user_id']);
                        $product_count = $this->obj_common->get_my_product_count($condition4);
                        $products[$key]['product_count'] = "$product_count";
                        foreach ($product as $key1 => $val1) {

                            $product_registration_id = $val1['product_registration_id'];
                            $products[$key]['products'][$key1]['product_registration_id'] = "$product_registration_id";
                            $products[$key]['products'][$key1]['mtb_maker'] = $val1['mtb_maker'];
                            $products[$key]['products'][$key1]['machine_model'] = $val1['machine_model'];
                            $products[$key]['products'][$key1]['machine_serial_number'] = $val1['machine_serial_number'];
                            $products[$key]['products'][$key1]['system_model'] = $val1['system_model'];
                            $products[$key]['products'][$key1]['system_serial_number'] = $val1['system_serial_number'];
                            $products[$key]['products'][$key1]['created_date'] = date("d-M-Y", strtotime($val1['created_date']));
                            $products[$key]['products'][$key1]['install_id'] = $val1['install_id'];
                        }
                    }
                }
                $json['success'] = true;
                $json['product_category'] = $products;
                $json['category_count'] = "$catgaries_count";
                $this->send_response($json);
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function get_product_by_category() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            if (empty($requestjson['product_category_id'])) {
                $json['success'] = false;
                $json['message'] = "Category id is required.";
                $this->send_response($json);
            } elseif (empty($requestjson['user_id'])) {
                $json['success'] = false;
                $json['message'] = "User id is required.";
                $this->send_response($json);
            } else {
                $products = array();
                $condition = array('product_category_id' => $requestjson['product_category_id'], 'user_id' => $requestjson['user_id']);
                $product_count = $this->obj_common->get_product_count($condition);
                $product = $this->obj_common->get_data_pagination($condition, 'fanuc_product_registration', $requestjson['product_limit'], $requestjson['product_page']);
                $products['product_page'] = $requestjson['product_page'];
                $products['product_limit'] = $requestjson['product_limit'];
                foreach ($product as $key => $val) {

                    $product_registration_id = $val['product_registration_id'];
                    $products['data'][$key]['product_registration_id'] = "$product_registration_id";
                    $products['data'][$key]['mtb_maker'] = $val['mtb_maker'];
                    $products['data'][$key]['machine_model'] = $val['machine_model'];
                    $products['data'][$key]['machine_serial_number'] = $val['machine_serial_number'];
                    $products['data'][$key]['system_model'] = $val['system_model'];
                    $products['data'][$key]['system_serial_number'] = $val['system_serial_number'];
                    $products['data'][$key]['created_date'] = date("d-M-Y", strtotime($val['created_date']));
                    $products['data'][$key]['install_id'] = $val['install_id'];
                }

                $json['success'] = true;
                $json['products'] = $products;
                $json['product_count'] = "$product_count";
                $this->send_response($json);
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function install_id_list() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            if (empty($requestjson['product_category_id'])) {
                $json['success'] = false;
                $json['message'] = "Category id is required.";
                $this->send_response($json);
            } else {
                $install_id = array();
                $condition = array('product_category_id' => $requestjson['product_category_id'], 'user_id' => $requestjson['user_id']);
                $install_id = $this->obj_common->get_install_id($condition, 'fanuc_product_registration');

                $json['success'] = true;
                $json['install_id'] = $install_id;
                $this->send_response($json);
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function edit_product() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            if (empty($requestjson['product_registration_id'])) {
                $json['success'] = false;
                $json['message'] = "Product Registration id is Required";
                $this->send_response($json);
            } else {
                if (!empty($requestjson['product_category_id'])) {
                    $update_arr['product_category_id'] = $requestjson['product_category_id'];
                }

                if (!empty($requestjson['mtb_maker'])) {
                    $update_arr['mtb_maker'] = $requestjson['mtb_maker'];
                }

                if (!empty($requestjson['machine_model'])) {
                    $update_arr['machine_model'] = $requestjson['machine_model'];
                }

                if (!empty($requestjson['machine_serial_number'])) {
                    $update_arr['machine_serial_number'] = $requestjson['machine_serial_number'];
                }

                if (!empty($requestjson['system_model'])) {
                    $update_arr['system_model'] = $requestjson['system_model'];
                }

                if (!empty($requestjson['system_serial_number'])) {
                    $update_arr['system_serial_number'] = $requestjson['system_serial_number'];
                }
                $condition = array('product_registration_id' => $requestjson['product_registration_id']);
                $this->obj_common->update($condition, $update_arr, 'fanuc_product_registration');
                $data = end($this->obj_common->get_data($condition, 'fanuc_product_registration'));
                $user_id = $data['user_id'];
                $product_id = $data['product_registration_id'];
                $data['user_id'] = "$user_id";
                $data['product_registration_id'] = "$product_id";
                $data['user_id'] = '1';
                $json['success'] = true;
                $json['message'] = "Successfully Updated";
                $json['product'] = $data;
                $this->send_response($json);
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function delete_product() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            if (empty($requestjson['product_registration_id'])) {
                $json['success'] = false;
                $json['message'] = "Product Registration id is Required";
                $this->send_response($json);
            } else {
                $condition = array('product_registration_id' => $requestjson['product_registration_id']);
                $this->obj_common->delete($condition, 'fanuc_product_registration');
                $json['success'] = true;
                $json['message'] = "Product Has Been successfully deleted";
                $this->send_response($json);
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function product_search() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            $data = $this->obj_common->search_data($requestjson, $requestjson['page'], $requestjson['limit']);
            //echo $this->db->last_query();exit;
            $from_date = date("Y-m-d", strtotime($requestjson['from_date']));
            $to_date = date("Y-m-d", strtotime($requestjson['to_date']));

            $products = array();
            if (!empty($data)) {
                //$products['product_category_count'] = $catgaries_unt;
                foreach ($data as $key => $val) {
                    $product = $this->obj_common->get_product_search($val['product_category_id'], 'fanuc_product_registration', $requestjson['product_limit'], $requestjson['product_page'], $from_date, $to_date, $requestjson['user_id']);
                    //echo $this->db->last_query();exit;
                    if (!empty($product)) {
                        $product_category_id = $val['product_category_id'];
                        $products[$key]['product_category_id'] = "$product_category_id";
                        $products[$key]['product_category_name'] = $val['product_category_name'];
                        $products[$key]['products'] = array();
                        $products[$key]['product_page'] = $requestjson['product_page'];
                        $products[$key]['product_limit'] = $requestjson['product_limit'];
                        $condition4 = array('product_category_id' => $val['product_category_id'], 'user_id' => $requestjson['user_id']);
                        $product_count = $this->obj_common->get_product_count($condition4,$from_date, $to_date);
                        $products[$key]['product_count'] = "$product_count";
                        foreach ($product as $key1 => $val1) {

                            $product_registration_id = $val1['product_registration_id'];
                            $products[$key]['products'][$key1]['product_registration_id'] = "$product_registration_id";
                            $products[$key]['products'][$key1]['mtb_maker'] = $val1['mtb_maker'];
                            $products[$key]['products'][$key1]['machine_model'] = $val1['machine_model'];
                            $products[$key]['products'][$key1]['machine_serial_number'] = $val1['machine_serial_number'];
                            $products[$key]['products'][$key1]['system_model'] = $val1['system_model'];
                            $products[$key]['products'][$key1]['system_serial_number'] = $val1['system_serial_number'];
                            $products[$key]['products'][$key1]['created_date'] = date("d-M-Y", strtotime($val1['created_date']));
                            $products[$key]['products'][$key1]['install_id'] = $val1['install_id'];
                        }
                    }
                }
            }


            $json['success'] = true;
            $json['product_category'] = $products;

            $this->send_response($json);
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

}
