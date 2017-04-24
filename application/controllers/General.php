<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {

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
        $data['enquiry'] = $this->obj_common->enquiry_data($condition);
        $this->load->view('general_enquiry', $data);
    }

    public function enquiry_details($id) {
        $condition = array('enquiry_id' => $id);
        $data['enquiry'] = end($this->obj_common->enquiry_data($condition));
        //echo "<pre>";print_r($data);exit;
        $this->load->view('general_enquiry_details', $data);
    }

    public function export_excel() {
        
        $condition = array();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 2;
        $data = $this->obj_common->enquiry_data($condition);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'SL No');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Enquiry ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'User Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Enquiry Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Enquiry Details');
        $i = 1;
        foreach ($data as $val) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $val['enquiry_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $val['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, date("d-m-Y", strtotime($val['created_date'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $val['enquiry_details']);
            $rowCount++;
            $i++;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="enquiry.xlsx"');
        $objWriter->save('php://output');
        
    }

}
