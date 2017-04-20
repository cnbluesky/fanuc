<?php
ini_set('max_execution_time', 0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
        if (!empty($this->session->userdata("ADMIN_ID"))) {
            redirect(base_url() . 'user');
        }
    }

    public function index() {
        $data = array();
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $condition = array('admin_username' => $this->input->post('username', TRUE), 'admin_password' => md5($this->input->post('password', TRUE)));
            $user_data = end($this->obj_common->get_data($condition, 'fanuc_admin'));

            if (empty($user_data)) {
                $data['error_message'] = 'Invalid username or Password';
            } else {
                $this->session->set_userdata("ADMIN_ID", $user_data['admin_id']);
                redirect(base_url() . 'user/');
            }
        }
        $this->load->view('login', $data);
    }

    public function forgot_password() {
        $this->form_validation->set_rules('admin_email', 'Email', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $condition = array('admin_email' => $this->input->post('admin_email', TRUE));
            $user_data = end($this->obj_common->get_data($condition, 'fanuc_admin'));

            if (empty($user_data)) {
                $data['error_message'] = 'Invalid Admin Email';
            } else {
                $reset_code = $this->random_key();
                $email = $this->input->post('admin_email', TRUE);
                $code = $reset_code;
                $condition = array('admin_email' => $this->input->post('admin_email', TRUE));
                $data = array('reset_code' => $reset_code);
                $this->obj_common->update($condition, $data, 'fanuc_admin');
                $content = "<table>
                <tr><td>Please Click the Below Link to Reset Your Password</td></tr>
                <tr><td><a href=" . base_url() . "reset/reset_admin_password?email=" . $email . "&code=" . $code . ">Click Here</a></td></tr>
                </table>";
                $this->send_mail($this->input->post('admin_email', TRUE), 'Fanuc Reset Password', $content);
                $data['error_message'] = 'Please check your mail';
            }
        }

        $this->load->view('forgot_password', $data);
    }

    public function upload_csv() {
        if (isset($_REQUEST['upload'])) {
            $filename = $_FILES["csv_file"]["tmp_name"];

            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 100000, ",")) !== FALSE) {
                $ins_arr = array('country_id' => $getData['0'],'country_name' => $getData['2'],'country_code' => $getData['1'],'phone_code' => "+".$getData['3']);
                $this->obj_common->insert($ins_arr, 'fanuc_country');
            }

            echo 'Completed';
        }
        $this->load->view('upload');
    }

    public function upload_state() {
        if (isset($_REQUEST['upload'])) {
            $filename = $_FILES["file"]["tmp_name"];

            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 100000, ",")) !== FALSE) {

                $ins_arr = array('state_id' => $getData['0'],'state_name' => $getData['1'], 'country_id' => $getData['2']);
                $this->obj_common->insert($ins_arr, 'fanuc_state');
            }

            echo 'Completed';
        }
        $this->load->view('upload');
    }

    public function upload_city() {
        if (isset($_REQUEST['upload'])) {
            $filename = $_FILES["file"]["tmp_name"];

            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 100000, ",")) !== FALSE) {
                
                $ins_arr = array('city_id' => $getData['0'],'city_name' => $getData['1'], 'state_id' => $getData['2']);
                $this->obj_common->insert($ins_arr, 'fanuc_city');
            }

            echo 'Completed';
        }
        $this->load->view('upload');
    }
    
    
    public function upload()
    {
       if (isset($_REQUEST['upload'])) {
            
            $file = fopen($_SERVER['DOCUMENT_ROOT'].'/us.csv', "r");
            
            while (($getData = fgetcsv($file, 100000, ",")) !== FALSE) {
                
                $ins_arr = array('postal_code' => $getData['0'],'city_name' => $getData['1'], 
                    'state_name' => $getData['2'],'state_code' => $getData['3']);
                $this->obj_common->insert($ins_arr, 'us_zip_code');
            }

            echo 'Completed';
        }
        $this->load->view('upload'); 
    }

}
