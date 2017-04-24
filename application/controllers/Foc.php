<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Foc extends CI_Controller {

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
        $data['foc'] = $this->obj_common->foc_data($condition);
        $this->load->view('foc_request',$data);
    }
    
    public function foc_request_detail($id) {
        $condition = array('foc_request_id' => $id);
        $data['foc'] = end($this->obj_common->foc_data($condition));
        //echo "<pre>";print_r($data);exit;
        $this->load->view('foc_request_detail',$data);
        
    }
    
    
    public function export_excel() {
        
        $condition = array();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 2;
        $data = $this->obj_common->foc_data($condition);
        //echo "<pre>";print_r($data);exit;
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'SL No');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Category');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'User Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'MTB Maker');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Machine Model');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Machine Serial Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'System Model');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'System Serial Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Created Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', '');
        
        $i = 1;
        foreach ($data as $val) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $val['product_category_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $val['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $val['mtb_maker']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $val['machine_model']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $val['machine_serial_number']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $val['system_model']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $val['system_serial_number']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, date("d-m-Y", strtotime($val['created_date'])));
            
            $rowCount++;
            $i++;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="foc.xlsx"');
        $objWriter->save('php://output');
        
    }
    
    

}
