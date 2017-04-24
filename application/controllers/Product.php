<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model', 'obj_common', TRUE);
        if(empty($this->session->userdata("ADMIN_ID")))
        {
            redirect(base_url());
        }
        require_once(FCPATH . 'phpexcel\Classes\PHPExcel.php');
    }

    public function index() {
        $condition = array();
        $data['product'] = $this->obj_common->product_data($condition);
        $this->load->view('product_registration',$data);
        //echo "<pre>";print_r($data);exit;
    }

    public function product_registration_details($id) {
        $condition = array('product_registration_id' => $id);
        $data['product'] = end($this->obj_common->product_data($condition));
       // echo "<pre>";print_r($data);exit;
        $this->load->view('product_registration_details',$data);
        
        
    }
    
    
    public function export_excel() {
        
        $condition = array();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 2;
        $data = $this->obj_common->product_data($condition);
        //echo "<pre>";print_r($data);exit;
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'SL No');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Product Registration ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'MTB Maker');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Machine Model');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Machine Serial Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'System Model');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'System Serial Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Request Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Install ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'User Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Product Category');
        $i = 1;
        foreach ($data as $val) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $val['product_registration_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $val['mtb_maker']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $val['machine_model']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $val['machine_serial_number']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $val['system_model']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $val['system_serial_number']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, date("d-m-Y", strtotime($val['created_date'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $val['install_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $val['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $val['product_category_name']);
            $rowCount++;
            $i++;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="product.xlsx"');
        $objWriter->save('php://output');
        
    }

}
