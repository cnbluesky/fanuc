<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
        if (empty($this->session->userdata("ADMIN_ID"))) {
            redirect(base_url());
        }
    }

    public function index() {
        $condition = array();
        $data['user'] = $this->obj_common->get_user_data($condition);
        $this->load->view('user', $data);
    }

    public function view_user($id) {
        $condition = array('user_id' => $id);
        $data['user'] = end($this->obj_common->get_user_data($condition));
        //echo "<pre>";print_r($data);exit;
        $this->load->view('user_details', $data);
    }

    public function change_status() {
        $condition = array('user_id' => $_REQUEST['user_id']);
        $data = array('user_status' => $_REQUEST['user_status']);
        $this->obj_common->update($condition, $data, 'fanuc_user');
        $json['status'] = '1';
        $json['message'] = 'Updated';
        echo json_encode($json);
    }

    public function change_password() {
        $data = array();
        $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $condition = array('admin_id' => $this->session->userdata("ADMIN_ID"));
            $data = end($this->obj_common->get_data($condition, 'fanuc_admin'));
            if ($data['admin_password'] == md5($this->input->post('old_password', TRUE))) {
                $this->obj_common->update($condition, array('admin_password' => md5($this->input->post('new_password', TRUE))), 'fanuc_admin');
                $data['error_message'] = 'Password Successfully Updated';
            } else {
                $data['error_message'] = 'Old password not match';
            }
        }
        $this->load->view('change_password', $data);
    }

    public function settings() {
        $data = array();
        $condition = array('admin_id' => $this->session->userdata("ADMIN_ID"));
        $data['user'] = end($this->obj_common->get_data($condition, 'fanuc_admin'));
        $this->form_validation->set_rules('admin_email', 'Admin Email', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $this->obj_common->update($condition, array('admin_email' => $this->input->post('admin_email', TRUE)), 'fanuc_admin');
            redirect(base_url() . 'user/settings');
        }

        $this->load->view('settings', $data);
    }

    public function city_status() {
        $state = $this->obj_common->get_states();
        foreach ($state as $val) {
            $data = array('city_status' => '1');
            $this->obj_common->update(array('state_id' => $val['state_id']), $data, 'fanuc_city');
        }
        echo "<pre>";
        print_r($state);
    }

}
