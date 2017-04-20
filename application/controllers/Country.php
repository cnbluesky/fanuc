<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Country extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
        if (empty($this->session->userdata("ADMIN_ID"))) {
            redirect(base_url());
        }
    }

    public function index() {
        $condition = array('country_status' => '1');
        $data['country'] = $this->obj_common->get_data($condition, 'fanuc_country');
        $this->load->view('country_list', $data);
    }

    public function add_country() {
        
        $this->form_validation->set_rules('country_name', 'Country Name', 'trim|required');
        $this->form_validation->set_rules('country_code', 'Country Code', 'trim|required');
        $this->form_validation->set_rules('phone_code', 'Phone Code', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $country_name = $this->obj_common->get_data(array('country_name' => $this->input->post('country_name', TRUE)), 'fanuc_country');
            $country_code = $this->obj_common->get_data(array('country_code' => $this->input->post('country_code', TRUE)), 'fanuc_country');
            $phone_code = $this->obj_common->get_data(array('phone_code' => $this->input->post('phone_code', TRUE)), 'fanuc_country');
            if (!empty($country_name)) {
                $data['error_message'] = 'Country name already exists';
            } elseif (!empty($country_code)) {
                $data['error_message'] = 'Country code already exists';
            } elseif (!empty($phone_code)) {
                $data['error_message'] = 'Phone code already exists';
            } else {
                $code = $this->input->post('phone_code', TRUE);
                if (strpos($code, '+') !== false) {
                    $phone_code = $this->input->post('phone_code', TRUE);
                } else {
                    $phone_code = "+" . $this->input->post('phone_code', TRUE);
                }
                $country_data = end($this->obj_common->get_data_orderby(array(),'fanuc_country','country_id'));
                $country_id = $country_data['country_id'] + 1;
                $ins_arr = array('country_id' => $country_id,'country_name' => $this->input->post('country_name', TRUE), 
                    'country_code' => $this->input->post('country_code', TRUE),
                    'phone_code' => $phone_code,'country_status' => '0');
                $this->obj_common->insert($ins_arr, 'fanuc_country');
                
                $this->session->set_flashdata('message', 'Country Added successfully');
                redirect(base_url() . 'country');
            }
        }
        $this->load->view('add_country', $data);
    }

    public function edit_country($id) {
        $condition = array('country_id' => $id);
        $data['country'] = end($this->obj_common->get_data($condition, 'fanuc_country'));

        $this->form_validation->set_rules('country_name', 'Country Name', 'trim|required');
        $this->form_validation->set_rules('country_code', 'Country Code', 'trim|required');
        $this->form_validation->set_rules('phone_code', 'Phone Code', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $country_name = $this->obj_common->get_data(array('country_name' => $this->input->post('country_name', TRUE), 'country_id !=' => $id), 'fanuc_country');

            $country_code = $this->obj_common->get_data(array('country_code' => $this->input->post('country_code', TRUE), 'country_id !=' => $id), 'fanuc_country');
            $phone_code = $this->obj_common->get_data(array('phone_code' => $this->input->post('phone_code', TRUE), 'country_id !=' => $id), 'fanuc_country');
            if (!empty($country_name)) {
                $data['error_message'] = 'Country name already exists';
            } elseif (!empty($country_code)) {
                $data['error_message'] = 'Country code already exists';
            } elseif (!empty($phone_code)) {
                $data['error_message'] = 'Phone code already exists';
            } else {
                $code = $this->input->post('phone_code', TRUE);
                if (strpos($code, '+') !== false) {
                    $phone_code = $this->input->post('phone_code', TRUE);
                } else {
                    $phone_code = "+" . $this->input->post('phone_code', TRUE);
                }
                $ins_arr = array('country_name' => $this->input->post('country_name', TRUE), 'country_code' => $this->input->post('country_code', TRUE),
                    'phone_code' => $phone_code);

                $this->obj_common->update(array('country_id' => $id), $ins_arr, 'fanuc_country');
                $this->session->set_flashdata('message', 'Country Updated successfully');
                redirect(base_url() . 'country');
            }
        }


        $this->load->view('edit_country', $data);
    }

    public function delete_country($id) {
        $this->obj_common->delete(array('country_id' => $id), 'fanuc_country');
        $this->session->set_flashdata('message', 'Country Deleted successfully');
        redirect(base_url() . 'country');
    }

}
