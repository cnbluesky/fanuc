<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class State extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
        if (empty($this->session->userdata("ADMIN_ID"))) {
            redirect(base_url());
        }
    }

    public function index() {
        $data['state'] = $this->obj_common->get_states();
        //echo $this->db->last_query();exit;
        $this->load->view('state_list', $data);
    }

    public function add_state() {
        $condition = array('country_status' => '1');
        $data['country'] = $this->obj_common->get_data($condition, 'fanuc_country');
        $this->form_validation->set_rules('country_id', 'Country', 'trim|required');
        $this->form_validation->set_rules('state_name', 'State Name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $state_name = $this->obj_common->get_data(array('state_name' => $this->input->post('state_name', TRUE)), 'fanuc_state');
            if (!empty($state_name)) {
                $data['error_message'] = 'State name already exists';
            } else {
                $state_data = end($this->obj_common->get_data_orderby(array(),'fanuc_state','state_id'));
                $state_id = $state_data['state_id'] + 1;
                $ins_arr = array('state_id' => $state_id,'country_id' => $this->input->post('country_id', TRUE), 'state_name' => $this->input->post('state_name', TRUE));
                $this->obj_common->insert($ins_arr, 'fanuc_state');
                $this->session->set_flashdata('message', 'State Added successfully');
                redirect(base_url() . 'state');
            }
        }
        $this->load->view('add_state', $data);
    }

    public function edit_state($id) {
        $condition = array();
        $data['country'] = $this->obj_common->get_data($condition, 'fanuc_country');
        $data['state'] = end($this->obj_common->get_data(array('state_id' => $id), 'fanuc_state'));
        
        $this->form_validation->set_rules('country_id', 'Country', 'trim|required');
        $this->form_validation->set_rules('state_name', 'State Name', 'trim|required');
        
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $state_name = $this->obj_common->get_data(array('state_name' => $this->input->post('state_name', TRUE),'state_id !=' => $id ), 'fanuc_state');
            
            if (!empty($state_name)) {
                $data['error_message'] = 'State name already exists';
            } else {
                
                $ins_arr = array('country_id' => $this->input->post('country_id', TRUE), 'state_name' => $this->input->post('state_name', TRUE));
                $this->obj_common->update(array('state_id' => $id),$ins_arr, 'fanuc_state');
                $this->session->set_flashdata('message', 'State Updated successfully');
                redirect(base_url() . 'state');
            }
        }
        $this->load->view('edit_state', $data);
    }
    
    public function delete_state($id)
    {
        $this->obj_common->delete(array('state_id' => $id), 'fanuc_state');
        $this->session->set_flashdata('message', 'State Deleted successfully');
        redirect(base_url() . 'state');
    }

}
