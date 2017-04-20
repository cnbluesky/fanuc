<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
        if (empty($this->session->userdata("ADMIN_ID"))) {
            redirect(base_url());
        }
    }

    public function index() {
        $data['category'] = $this->obj_common->get_data(array(), 'fanuc_product_category');
        $this->load->view('category_list', $data);
    }

    public function add_category() {
        $this->form_validation->set_rules('product_category_name', 'Category Name', 'trim|required');
        $this->form_validation->set_rules('product_category_description', 'Description', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $category_name = $this->obj_common->get_data(array('product_category_name' =>
                $this->input->post('product_category_name', TRUE)), 'fanuc_product_category');
            if (!empty($category_name)) {
                $data['error_message'] = 'Category already exists';
            } else {
                $ins_arr = array('product_category_name' => $this->input->post('product_category_name', TRUE),
                    'product_category_description' => $this->input->post('product_category_description', TRUE));
                $this->obj_common->insert($ins_arr, 'fanuc_product_category');
                $this->session->set_flashdata('message', 'Category Added successfully');
                redirect(base_url() . 'category');
            }
        }
        $this->load->view('add_category', $data);
    }

    public function edit_category($id) {
        $data['category'] = end($this->obj_common->get_data(array('product_category_id' => $id), 'fanuc_product_category'));

        $this->form_validation->set_rules('product_category_name', 'Category Name', 'trim|required');
        $this->form_validation->set_rules('product_category_description', 'Description', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $category_name = $this->obj_common->get_data(array('product_category_name' =>
                $this->input->post('product_category_name', TRUE),'product_category_id != ' => $id), 'fanuc_product_category');
            if (!empty($category_name)) {
                $data['error_message'] = 'Category already exists';
            } else {
                $ins_arr = array('product_category_name' => $this->input->post('product_category_name', TRUE),
                    'product_category_description' => $this->input->post('product_category_description', TRUE));
                $this->obj_common->update(array('product_category_id' => $id),$ins_arr, 'fanuc_product_category');
                $this->session->set_flashdata('message', 'Category Updated successfully');
                redirect(base_url() . 'category');
            }
        }


        $this->load->view('edit_category', $data);
    }
    
    
    public function delete_category($id)
    {
        $this->obj_common->delete(array('product_category_id' => $id), 'fanuc_product_category');
        $this->session->set_flashdata('message', 'Category Deleted successfully');
        redirect(base_url() . 'category');
    }

}
