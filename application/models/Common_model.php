<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_data($condition, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    function get_data_count($condition, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }
    
    function get_data_orderby($condition, $table,$order_by) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->limit('1');
        $this->db->order_by($order_by, 'desc');
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function update($condition, $data, $table) {
        $this->db->where($condition);
        $this->db->update($table, $data);
    }

    function insert($data, $table) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function delete($condition, $table) {
        $this->db->where($condition);
        $this->db->delete($table);
    }

    function get_data_pagination($condition, $table, $limit, $page) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($condition);
        $this->db->order_by('created_date', 'desc');
        $offset = $limit * $page - $limit;
        if (!empty($limit) && $page == 0) {
            $this->db->limit($limit);
        }
        if (!empty($limit) && !empty($page)) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function get_product_categories($condition, $limit, $page) {

        $this->db->select('COUNT(p.product_category_id) as count,p.product_category_name,p.product_category_id');
        $this->db->from('fanuc_product_category p');
        $this->db->join('fanuc_product_registration pd', 'pd.product_category_id = p.product_category_id');
        $this->db->where($condition);
        $this->db->group_by('p.product_category_name,p.product_category_id');
        $offset = $limit * $page - $limit;
        if (!empty($limit) && $page == 0) {
            $this->db->limit($limit);
        }
        if (!empty($limit) && !empty($page)) {

            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function get_product_categories_count($condition) {

        $this->db->select('COUNT(p.product_category_id) as count,p.product_category_name,p.product_category_id');
        $this->db->from('fanuc_product_category p');
        $this->db->join('fanuc_product_registration pd', 'pd.product_category_id = p.product_category_id');
        $this->db->where($condition);
        $this->db->group_by('p.product_category_name,p.product_category_id');
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    function get_service_date($condition, $limit, $page) {
        $this->db->select('CAST(created_date as date) as date ,count(CAST(created_date as date)) as count');
        $this->db->from('fanuc_service_request');
        $this->db->where($condition);
        $this->db->order_by('CAST(created_date as date)', 'desc');
        $this->db->group_by('CAST(created_date as date)');

        $offset = $limit * $page - $limit;
        if (!empty($limit) && $page == 0) {
            $this->db->limit($limit);
        }
        if (!empty($limit) && !empty($page)) {

            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function get_service_count($condition) {
        $this->db->select('CAST(created_date as date) as date');
        $this->db->from('fanuc_service_request');
        $this->db->where($condition);
        $this->db->group_by('CAST(created_date as date)');
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    function get_service_date_count($condition) {
        $this->db->select('CAST(created_date as date) as date');
        $this->db->from('fanuc_service_request');
        $this->db->where($condition);
        $this->db->group_by('CAST(created_date as date)');
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    function get_service_by_date($condition, $limit, $page,$user_id) {
        $this->db->select('*');
        $this->db->from('fanuc_service_request');
        $this->db->where($condition);
        $this->db->where(array('user_id' => $user_id));
        $offset = $limit * $page - $limit;
        if (!empty($limit) && $page == 0) {
            $this->db->limit($limit);
        }
        if (!empty($limit) && !empty($page)) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function get_service_c($condition,$user_id) {
        $this->db->select('*');
        $this->db->from('fanuc_service_request');
        $this->db->where(array('user_id' => $user_id));
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    function get_service_by_date_status($condition) {
        $this->db->select('*');
        $this->db->from('fanuc_service_request');
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function product_data($condition) {
        $this->db->select('p.*,u.name,c.product_category_name');
        $this->db->from('fanuc_product_registration p');
        $this->db->join('fanuc_user u', 'u.user_id = p.user_id');
        $this->db->join('fanuc_product_category c', 'p.product_category_id = c.product_category_id');
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function service_data($condition) {
        $this->db->select('s.*,u.name,c.product_category_name');
        $this->db->from('fanuc_service_request s');
        $this->db->join('fanuc_user u', 'u.user_id = s.user_id');
        $this->db->join('fanuc_product_category c', 's.product_category_id = c.product_category_id','left');
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function foc_data($condition) {
        $this->db->select('f.*,u.name,c.product_category_name');
        $this->db->from('fanuc_foc_request f');
        $this->db->join('fanuc_user u', 'u.user_id = f.user_id');
        $this->db->join('fanuc_product_category c', 'f.product_category_id = c.product_category_id');
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function enquiry_data($condition) {
        $this->db->select('e.*,u.name');
        $this->db->from('fanuc_enquiry e');
        $this->db->join('fanuc_user u', 'u.user_id = e.user_id');
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function get_product_count($condition,$from_date,$to_date) {
        $this->db->select('*');
        $this->db->from('fanuc_product_registration');
        if (!empty($from_date) && !empty($to_date)) {
            $this->db->where("created_date BETWEEN '".$from_date."' AND '".$to_date."'");
        }
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }
    
    function get_my_product_count($condition) {
        $this->db->select('*');
        $this->db->from('fanuc_product_registration');
        
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    function get_install_id($condition, $table) {
        $install_id = array();
        $this->db->select('install_id');
        $this->db->from($table);
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->result_array();
        foreach ($result as $val) {
            $install_id[] = $val['install_id'];
        }
        return $install_id;
    }

    function search_data($data) {
        $this->db->select('COUNT(p.product_category_id) as count,p.product_category_name,p.product_category_id');
        $this->db->from('fanuc_product_category p');
        $this->db->join('fanuc_product_registration pd', 'pd.product_category_id = p.product_category_id');
        if (!empty($data['product_category_id'])) {
            $this->db->where(array('pd.product_category_id' => $data['product_category_id']));
        }
        $this->db->group_by('p.product_category_name,p.product_category_id');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function get_product_search($product_category_id, $table, $limit, $page, $from_date, $to_date, $user_id) {


        $this->db->select('*');
        $this->db->from($table);
        $this->db->where(array('user_id' => $user_id));
        $this->db->where(array('product_category_id' => $product_category_id));
        if (!empty($from_date) && !empty($to_date)) {
            $this->db->where("created_date BETWEEN '".$from_date."' AND '".$to_date."'");
        }
        $this->db->order_by('created_date', 'desc');
        $offset = $limit * $page - $limit;
        if (!empty($limit) && $page == 0) {
            $this->db->limit($limit);
        }
        if (!empty($limit) && !empty($page)) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function myaccount_data($condition) {
        $this->db->select('u.*,c.country_name,ci.city_name,s.state_name');
        $this->db->from('fanuc_user u');
        $this->db->join('fanuc_country c', 'c.country_id = u.country');
        $this->db->join('fanuc_city ci', 'ci.city_id = u.city');
        $this->db->join('fanuc_state s', 's.state_id = u.state');
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function get_states() {
        $this->db->select('s.*,c.country_name');
        $this->db->from('fanuc_state s');
        $this->db->join('fanuc_country c', 'c.country_id = s.country_id');
        $this->db->where_in('s.country_id', array('18','25','101','153','206'));
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function get_city() {
        $this->db->select('c.*,s.state_name');
        $this->db->from('fanuc_city c');
        $this->db->join('fanuc_state s', 'c.state_id = s.state_id');
        $this->db->where(array('c.city_status' => '1'));
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

}

?>
