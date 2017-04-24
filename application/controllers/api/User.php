<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);

            if (empty($requestjson['state'])) {
                $state = "";
            } else {
                $state = $requestjson['state'];
            }

            if (empty($requestjson['city'])) {
                $city = "";
            } else {
                $city = $requestjson['city'];
            }

            if (empty($requestjson['pin_code'])) {
                $pin_code = "";
            } else {
                $pin_code = $requestjson['pin_code'];
            }

            $ins_arr = array(
                'name' => $requestjson['name'],
                'designation' => $requestjson['designation'],
                'company_name' => $requestjson['company_name'],
                'company_address' => $requestjson['company_address'],
                'country' => $requestjson['country'],
                'state' => $state,
                'city' => $city,
                'pin_code' => $pin_code,
                'mobile_number' => $requestjson['mobile_number'],
                'country_code' => $requestjson['country_code'],
                'email_address' => $requestjson['email_address'],
                'company_tnt_cst_no' => $requestjson['company_tnt_cst_no'],
                'company_pan' => $requestjson['company_pan'],
                'user_type' => $requestjson['user_type'],
                'user_name' => $requestjson['user_name'],
                'password' => md5($requestjson['password']),
                'otp_status' => '0',
                'user_otp' => '0',
                'user_status' => '1',
                'created_date' => date('Y-m-d H:i:s')
            );
            //$this->obj_common->insert($ins_arr,'fanuc_user');
            $email = end($this->obj_common->get_data(array('email_address' => $requestjson['email_address']), 'fanuc_user'));
            $mobile = end($this->obj_common->get_data(array('mobile_number' => $requestjson['mobile_number']), 'fanuc_user'));
            $user_name = end($this->obj_common->get_data(array('user_name' => $requestjson['user_name']), 'fanuc_user'));
            if (!empty($email)) {
                $json['success'] = false;
                $json['message'] = "Email Already registered.";
                $this->send_response($json);
            } else if (!empty($mobile)) {
                $json['success'] = false;
                $json['message'] = "Mobile Already registered.";
                $this->send_response($json);
            } else if (!empty($user_name)) {
                $json['success'] = false;
                $json['message'] = "Username Already registered.";
                $this->send_response($json);
            } else {
                $insert = $this->obj_common->insert($ins_arr, 'fanuc_user');
                $user = end($this->obj_common->get_data(array('user_id' => $insert), 'fanuc_user'));
                $user_id = $user['user_id'];
                $user_status = $user['otp_status'];
                $user_details = array(
                    'user_id' => "$user_id",
                    'name' => $user['name'],
                    'designation' => $user['designation'],
                    'company_name' => $user['company_name'],
                    'company_address' => $user['company_address'],
                    'country' => $user['country'],
                    'state' => $user['state'],
                    'city' => $user['city'],
                    'pin_code' => $user['pin_code'],
                    'mobile_number' => $user['mobile_number'],
                    'country_code' => $user['country_code'],
                    'email_address' => $user['email_address'],
                    'company_tnt_cst_no' => $user['company_tnt_cst_no'],
                    'company_pan' => $user['company_pan'],
                    'user_type' => $user['user_type'],
                    'user_name' => $user['user_name'],
                    'otp_status' => "$user_status",
                );


                $json['success'] = true;
                $json['user'] = $user_details;
                $this->send_response($json);
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);

            if (empty($requestjson['user_name'])) {
                $json['success'] = false;
                $json['message'] = "Username is Required.";
                $this->send_response($json);
            } elseif (empty($requestjson['password'])) {
                $json['success'] = false;
                $json['message'] = "Password is Required.";
                $this->send_response($json);
            } else {
                $user = end($this->obj_common->get_data(array('user_name' =>
                            $requestjson['user_name'], 'password' => md5($requestjson['password'])), 'fanuc_user'));
                if (empty($user)) {
                    $json['success'] = false;
                    $json['message'] = "Invalid username or password.";
                    $this->send_response($json);
                } else {
                    if ($user['user_status'] == '1') {
                        $user_id = $user['user_id'];
                        $user_status = $user['otp_status'];
                        $user_details = array(
                            'user_id' => "$user_id",
                            'name' => $user['name'],
                            'designation' => $user['designation'],
                            'company_name' => $user['company_name'],
                            'company_address' => $user['company_address'],
                            'country' => $user['country'],
                            'state' => $user['state'],
                            'city' => $user['city'],
                            'pin_code' => $user['pin_code'],
                            'mobile_number' => $user['mobile_number'],
                            'country_code' => $user['country_code'],
                            'email_address' => $user['email_address'],
                            'company_tnt_cst_no' => $user['company_tnt_cst_no'],
                            'company_pan' => $user['company_pan'],
                            'user_type' => $user['user_type'],
                            'user_name' => $user['user_name'],
                            'otp_status' => "$user_status"
                        );

                        $json['success'] = true;
                        $json['user'] = $user_details;
                        $json['message'] = "You Have successfully login";
                        $this->send_response($json);
                    } else {
                        $json['success'] = false;
                        $json['message'] = "Your account is deactivated";
                        $this->send_response($json);
                    }
                }
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function my_account() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            if (empty($requestjson['user_id'])) {
                $json['success'] = false;
                $json['message'] = "User id is Required";
                $this->send_response($json);
            } else {
                $user = end($this->obj_common->myaccount_data(array('u.user_id' =>
                            $requestjson['user_id']), 'fanuc_user'));
                //print_r($user);exit;
                if (empty($user)) {
                    $json['success'] = false;
                    $json['message'] = "User not exists";
                    $this->send_response($json);
                } else {
                    $user_id = $user['user_id'];
                    $user_details = array(
                        'user_id' => "$user_id",
                        'name' => $user['name'],
                        'designation' => $user['designation'],
                        'company_name' => $user['company_name'],
                        'company_address' => $user['company_address'],
                        'country' => $user['country'],
                        'state' => $user['state'],
                        'city' => $user['city'],
                        'pin_code' => $user['pin_code'],
                        'mobile_number' => $user['mobile_number'],
                        'country_code' => $user['country_code'],
                        'email_address' => $user['email_address'],
                        'company_tnt_cst_no' => $user['company_tnt_cst_no'],
                        'company_pan' => $user['company_pan'],
                        'user_type' => $user['user_type'],
                        'user_name' => $user['user_name'],
                        'country_name' => $user['country_name'],
                        'city_name' => $user['city_name'],
                        'state_name' => $user['state_name'],
                    );

                    $json['success'] = true;
                    $json['user'] = $user_details;
                    $this->send_response($json);
                }
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function update_profile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);

            if (empty($requestjson['user_id'])) {
                $json['success'] = false;
                $json['message'] = "User id is Required";
                $this->send_response($json);
            } else {
                if (!empty($requestjson['name'])) {
                    $update_arr['name'] = $requestjson['name'];
                }

                if (!empty($requestjson['designation'])) {
                    $update_arr['designation'] = $requestjson['designation'];
                }

                if (!empty($requestjson['company_name'])) {
                    $update_arr['company_name'] = $requestjson['company_name'];
                }

                if (!empty($requestjson['company_address'])) {
                    $update_arr['company_address'] = $requestjson['company_address'];
                }

                if (!empty($requestjson['country'])) {
                    $update_arr['country'] = $requestjson['country'];
                }

                if (!empty($requestjson['state'])) {
                    $update_arr['state'] = $requestjson['state'];
                }

                if (!empty($requestjson['city'])) {
                    $update_arr['city'] = $requestjson['city'];
                }

                if (!empty($requestjson['pin_code'])) {
                    $update_arr['pin_code'] = $requestjson['pin_code'];
                }

                if (!empty($requestjson['company_tnt_cst_no'])) {
                    $update_arr['company_tnt_cst_no'] = $requestjson['company_tnt_cst_no'];
                }

                if (!empty($requestjson['company_pan'])) {
                    $update_arr['company_pan'] = $requestjson['company_pan'];
                }

                if (!empty($requestjson['user_type'])) {
                    $update_arr['user_type'] = $requestjson['user_type'];
                }

                $this->obj_common->update(array('user_id' => $requestjson['user_id']), $update_arr, 'fanuc_user');

                $user = end($this->obj_common->myaccount_data(array('u.user_id' =>
                            $requestjson['user_id']), 'fanuc_user'));

                $user_id = $user['user_id'];
                $user_details = array(
                    'user_id' => "$user_id",
                    'name' => $user['name'],
                    'designation' => $user['designation'],
                    'company_name' => $user['company_name'],
                    'company_address' => $user['company_address'],
                    'country' => $user['country'],
                    'state' => $user['state'],
                    'city' => $user['city'],
                    'pin_code' => $user['pin_code'],
                    'mobile_number' => $user['mobile_number'],
                    'country_code' => $user['country_code'],
                    'email_address' => $user['email_address'],
                    'company_tnt_cst_no' => $user['company_tnt_cst_no'],
                    'company_pan' => $user['company_pan'],
                    'user_type' => $user['user_type'],
                    'user_name' => $user['user_name'],
                    'country_name' => $user['country_name'],
                    'city_name' => $user['city_name'],
                    'state_name' => $user['state_name']
                );

                $json['success'] = true;
                $json['user'] = $user_details;
                $this->send_response($json);
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function change_password() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);

            if (empty($requestjson['user_id'])) {
                $json['success'] = false;
                $json['message'] = "User id is Required";
                $this->send_response($json);
            } elseif (empty($requestjson['old_password'])) {
                $json['success'] = false;
                $json['message'] = "Old password is Required";
                $this->send_response($json);
            } elseif (empty($requestjson['new_password'])) {
                $json['success'] = false;
                $json['message'] = "New password is Required";
                $this->send_response($json);
            } else {
                $user = end($this->obj_common->get_data(array('user_id' =>
                            $requestjson['user_id']), 'fanuc_user'));
                if (md5($requestjson['old_password']) == $user['password']) {
                    $update_arr = array('password' => md5($requestjson['new_password']));
                    $this->obj_common->update(array('user_id' => $requestjson['user_id']), $update_arr, 'fanuc_user');
                    $json['success'] = true;
                    $json['message'] = "Password has been successfully updated.";
                    $this->send_response($json);
                } else {
                    $json['success'] = false;
                    $json['message'] = "Old Password is incorrect.";
                    $this->send_response($json);
                }
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function forgot_password() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            if (empty($requestjson['email_address'])) {
                $json['success'] = false;
                $json['message'] = "Email is Required.";
                $this->send_response($json);
            } else {
                $email_check = $this->obj_common->get_data(array('email_address' => $requestjson['email_address']), 'fanuc_user');
                if (empty($email_check)) {
                    $json['success'] = false;
                    $json['message'] = "Email not found in our database";
                    $this->send_response($json);
                } else {
                    $reset_code = $this->random_key();
                    $email = $requestjson['email_address'];
                    $code = $reset_code;
                    $condition = array('email_address' => $requestjson['email_address']);
                    $data = array('reset_code' => $reset_code);
                    $this->obj_common->update($condition, $data, 'fanuc_user');
                    $content = "<table>
                <tr><td>Please Click the Below Link to Reset Your Password</td></tr>
                <tr><td><a href=" . base_url() . "reset/reset_user_password?email=" . $email . "&code=" . $code . ">Click Here</a></td></tr>
                </table>";
                    $this->send_mail($requestjson['email_address'], 'Fanuc Reset Password', $content);
                    $json['success'] = true;
                    $json['message'] = "Please check your email";
                    $this->send_response($json);
                }
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function check_user_exists() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            $email = end($this->obj_common->get_data(array('email_address' => $requestjson['email_address']), 'fanuc_user'));
            $mobile = end($this->obj_common->get_data(array('mobile_number' => $requestjson['mobile_number']), 'fanuc_user'));

            if (!empty($mobile) && !empty($email)) {
                $json['success'] = false;
                $json['message'] = "Mobile and Email Already registered.";
                $this->send_response($json);
            }
            if (!empty($email)) {
                $json['success'] = false;
                $json['message'] = "Email Already registered.";
                $this->send_response($json);
            }

            if (!empty($mobile)) {
                $json['success'] = false;
                $json['message'] = "Mobile Already registered.";
                $this->send_response($json);
            }

            $json['success'] = true;
            $this->send_response($json);
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function about_us() {
        $about = end($this->obj_common->get_data(array(), 'fanuc_aboutus'));
        $json['success'] = true;
        $json['about_us'] = $about['content'];
        $this->send_response($json);
    }

    public function country_list() {
        $country_list = array();
        //$country = $this->obj_common->get_data(array(), 'Master.ountries');
        $country = $this->obj_common->get_data(array('country_status' => '1'), 'fanuc_country');
        foreach ($country as $key => $val) {
            $country_id = $val['country_id'];
            $country_list[$key]['country_id'] = "$country_id";
            $country_list[$key]['country_name'] = $val['country_name'];
            $country_list[$key]['country_code'] = $val['country_code'];
            $country_list[$key]['phone_code'] = $val['phone_code'];
        }
        $json['success'] = true;
        $json['countries'] = $country_list;
        $this->send_response($json);
    }

    public function state_list() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            if (empty($requestjson['country_id'])) {
                $json['success'] = false;
                $json['message'] = "Country id is Required.";
                $this->send_response($json);
            } else {
                $state_list = array();
                //$state = $this->obj_common->get_data(array('CountryID' => $requestjson['country_id']), 'Master.States');
                $state = $this->obj_common->get_data(array('country_id' => $requestjson['country_id']), 'fanuc_state');
                foreach ($state as $key => $val) {
                    $state_id = $val['state_id'];
                    $country_id = $val['country_id'];
                    $state_list[$key]['state_id'] = "$state_id";
                    $state_list[$key]['state_name'] = $val['state_name'];
                    $state_list[$key]['country_id'] = $val['country_id'];
                }
                $json['success'] = true;
                $json['state'] = $state_list;
                $this->send_response($json);
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function city_list() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            if (empty($requestjson['state_id'])) {
                $json['success'] = false;
                $json['message'] = "State id is Required.";
                $this->send_response($json);
            } else {
                $city_list = array();
                //$city = $this->obj_common->get_data(array('StateID' => $requestjson['state_id']), 'Master.Cities');
                $city = $this->obj_common->get_data(array('state_id' => $requestjson['state_id']), 'fanuc_city');
                foreach ($city as $key => $val) {
                    $city_id = $val['city_id'];
                    $state_id = $val['state_id'];
                    $city_list[$key]['city_id'] = "$city_id";
                    $city_list[$key]['city_name'] = $val['city_name'];
                    $city_list[$key]['state_id'] = "$state_id";
                }

                $json['success'] = true;
                $json['city'] = $city_list;
                $this->send_response($json);
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function send_otp() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            if (empty($requestjson['mobile'])) {
                $json['success'] = false;
                $json['message'] = "Mobile number is required.";
                $this->send_response($json);
            } elseif (empty($requestjson['user_id'])) {
                $json['success'] = false;
                $json['message'] = "User id is required.";
                $this->send_response($json);
            } else {
                $random_number = rand(111111, 999999);
                $this->obj_common->update(array('user_id' => $requestjson['user_id']), array('user_otp' => $random_number), 'fanuc_user');
                $message = "Your OTP for Fanuc is " . $random_number;
                $message = urlencode($message);
                $mobile = str_replace('+', '', $requestjson['mobile']);

                $url = "http://enterprise.smsgupshup.com/GatewayAPI/rest?method=SendMessage&send_to=" . $mobile . "&msg=" . $message . "&msg_type=TEXT&userid=2000168020&auth_scheme=plain&password=jlSZsFid1&v=1.1&format=text";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                curl_close($ch);

                if (strpos($result, 'success') !== false) {
                    $json['success'] = true;
                    $json['message'] = "OTP send successfully.";
                    $this->send_response($json);
                } else {
                    $json['success'] = false;
                    $json['message'] = "OTP sending failed.";
                    $this->send_response($json);
                }
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function resend_otp() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            if (empty($requestjson['mobile'])) {
                $json['success'] = false;
                $json['message'] = "Mobile number is required.";
                $this->send_response($json);
            } elseif (empty($requestjson['user_id'])) {
                $json['success'] = false;
                $json['message'] = "User id is required.";
                $this->send_response($json);
            } else {
                $user_data = end($this->obj_common->get_data(array('user_id' => $requestjson['user_id']), 'fanuc_user'));

                $message = "Your OTP for Fanuc is " . $user_data['user_otp'];
                $message = urlencode($message);
                $mobile = str_replace('+', '', $requestjson['mobile']);

                $url = "http://enterprise.smsgupshup.com/GatewayAPI/rest?method=SendMessage&send_to=" . $mobile . "&msg=" . $message . "&msg_type=TEXT&userid=2000168020&auth_scheme=plain&password=jlSZsFid1&v=1.1&format=text";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                curl_close($ch);

                if (strpos($result, 'success') !== false) {
                    $json['success'] = true;
                    $json['message'] = "OTP send successfully.";
                    $this->send_response($json);
                } else {
                    $json['success'] = false;
                    $json['message'] = "OTP sending failed.";
                    $this->send_response($json);
                }
            }
        } else {
            $json['success'] = false;
            $json['message'] = "Only Post Method is allowded.";
            $this->send_response($json);
        }
    }

    public function verify_otp() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $requestjson = file_get_contents('php://input');
            $requestjson = json_decode($requestjson, true);
            if (empty($requestjson['user_id'])) {
                $json['success'] = false;
                $json['message'] = "User id is required.";
                $this->send_response($json);
            } elseif (empty($requestjson['otp'])) {
                $json['success'] = false;
                $json['message'] = "OTP is required.";
                $this->send_response($json);
            } else {
                $condition = array('user_id' => $requestjson['user_id'], 'user_otp' => $requestjson['otp']);
                $user_data = end($this->obj_common->get_data($condition, 'fanuc_user'));

                if (empty($user_data)) {
                    $json['success'] = false;
                    $json['message'] = "Invalid OTP";
                    $this->send_response($json);
                } else {
                    $data = array('otp_status' => '1', 'user_otp' => '0');
                    $this->obj_common->update($condition, $data, 'fanuc_user');
                    $json['success'] = true;
                    $json['message'] = "Your OTP has been verified";
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
