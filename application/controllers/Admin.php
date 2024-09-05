<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends MY_Controller
{
	function __construct()
	{
        parent::__construct();
        $this->load->model('Commencement_model');
        $this->load->model('Commencementlog_model');
        $this->load->model('Ceremony_model');
        $this->load->model('Auth_model');
        $this->load->model('Practice_model');
        // $this->load->model('Cds_model');

        if( !$this->session->userdata('auth_admin_session'))
        {
          $allowed = array('do_login','login','index','debug','practice_encrypt_target');
          if(! in_array($this->router->fetch_method(), $allowed))
          {
            redirect('admin/login');
          }
        }


	}

    function index(){
        redirect('admin/dashboard');
    }

    public function login(){
        $this->load->view('login-admin');
    }

    function do_login(){
        $client_ip = get_client_ip();
        $username = $this->input->post('login_name');
        $passwd = $this->input->post('login_password');
        $response = $this->Auth_model->login($username,$passwd);

        if($response["uid"]!=""){
            $admin_data = array(
                'AUTH_HRCODE' => $response["hrcode"]
            );

            $check_admin_response = $this->Auth_model->admin_list(array('conditions'=>$admin_data));
            if($check_admin_response == false){
                $result_do_login = false;
            }else{
                $result_do_login = array(
                    'uid' => $response["uid"],
                    'hrcode' => $response["hrcode"],
                    'displayname' => $response["displayname"],
                    'app_role' => $check_admin_response[0]["APP_ROLE"]
                  );
                  $this->session->set_userdata('auth_admin_session',$result_do_login);
                // $auth_data = $check_admin_response[0];
            }
        }else{
            $result_do_login = false;
        }





        echo json_encode($result_do_login);
    }


    public function logout()
    {
      $this->session->sess_destroy();
      redirect('admin/login');
    }

	function dashboard(){
        $data['title'] = "Admin";
        $data['subheader_title'] = "ยินดีต้อนรับ ".$this->session->userdata('auth_admin_session')['displayname'];
        $data['subheader_desc'] = "";
        $data['active_tab'] = 'dashboard';
        $data["jsSrc"] = array(
                      'assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
                      'assets/js/custom.js',
                      'assets/vendors/magnific-popup/dist/jquery.magnific-popup.min.js',
                    'assets/js/request-dashboard.js'
                     );
        $data["cssSrc"] = array(
                      'assets/vendors/magnific-popup/dist/magnific-popup.css'
                     );

        $this->data = $data;
		// $this->content = 'metronic_templates/_content';
		$this->content = 'admin/request-dashboard';
		$this->metronic_admin_render();
    }


    public function report_list(){

        $query_summary = $this->db->query("SELECT GC.STD_ORDER, GC.STD_CODE, GP.GRAD_ORDER
                                                    ,GC.PREFIX_NAME_TH||GC.FIRST_NAME_TH||' '||GC.LAST_NAME_TH AS FULLNAME
                                                    ,GC.DEGREENAMETH, GC.ID_PHOTO, GC.UPLOAD_STATUS
                                                    ,TO_CHAR(GC.UPLOAD_DATE, 'dd/mm/yyyy HH24:MI', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') AS UPLOAD_DATE_TH
                                                    ,TO_CHAR(GC.LAST_MODIFY_DATE, 'dd/mm/yyyy HH24:MI', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') AS LAST_MODIFY_DATE_TH
                                                    ,GP.REMARK_GET
                                                    ,CASE
                                                        WHEN GP.REMARK_GET = '1' THEN 'ปกติ'
                                                        WHEN GP.REMARK_GET = '2' THEN 'เข้ารับ ไม่ชำระเงินรายตัว'
                                                        WHEN GP.REMARK_GET = '3' THEN 'ไม่เข้ารับ'
                                                        WHEN GP.REMARK_GET = '4' THEN 'ไม่เข้ารับ ไม่ชำระเงินค่ารายงานตัว'
                                                        WHEN GP.REMARK_GET = '5' THEN 'ไม่รายงานตัว'
                                                        ELSE ''
                                                    END AS REMARK_GET_DESC
                                                FROM GRADUATE_COMMENCEMENT65 GC
                                                    INNER JOIN GRADUATE_PRACTICE_65 GP ON GC.STD_CODE = GP.STD_CODE
                                                ORDER BY GP.GRAD_ORDER
                                                ");
        $res = $query_summary->result_array();

        header('Content-Type: application/json');
        echo json_encode($res);

    }

    public function view(){

        $std_code = $this->input->post('user_id');
        $conditions = array(
            'STD_CODE' => $std_code
        );
        $practice_result = $this->Practice_model->get_practice_info(array('conditions'=>$conditions))[0];

        $data['practice'] = $practice_result;

        header('Content-Type: application/json');
        echo json_encode($practice_result);

    }

    public function report_summary(){

        $query_summary = $this->db->query("SELECT COUNT(*) AS COUNT_ALL
                                                        ,SUM(CASE WHEN UPLOAD_STATUS = 'approve' THEN 1 ELSE 0 END) AS COUNT_APPROVE
                                                        ,SUM(CASE WHEN UPLOAD_STATUS = 'pending' THEN 1 ELSE 0 END) AS COUNT_PENDING
                                                        ,SUM(CASE WHEN UPLOAD_STATUS = 'reject' THEN 1 ELSE 0 END) AS COUNT_REJECT
                                                        ,SUM(CASE WHEN UPLOAD_STATUS = '' OR UPLOAD_STATUS IS NULL THEN 1 ELSE 0 END) AS COUNT_NULL
                                                    FROM GRADUATE_COMMENCEMENT65") ;
        $res = $query_summary->result_array();

        header('Content-Type: application/json');
        echo json_encode($res);

    }

    public function report_gradstatus_summary(){

        $query_summary = $this->db->query("SELECT COUNT(*) AS COUNT_ALL
                                                    ,SUM(CASE WHEN REMARK_GET = '1' THEN 1 ELSE 0 END) AS COUNT_1
                                                    ,SUM(CASE WHEN REMARK_GET = '2' THEN 1 ELSE 0 END) AS COUNT_2
                                                    ,SUM(CASE WHEN REMARK_GET = '3' THEN 1 ELSE 0 END) AS COUNT_3
                                                    ,SUM(CASE WHEN REMARK_GET = '4' THEN 1 ELSE 0 END) AS COUNT_4
                                                    ,SUM(CASE WHEN REMARK_GET = '5' THEN 1 ELSE 0 END) AS COUNT_5
                                                FROM GRADUATE_PRACTICE_65") ;
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

    public function reject() {
        $client_ip = get_client_ip();
        $std_code = $this->input->post('user_id');
        $reason = $this->input->post('reason');


        $data = array(
            'STD_CODE' => $std_code,
            'REJECT_REASON' => $reason,
            'UPLOAD_STATUS' => 'reject',
            'LAST_MODIFY_BY_IP' => $client_ip,
            'LAST_MODIFY_BY' => $this->session->userdata('auth_admin_session')['displayname'],
            'LAST_MODIFY_DATE' => date('Y-m-d H:i:s')
        );

        $save_result = $this->Commencement_model->reject($data);


        // --- LOG
        $log_data = array(
            'ACTION_TYPE' => "REJECT",
            'MESSAGE' => json_encode($data),
            'CREATED_BY' => $this->session->userdata('auth_admin_session')['displayname'],
            'CREATED_BY_IP' => $client_ip
        );
        $log_result = $this->Commencementlog_model->save($log_data);



        echo json_encode(array('status' => $save_result));
        // echo json_encode($practice_result);
    }

    public function remark() {
        $client_ip = get_client_ip();
        $std_code = $this->input->post('user_id');
        $remarkGet = $this->input->post('remarkGet');


        $data = array(
            'STD_CODE' => $std_code,
            'REMARK_GET' => $remarkGet,
            'LAST_MODIFY_BY_IP' => $client_ip,
            'LAST_MODIFY_BY' => $this->session->userdata('auth_admin_session')['displayname'],
            'LAST_MODIFY_DATE' => date('Y-m-d H:i:s')
        );

        $save_result = $this->Commencement_model->remark($data);


        // --- LOG
        $log_data = array(
            'ACTION_TYPE' => "REMARK",
            'MESSAGE' => json_encode($data),
            'CREATED_BY' => $this->session->userdata('auth_admin_session')['displayname'],
            'CREATED_BY_IP' => $client_ip
        );
        $log_result = $this->Commencementlog_model->save($log_data);



        echo json_encode(array('status' => $save_result));
        // echo json_encode($practice_result);
    }

    public function approve($std_code) {
        $client_ip = get_client_ip();

        $data = array(
            'STD_CODE' => $std_code,
            'UPLOAD_STATUS' => 'approve',
            'REJECT_REASON' => '',
            'LAST_MODIFY_BY_IP' => $client_ip,
            'LAST_MODIFY_BY' => $this->session->userdata('auth_admin_session')['displayname'],
            'LAST_MODIFY_DATE' => date('Y-m-d H:i:s')
        );

        $save_result = $this->Commencement_model->approve($data);


        // --- LOG
        $log_data = array(
            'ACTION_TYPE' => "APPROVE",
            'MESSAGE' => json_encode($data),
            'CREATED_BY' => $this->session->userdata('auth_admin_session')['displayname'],
            'CREATED_BY_IP' => $client_ip
        );
        $log_result = $this->Commencementlog_model->save($log_data);

        echo json_encode(array('status' => $save_result));
        // echo json_encode($practice_result);
    }

    public function scan(){
        $data['title'] = "QR Scan";
        $data['subheader_title'] = "ยินดีต้อนรับ ".$this->session->userdata('auth_admin_session')['displayname'];
        $data['subheader_desc'] = "";
        $data['active_tab'] = 'dashboard';
        $data["jsSrc"] = array(
                      'assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
                      'assets/js/custom.js',
                      'assets/vendors/magnific-popup/dist/jquery.magnific-popup.min.js',
                      'assets/js/jsQR.js',
                      'assets/js/admin-qrcheck.js'
                     );
        $data["cssSrc"] = array(
                      'assets/vendors/magnific-popup/dist/magnific-popup.css',
                      'assets/css/admin-qrcheck.css'
                     );

        $this->data = $data;
		// $this->content = 'metronic_templates/_content';
		$this->content = 'admin/qr-check';
		$this->metronic_admin_render();
    }

    public function do_scan() {
        $client_ip = get_client_ip();
        $std_code = decrypt_data($this->input->post('enc_target'));

        $data = array(
            'EVENT_ID' => 'PRACTICE67_1',
            'STD_CODE' => $std_code,
            'CREATED_BY' => $this->session->userdata('auth_admin_session')['displayname'],
            'CREATED_BY_IP' => $client_ip
        );

        $save_result = $this->Commencement_model->timestamp_save($data);

        $info_conditions = array(
            'STD_CODE' => $std_code
        );

        $info_result = $this->Commencement_model->list(array('conditions'=>$info_conditions))[0];

        // // --- LOG
        // $log_data = array(
        //     'ACTION_TYPE' => "SCAN",
        //     'MESSAGE' => json_encode($data),
        //     'CREATED_BY' => $this->session->userdata('auth_admin_session')['displayname'],
        //     'CREATED_BY_IP' => $client_ip
        // );
        // $log_result = $this->Commencementlog_model->save($log_data);

        // echo json_encode(array('status' => $save_result,'info'=>array($info_result)));
        echo json_encode($info_result);
    }

    public function practice_encrypt_target($std_code){
        $result = array(
            'std_code'=>$std_code,
            'encrypt' => encrypt_data($std_code)
        );
        echo json_encode($result);
    }


    public function graduate_timestamp(){

        $query = $this->db->query("SELECT GP.STD_CODE, GP.GRAD_ORDER
                                                        ,GP.PREFIX_NAME_TH||GP.FIRST_NAME_TH||' '||GP.LAST_NAME_TH AS FULLNAME
                                                        ,GP.DEGREENAMETH
                                                        ,GT.CREATED_DATE ,TO_CHAR(GT.CREATED_DATE, 'dd/mm/yyyy HH24:MI', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') AS CREATED_DATE_TH
                                                        ,GT.EVENT_ID, GT.CREATED_BY
                                                    FROM GRADUATE_PRACTICE_65 GP
                                                        INNER JOIN GRADUATE_TIMESTAMP GT ON GP.STD_CODE = GT.STD_CODE
                                                    ORDER BY GT.CREATED_DATE DESC
                                                ");
        $res = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode($res);

    }

    public function export_graduate_timestamp(){

        $query = $this->db->query("SELECT GP.STD_CODE, GP.GRAD_ORDER
                                                        ,GP.PREFIX_NAME_TH||GP.FIRST_NAME_TH||' '||GP.LAST_NAME_TH AS FULLNAME
                                                        ,GP.DEGREENAMETH
                                                        ,GT.CREATED_DATE ,TO_CHAR(GT.CREATED_DATE, 'dd/mm/yyyy HH24:MI', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') AS CREATED_DATE_TH
                                                        ,GT.EVENT_ID, GT.CREATED_BY
                                                    FROM GRADUATE_PRACTICE_65 GP
                                                        INNER JOIN GRADUATE_TIMESTAMP GT ON GP.STD_CODE = GT.STD_CODE
                                                    ORDER BY GT.CREATED_DATE DESC
                                                ");
        $responses = $query->result_array();

        // header('Content-Type: application/json');
        // echo json_encode($res);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $sheet->getStyle('A:A')
              ->getNumberFormat()
              ->setFormatCode('#');

        // $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);


        $sheet->getStyle('A:A')
        ->getNumberFormat()
        ->setFormatCode('0000');


        $sheet->setTitle('ข้อมูลการลงเวลา');

        $rowCaption = [
                          'ลำดับ', 'รหัสนักศึกษา','ชื่อ-นามสกุล','หลักสุตร', 'วันที่ลงเวลา','ผู้บันทึกเวลา'
                        ];

        $sheet->fromArray($rowCaption, NULL, 'A1');

        $rowCount = 2;
        foreach ($responses as $res) {


          $sheet->setCellVAlue('A'.$rowCount, $res['GRAD_ORDER']);
          $sheet->setCellVAlue('B'.$rowCount, $res['STD_CODE']);
          $sheet->setCellVAlue('C'.$rowCount, $res['FULLNAME']);
          $sheet->setCellVAlue('D'.$rowCount, $res['DEGREENAMETH']);
          $sheet->setCellVAlue('E'.$rowCount, $res['CREATED_DATE_TH']);
          $sheet->setCellVAlue('F'.$rowCount, $res['CREATED_BY']);

          $rowCount++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'qrlist-report-'.time();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file



    }

	function scan_list(){
        $data['title'] = "Admin";
        $data['subheader_title'] = "ยินดีต้อนรับ ".$this->session->userdata('auth_admin_session')['displayname'];
        $data['subheader_desc'] = "";
        $data['active_tab'] = 'scan';
        $data["jsSrc"] = array(
                      'assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
                      'assets/js/custom.js',
                      'assets/vendors/magnific-popup/dist/jquery.magnific-popup.min.js',
                    'assets/js/qr-list.js'
                     );
        $data["cssSrc"] = array(
                      'assets/vendors/magnific-popup/dist/magnific-popup.css'
                     );

        $this->data = $data;
		// $this->content = 'metronic_templates/_content';
		$this->content = 'admin/qr-list';
		$this->metronic_admin_render();
    }



    public function debug(){
        // $data = '543161321057';
        // $encoded_data = encrypt_data($data);

        // $result = array(
        //     'data' => $data,
        //     'encode' => $encoded_data,
        //     'decode' => decrypt_data($encoded_data)
        // );



        $client_ip = get_client_ip();
        $std_code = '543161321057';

        $data = array(
            'EVENT_ID' => 'PRACTICE67_1',
            'STD_CODE' => $std_code,
            'CREATED_BY' => $this->session->userdata('auth_admin_session')['displayname'],
            'CREATED_BY_IP' => $client_ip
        );

        $save_result = $this->Commencement_model->timestamp_save($data);

        $info_conditions = array(
            'STD_CODE' => $std_code
        );

        $info_result = $this->Commencement_model->list(array('conditions'=>$info_conditions))[0];

        header('Content-Type: application/json');
        echo json_encode($info_result);
    }

}
