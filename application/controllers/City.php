<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class City extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
        if (empty($this->session->userdata("ADMIN_ID"))) {
            redirect(base_url());
        }
    }

    public function index() {
        $data = array();
        $this->load->view('city_list', $data);
    }

    public function add_city() {
        $data['country'] = $this->obj_common->get_data(array('country_status' => '1'), 'fanuc_country');
        $this->form_validation->set_rules('state_id', 'State', 'trim|required');
        $this->form_validation->set_rules('city_name', 'City', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $city_name = $this->obj_common->get_data(array('city_name' => $this->input->post('city_name', TRUE),
                'state_id' => $this->input->post('state_id', TRUE)), 'fanuc_city');
            if (!empty($city_name)) {
                $data['error_message'] = 'City already exists';
            } else {
                $city_data = end($this->obj_common->get_data_orderby(array(),'fanuc_city','city_id'));
                $city_id = $city_data['city_id'] + 1;
                $ins_arr = array('city_name' => $this->input->post('city_name', TRUE),
                    'state_id' => $this->input->post('state_id', TRUE),'city_id' => $city_id);
                $this->obj_common->insert($ins_arr, 'fanuc_city');
                $this->session->set_flashdata('message', 'City Added successfully');
                redirect(base_url() . 'city');
            }
        }
        $data['state'] = $this->obj_common->get_data(array(), 'fanuc_state');
        $this->load->view('add_city', $data);
    }

    public function edit_city($id) {
        $data['country'] = $this->obj_common->get_data(array('country_status' => '1'), 'fanuc_country');
        $data['city'] = end($this->obj_common->get_data(array('city_id' => $id), 'fanuc_city'));
        //echo "<pre>";print_r($data);exit;
        $this->form_validation->set_rules('state_id', 'State', 'trim|required');
        $this->form_validation->set_rules('city_name', 'City', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $city_name = $this->obj_common->get_data(array('city_name' => $this->input->post('city_name', TRUE),
                'state_id' => $this->input->post('state_id', TRUE), 'city_id !=' => $id), 'fanuc_city');

            if (!empty($city_name)) {
                $data['error_message'] = 'City already exists';
            } else {
                $ins_arr = array('city_name' => $this->input->post('city_name', TRUE),
                    'state_id' => $this->input->post('state_id', TRUE));
                $this->obj_common->update(array('city_id' => $id), $ins_arr, 'fanuc_city');
                $this->session->set_flashdata('message', 'City Updated successfully');
                redirect(base_url() . 'city');
            }
        }
        $data['state'] = $this->obj_common->get_data(array(), 'fanuc_state');
        $this->load->view('edit_city', $data);
    }

    public function delete_city($id) {
        $this->obj_common->delete(array('city_id' => $id), 'fanuc_city');
        $this->session->set_flashdata('message', 'City Deleted successfully');
        redirect(base_url() . 'city');
    }

    public function get_city_list() {
        $result = $this->obj_common->get_city();
        $row_count = $this->obj_common->get_data_count(array('city_status' => '1'),'fanuc_city');
        
       
        $i = $_POST['start']; 
        foreach ($result as $key => $val) {
          $i++;  
            $city_data[$key][] = $i;
            $city_data[$key][] = $val['city_name'];
            $city_data[$key][] = $val['state_name'];
            $city_data[$key][] = '<a>Edit</a>';
            $city_data[$key][] = '<a>Delete</a>';
        }

        $output = array(
            "recordsTotal" => $row_count,
            "data" => $city_data
        );
        echo json_encode($output);
        
    }

    public function get_state_list() {
        $state = array();
        $condition = array('country_id' => $_REQUEST['country_id']);
        $state = $this->obj_common->get_data($condition, 'fanuc_state');
        echo json_encode($state);
    }

}
