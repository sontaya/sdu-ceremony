<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends MY_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->model('Practice_model');
        $this->load->model('Ceremonylog_model');

        if(! $this->session->userdata('auth_session')['std_code'])
        {
          $allowed = array('debug');
          if(!in_array($this->router->fetch_method(), $allowed))
          {
            redirect('auth/index');
          }
        }

    }
    function index(){

        redirect('auth/logout');
    }


    function id($stdcode){


        if(ENVIRONMENT == "production"){
            $source_path = $_SERVER['DOCUMENT_ROOT']."ceremony/";
        }else{
            $source_path = $_SERVER['DOCUMENT_ROOT'];
        }

        $conditions = array(
            'STD_CODE' => $this->session->userdata('auth_session')['std_code']
        );


        $client_ip = get_client_ip();
        $log_data = array(
            'ACTION_TYPE' => "พิมพ์บัตรซ้อมย่อย",
            'MESSAGE' => json_encode($conditions),
            'CREATED_BY' => $this->session->userdata('auth_session')['std_code'],
            'CREATED_BY_IP' => $client_ip
        );
        $log_result = $this->Ceremonylog_model->save($log_data);


        $practice_result = $this->Practice_model->get_practice_info(array('conditions'=>$conditions))[0];

        if($practice_result['STD_CODE']<>null){

                $pdf = new Pdf('', '', 'A4', true, 'UTF-8', false);
                $pdf->SetTitle('บัตรซ้อมย่อย');

                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);

                $pdf->AddPage();

                $pdf->SetFont('helvetica', '', 10);

                // define barcode style
                $style = array(
                        'position' => '',
                        'align' => 'C',
                        'stretch' => false,
                        'fitwidth' => true,
                        'cellfitalign' => '',
                        'border' => false,
                        'hpadding' => 'auto',
                        'vpadding' => 'auto',
                        'fgcolor' => array(0,0,0),
                        'bgcolor' => false, //array(255,255,255),
                        'text' => true,
                        'font' => 'helvetica',
                        'fontsize' => 8,
                        'stretchtext' => 4
                );

                // PRINT VARIOUS 1D BARCODES

                // CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
                $pdf->SetXY(140, 3);
                $pdf->write1DBarcode($practice_result['STD_CODE'] , 'C39', '', '', '', 16, 0.4, $style, 'N');

                $pdf->Ln();

                $pdf->Ln();

                $pdf->SetFont('thsarabun', '', 16);
                $pdf->SetDisplayMode('real', 'default');
                // $pdf->SetXY(10, 20);
                $pdf->Image($source_path.'assets/images/sdu.jpg', 10, 20, 23, 30, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);

                // $pdf->SetXY(170, 20);
                $pdf->Image($source_path.'assets/images/photo-frame.jpg', 170, 20, 30, 40, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);

                $pdf->SetXY(35,28);
                $pdf->SetFont('thsarabun', '', 24);
                $pdf->Cell(0, 0, 'บัตรซ้อมย่อย', 0, 1, 'L', 0, '', 0);

                $pdf->SetXY(35,35);
                $pdf->Cell(0, 0, 'มหาวิทยาลัยสวนดุสิต', 0, 1, 'L', 0, '', 0);

                $pdf->SetFont('thsarabun', '', 16);

                $pdf->SetXY(172,60);
                $pdf->Cell(0, 0, $practice_result['STD_CODE'], 0, 1, 'L', 0, '', 0);


                $pdf->SetXY(10,53);

                $html  = '<br /><br /><span stroke="0" fill="true"><b>ชื่อ – สกุล</b> '.$practice_result['PREFIX_NAME_TH'].' '.$practice_result['FIRST_NAME_TH'].'   '.$practice_result['LAST_NAME_TH'].' </span><br />';
                $html .= '<span stroke="0" fill="true"><b>สาขาวิชา</b> '.$practice_result['DEGREENAMETH'].' </span><br />';

                if($practice_result['PRE_REMARK']=='รายงานตัวไม่ชำระเงิน'){
                        $html .= '<span stroke="0" fill="true"><b>วันซ้อมย่อย</b> - </span><br />';
                        $html .= '<span stroke="0" fill="true"><b>เวลา</b>  - </span> <b>สถานที่</b> - </span> <br />';
                        $html .= '<span stroke="0" fill="true"><b>ห้องซ้อม</b> - </span><br />';
                        $html .= '<span stroke="0" fill="true"><b>หมายเหตุ</b>'.$practice_result['PRE_REMARK'].' </span><br />';
                }else{
                        $html .= '<span stroke="0" fill="true"><b>วันซ้อมย่อย</b> '.$practice_result['PRE_DATE'].'</span><br />';
                        $html .= '<span stroke="0" fill="true"><b>เวลา</b> '.$practice_result['PRE_CALL'].' </span> <b>สถานที่:</b>'.$practice_result['CALL_PLACE'].' </span> <br />';
                        $html .= '<span stroke="0" fill="true"><b>ห้องซ้อม</b> '.$practice_result['PRE_CALL_PLACE'].'</span><br />';
                        $html .= '<span stroke="0" fill="true"><b>หมายเหตุ</b>'.$practice_result['PRE_REMARK'].' </span><br />';
                }

                $html .= '<span stroke="0" fill="true">&nbsp;&nbsp;&nbsp;&nbsp;กรุณาอ่านข้อปฏิบัติด้านล่าง หากมีข้อสงสัยเกี่ยวกับกำหนดการฯ กรุณาติดต่อ โทร. 02-2445190-1 กองพัฒนานักศึกษา อาคาร 2 ชั้น 3 </span><br /><br />';
                $html .= '<span stroke="0" fill="true"><b><u>ข้อต้องปฏิบัติ </b></u></span><br />';
                $html .= '<span stroke="0" fill="true">&nbsp;1.&nbsp;บัณฑิตต้องมาซ้อมย่อย ตามวัน-เวลา และสถานที่ ที่ระบุไว้ในบัตรซ้อมย่อยเท่านั้น  </span><br />';
                $html .= '<span stroke="0" fill="true">&nbsp;2.&nbsp;การแต่งกายในวันซ้อมย่อย  </span><br />';
                $html .= '<span stroke="0" fill="true">  &nbsp;&nbsp;&nbsp;&nbsp;   <b> บัณฑิตชาย </b> ให้สวมเสื้อเชิ้ต นุ่งกางเกงผ้าทรงสุภาพ (ห้ามนุ่งยีนส์เด็ดขาด) สวมรองเท้าคัตชูหนังเท่านั้น </span><br />';
                $html .= '<span stroke="0" fill="true">  &nbsp;&nbsp;&nbsp;&nbsp;   <b> บัณฑิตหญิง </b> สวมเสื้อสุภาพมีปก นุ่งกระโปรงไม่รัดรูปยาวคลุมเข่าเล็กน้อย สวมรองเท้าคัตชู คู่ที่จะใส่วันรับจริง </span><br />';
                $html .= '<span stroke="0" fill="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; (ห้ามสวมเสื้อแขนกุดหรือสายเดี่ยวเด็ดขาด) </span><br />';
                $html .= '<span stroke="0" fill="true">&nbsp;3.&nbsp;<b>ติดรูปในบัตรฝึกซ้อมย่อยให้เรียบร้อยก่อนการฝึกซ้อม</b> </span><br />';
                $html .= '<span stroke="0" fill="true">&nbsp;4.&nbsp;ให้นำบัตรนี้ มาแสดงในวันซ้อมย่อย  และวันซ้อมใหญ่ด้วย </span><br />';
                $html .= '<span stroke="0" fill="true">&nbsp;5.&nbsp;บัณฑิตต้องให้ความเคารพ และปฏิบัติตามอาจารย์ผู้ฝึกซ้อมอย่างเคร่งครัด  </span><br />';
                $html .= '<span stroke="0" fill="true">&nbsp;6.&nbsp;บัณฑิตต้องผ่านการซ้อมย่อยแล้ว จึงจะสามารถเข้าซ้อมใหญ่ และเข้ารับพระราชทานปริญญาบัตรได้ </span><br />';
                $html .= '<span stroke="0" fill="true">&nbsp;7.&nbsp;<u>ในวันซ้อมใหญ่สวมครุย</u> ให้บัณฑิตเตรียมรูปถ่ายสวมครุย 1 รูปมาด้วย (เขียน ชื่อ – สกุล และลำดับการเข้ารับ</span><br />';
                $html .= '<span stroke="0" fill="true">&nbsp;&nbsp;&nbsp; ด้านหลังรูป) เพื่อทำบัตรประจำตัวบัณฑิต</span><br />';
                $html .= '<span stroke="0" fill="true">&nbsp;8.&nbsp;ตรวจสอบ วันซ้อมใหญ่ และวันรับจริงรายบุคคล วันที่ 15 สิงหาคม 2565 เป็นต้นไป ทาง www.dusit.ac.th </span><br />';
                $html .= '<span stroke="0" fill="true">&nbsp;9.&nbsp;บัณฑิต ที่มีการแต่งตั้งยศ หลังจากสำเร็จการศึกษา ให้นำคำสั่งแต่งตั้งยศ มายื่นหน้าห้องฝึกซ้อมย่อย Hall ชั้น 2 </span><br />';
                $html .= '<span stroke="0" fill="true">10.&nbsp;บัณฑิตที่เป็น ข้าราชการในพระองค์ฯ  ให้แจ้ง ชื่อ – สกุล ตำแหน่ง ในวันซ้อมย่อย หน้าห้องฝึกซ้อมย่อย Hall ชั้น 2</span><br />';
                $html .= '<span stroke="0" fill="true">11.&nbsp;บัณฑิตต้องสวมหน้ากากอนามัยหรือหน้ากากผ้าตลอดระยะเวลาของการฝึกซ้อม</span><br />';
                $html .= '<span stroke="0" fill="true" style="color:red;">12.&nbsp;<b>บัณฑิตต้องแสดงหลักฐานผลการตรวจ ATK (Antigen test kit) จากสถานพยาบาล หรือจากการตรวจด้วยตนเอง ภายในระยะเวลา 24 ชั่วโมงก่อนการเข้ารับการฝึกซ้อมย่อย โดยหากตรวจด้วยตนเอง ให้เขียน ชื่อ วันที่ เวลาตรวจ ลงในเครื่องตรวจ และเขียนชื่อ-นามสกุล รหัสนักศึกษาลงในกระดาษ แล้ววางทั้งคู่ไว้ด้วยกัน จากนั้นถ่ายรูปและพิมพ์ภาพผลการตรวจที่ยืนยันว่าไม่มีเชื้อไวรัสโคโรนา 2019 (COVID-19)มาแสดงต่อเจ้าหน้าที่ ณ หน้าห้องฝึกซ้อมย่อย</b></span><br />';

                $pdf->writeHTML($html, true, 0, true, 0);



                $pdf->Output('practice.pdf', 'I');
        }else{
                echo "<center> ไม่พบข้อมูล </center>";
        }
    }


    function debug($stdcode){

        $conditions = array(
            'STD_CODE' => base64_decode($stdcode)
        );
        header('Content-Type: application/json');
        echo json_encode($conditions);
    }
}
