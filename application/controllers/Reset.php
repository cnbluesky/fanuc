<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reset extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
    }

    public function reset_user_password() {
        $data = array();
        $email = $this->input->get('email', TRUE);
        $code = $this->input->get('code', TRUE);
        $condition = array('email_address' => $email, 'reset_code' => $code);
        $data = $this->obj_common->get_data($condition, 'fanuc_user');
        if (empty($data)) {
            $data['error_message'] = "Reset code Invalid or Expired";
        } else {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                
            } else {
                $arr = array('password' => md5($this->input->post('password', TRUE)), 'reset_code' => '');
                $this->obj_common->update($condition, $arr, 'fanuc_user');
                $data['error_message'] = "Password has been successfully updated";
            }
        }
        $this->load->view('reset_user_password', $data);
    }

    public function reset_admin_password() {
        $data = array();
        $email = $this->input->get('email', TRUE);
        $code = $this->input->get('code', TRUE);
        $condition = array('admin_email' => $email, 'reset_code' => $code);
        $data = $this->obj_common->get_data($condition, 'fanuc_admin');

        if (empty($data)) {
            $data['error_message'] = "Reset code Invalid or Expired";
        } else {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                
            } else {
                $arr = array('admin_password' => md5($this->input->post('password', TRUE)), 'reset_code' => '');
                $this->obj_common->update($condition, $arr, 'fanuc_admin');
                $data['error_message'] = "Password has been successfully updated";
            }
        }
        $this->load->view('reset_user_password', $data);
    }

}
