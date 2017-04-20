<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
        if (empty($this->session->userdata("ADMIN_ID"))) {
            redirect(base_url());
        }
        require_once(FCPATH . 'phpexcel\Classes\PHPExcel.php');
    }

    public function index() {
        $condition = array();
        $data['service'] = $this->obj_common->service_data($condition);
        //echo $this->db->last_query();exit;
        $this->load->view('service_request', $data);
    }

    public function service_request_detail($id) {
        $condition = array('service_request_id' => $id);
        $data['service'] = end($this->obj_common->service_data($condition));
        $this->load->view('service_request_detail',$data);
    }

    public function change_status() {
        
        $condition = array('service_request_id' => $_REQUEST['service_request_id']);
        $data = array('request_status' => $_REQUEST['request_status']);
        $this->obj_common->update($condition,$data,'fanuc_service_request');
        $json['status'] = '1';
        $json['message'] = 'Updated';
        echo json_encode($json);
    }
    
    
    public function export_excel() {
        
        $condition = array();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 2;
        $data = $this->obj_common->service_data($condition);
        //echo "<pre>";print_r($data);exit;
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'SL No');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Service Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'User Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Category Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Install ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Problem Details');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Request Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Request Date');
        
        $i = 1;
        foreach ($data as $val) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $val['service_type']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $val['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $val['product_category_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $val['install_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $val['problem_details']);
            if($val['request_status'] == '0')
            {
                $status = 'Open';
            }
            
            if($val['request_status'] == '1')
            {
                $status = 'Work In Progress';
            }
            
            if($val['request_status'] == '2')
            {
                $status = 'Closed';
            }
            
            
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $status);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, date("d-m-Y", strtotime($val['created_date'])));
            $rowCount++;
            $i++;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="service.xlsx"');
        $objWriter->save('php://output');
        
    }

}
