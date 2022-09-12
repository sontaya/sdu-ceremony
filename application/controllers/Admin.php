<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends MY_Controller
{
	function __construct()
	{
        parent::__construct();
        $this->load->model('Ceremony_model');
        // $this->load->model('Cds_model');

        // if(! $this->session->userdata('uid'))
        // {
        //   $allowed = array('login','meeting_documents');
        //   if(! in_array($this->router->fetch_method(), $allowed))
        //   {
        //     redirect('auth/index');
        //   }
        // }


	}

    function index(){
        redirect('admin/practice_dashboard');
    }

	function dashboard(){
        $data['title'] = "Admin";
        $data['subheader_title'] = "ยินดีต้อนรับ Admin";
        $data['subheader_desc'] = "";
        $data['active_tab'] = '';
        $data["jsSrc"] = array(
                      'assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
                      'assets/js/custom.js',
                      'assets/js/dashboard.js'
                     );

        $this->data = $data;
		// $this->content = 'metronic_templates/_content';
		$this->content = 'dashboard';
		$this->metronic_admin_render();
    }

	function practice_dashboard(){
        $data['title'] = "Admin";
        $data['subheader_title'] = "ยินดีต้อนรับ Admin";
        $data['subheader_desc'] = "";
        $data['active_tab'] = '';
        $data["jsSrc"] = array(
                      'assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
                      'assets/js/custom.js',
                      'assets/js/practice-dashboard.js'
                     );

        $this->data = $data;
		// $this->content = 'metronic_templates/_content';
		$this->content = 'admin/practice-dashboard';
		$this->metronic_admin_render();
    }


    public function report_summary(){

        $query_summary = $this->db->query("SELECT COUNT(*) AS COUNT_ALL
                                                    ,SUM(CASE WHEN ((GRAD_CONFIRM_STATUS = 'Y' OR GRAD_CONFIRM_STATUS IS NULL) AND (STD_CONFIRM_STATUS IS NULL)) THEN 1 ELSE 0 END) AS COUNT_TENTATIVE
                                                    ,SUM(CASE WHEN STD_CONFIRM_STATUS = 'Y' THEN 1 ELSE 0 END) AS COUNT_OK
                                                    ,SUM(CASE WHEN STD_CONFIRM_STATUS = 'N' THEN 1 ELSE 0 END) AS COUNT_NO
                                                FROM GRADUATE_CEREMONY65") ;
        $res = $query_summary->result_array();

        header('Content-Type: application/json');
        echo json_encode($res);

    }

    public function report_practice_summary(){

        $query_summary = $this->db->query("SELECT COUNT(*) AS COUNT_ALL
                                                    , SUM(CASE WHEN CL.CREATED_DATE IS NOT NULL THEN 1 ELSE 0 END) AS COUNT_PRINT
                                                    , SUM(CASE WHEN CL.CREATED_DATE IS NULL THEN 1 ELSE 0 END) AS COUNT_NO
                                                FROM QS_USER.GRADUATE_PRACTICE_6062 GP
                                                    LEFT JOIN QS_USER.VW_PRACTICE_PRINT_LATEST PL ON GP.STD_CODE = PL.STD_CODE
                                                    LEFT JOIN QS_USER.GRADUATE_CEREMONY_LOG  CL ON CL.ID = PL.PRINT_LOG_ID
                                                WHERE GP.PRE_REMARK	IS NULL") ;
        $res = $query_summary->result_array();

        header('Content-Type: application/json');
        echo json_encode($res);

    }
    public function report_list(){

        $query_summary = $this->db->query("SELECT STD_ORDER,STD_CODE,
                                                    PREFIX_NAME_TH||FIRST_NAME_TH||' '||LAST_NAME_TH AS FULLNAME
                                                    ,DEGREENAMETH, GRAD_CONFIRM_STATUS, STD_CONFIRM_STATUS, STD_CONFIRM_DATE
                                                FROM GRADUATE_CEREMONY65") ;
        $res = $query_summary->result_array();

        header('Content-Type: application/json');
        echo json_encode($res);

    }
    public function report_practice_list(){

        $query_summary = $this->db->query("SELECT GP.RECORD_NO,GP.STD_CODE,
                                                        GP.PREFIX_NAME_TH||GP.FIRST_NAME_TH||' '||GP.LAST_NAME_TH AS FULLNAME
                                                        ,GP.DEGREENAMETH, GP.GRADUATE_STATUS, GP.PRE_DATE, CL.CREATED_DATE AS LATEST_PRINT_DATE
                                                        ,TO_CHAR(CL.CREATED_DATE, 'dd/mm/yyyy hh24:mi', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') AS LATEST_PRINT_DATE_DESC
                                                    FROM QS_USER.GRADUATE_PRACTICE_6062 GP
                                                        LEFT JOIN QS_USER.VW_PRACTICE_PRINT_LATEST PL ON GP.STD_CODE = PL.STD_CODE
                                                        LEFT JOIN QS_USER.GRADUATE_CEREMONY_LOG  CL ON CL.ID = PL.PRINT_LOG_ID
                                                        ORDER BY CL.CREATED_DATE DESC NULLS LAST, GP.RECORD_NO") ;
        $res = $query_summary->result_array();

        header('Content-Type: application/json');
        echo json_encode($res);

    }

    public function xlsx_download($slot_round){


        $conditions = array(
            "SLOT_ROUND" => $slot_round
          );


        $responses = $this->Register_model->list(array('conditions'=> $conditions));

        // header('Content-Type: application/json');
        // echo json_encode($responses);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        // $sheet->getStyle('A:A')
        //       ->getNumberFormat()
        //       ->applyFromArray(['formatCode' => PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_GENERAL]);



        $sheet->getStyle('A:A')
              ->getNumberFormat()
              ->setFormatCode('#');

        // $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);

        $sheet->getStyle('B:B')
        ->getNumberFormat()
        ->setFormatCode('0000000000000');
        $sheet->getStyle('L:L')
        ->getNumberFormat()
        ->setFormatCode('0000000000000');

        $sheet->setTitle('MyTitle');

        $rowCaption = [
                          'รหัสนักศึกษา','หมายเลขบัตรประชาชน','คำนำหน้า','ชื่อ','นามสกุล','คณะ', 'หลักสุตร', 'สาขา','ศูนย์การศึกษา',
                          'วันที่','เวลา','หมายเลขโทรศัพท์','บุคคลที่สามารถติดต่อได้กรณีฉุกเฉิน','เบอร์ติดต่อบุคคลที่ติดต่อได้กรณีฉุกเฉิน'
                        ];

        $sheet->fromArray($rowCaption, NULL, 'A1');

        $rowCount = 2;
        foreach ($responses as $res) {


          $sheet->setCellVAlue('A'.$rowCount, $res['STD_CODE']);
          $sheet->setCellVAlue('B'.$rowCount, $res['ID_CARD_CODE']);
          $sheet->setCellVAlue('C'.$rowCount, $res['PREFIX_NAME_TH']);
          $sheet->setCellVAlue('D'.$rowCount, $res['FIRST_NAME_TH']);
          $sheet->setCellVAlue('E'.$rowCount, $res['LAST_NAME_TH']);
          $sheet->setCellVAlue('F'.$rowCount, $res['FACULTYNAMETH']);
          $sheet->setCellVAlue('G'.$rowCount, $res['DEGREENAMETH']);
          $sheet->setCellVAlue('H'.$rowCount, $res['MAJORNAMETH']);
          $sheet->setCellVAlue('I'.$rowCount, $res['SITENAMETH']);
          $sheet->setCellVAlue('J'.$rowCount, $res['SLOT_DATE_TH']);
          $sheet->setCellVAlue('K'.$rowCount, $res['SLOT_TIME']);
          $sheet->setCellVAlue('L'.$rowCount, $res['STD_PHONE']);
          $sheet->setCellVAlue('M'.$rowCount, $res['EMERGENCY_PERSON']);
          $sheet->setCellVAlue('N'.$rowCount, $res['EMERGENCY_PHONE']);

          $rowCount++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'vaccine-report-'.time();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file

    }




}
