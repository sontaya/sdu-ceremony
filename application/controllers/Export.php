<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends MY_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('Pdf');
        $this->load->model('Practice_model');
        $this->load->model('Commencement_model');
        $this->load->model('Commencementlog_model');

        // if(! $this->session->userdata('auth_session')['std_code'])
        // {
        //   $allowed = array('debug','id');
        //   if(!in_array($this->router->fetch_method(), $allowed))
        //   {
        //     redirect('auth/index');
        //   }
        // }

    }
    function index(){

        redirect('auth/logout');
    }


    function id($encrypt_id){


        if(ENVIRONMENT == "production"){
            $source_path = $_SERVER['DOCUMENT_ROOT']."commencement/";
        }else{
            $source_path = $_SERVER['DOCUMENT_ROOT'];
        }

        $target_student_id = decrypt_data($encrypt_id);
        $client_ip = get_client_ip();

        $conditions = array(
            'STD_CODE' => $target_student_id
        );

        $log_data = array(
            'ACTION_TYPE' => "พิมพ์บัตรซ้อมย่อย",
            'MESSAGE' => json_encode($conditions),
            'CREATED_BY' => $target_student_id,
            'CREATED_BY_IP' => $client_ip
        );
        $log_result = $this->Commencementlog_model->save($log_data);

        $log_time = time();
        $export_filename = "practice-". $target_student_id."-".$log_time.".pdf";


        $practice_result = $this->Practice_model->get_practice_info(array('conditions'=>$conditions))[0];
        $request_result = $this->Commencement_model->list(array('conditions'=>$conditions))[0];

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
                // $pdf->SetXY(140, 3);
                // $pdf->write1DBarcode($practice_result['STD_CODE'] , 'C39', '', '', '', 16, 0.4, $style, 'N');

                $pdf->Ln();

                $pdf->Ln();

                $pdf->SetFont('thsarabun', '', 16);
                $pdf->SetDisplayMode('real', 'default');
                // $pdf->SetXY(10, 20);
                $pdf->Image($source_path.'assets/images/sdu.jpg', 20, 20, 23, 30, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);


                // Define your QR code data
                $qrCodeData = $encrypt_id;

                // Print a QR code
                $style = array(
                    'border' => 0,
                    'vpadding' => 'auto',
                    'hpadding' => 'auto',
                    'fgcolor' => array(0,0,0),
                    'bgcolor' => false, //array(255,255,255)
                    'module_width' => 1, // width of a single module in points
                    'module_height' => 1 // height of a single module in points
                );

                // QRCODE,L : QR-CODE Low error correction
                $pdf->write2DBarcode($qrCodeData, 'QRCODE,L', 125, 60, 40, 40, $style, 'N');

                // $pdf->SetXY(170, 20);
                // $pdf->Image($source_path.'assets/images/photo-frame.jpg', 170, 20, 30, 40, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
                $pdf->Image($source_path.'uploads/'.$request_result['ID_PHOTO'], 170, 60, 30, 40, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);


                $pdf->SetXY(10,28);
                $pdf->SetFont('thsarabun', '', 24);
                $pdf->Cell(0, 0, 'บัตรแสดงตัวบัณฑิต ซ้อมย่อย/ซ้อมใหญ่', 0, 1, 'C', 0, '', 0);

                $pdf->SetXY(10,35);
                $pdf->Cell(0, 0, 'การซ้อมรับพระราชทานปริญญาบัตร', 0, 1, 'C', 0, '', 0);

                $pdf->SetXY(10,42);
                $pdf->Cell(0, 0, 'ประจำปี 2567', 0, 1, 'C', 0, '', 0);

                $pdf->SetFont('thsarabun', '', 16);

                $pdf->SetXY(172,100);
                $pdf->Cell(0, 0, $practice_result['STD_CODE'], 0, 1, 'L', 0, '', 0);


                $pdf->SetXY(20,53);

                $html  = '<br /><br /><span stroke="0" fill="true">ชื่อ – สกุล <strong>'.$practice_result['PREFIX_NAME_TH'].' '.$practice_result['FIRST_NAME_TH'].'   '.$practice_result['LAST_NAME_TH'].' </strong></span><span stroke="0" fill="true">&nbsp;&nbsp;ลำดับที่&nbsp;<strong>'.$practice_result['GRAD_ORDER'].'</strong></span><br />';
                $html .= '<span stroke="0" fill="true">สาขาวิชา <strong>'.$practice_result['DEGREENAMETH'].'</strong> </span><span stroke="0" fill="true">&nbsp;&nbsp;เกรดเฉลี่ย&nbsp;<strong>'.$practice_result['GPA'].'</strong></span><br />';


                if($practice_result['PRACTICE_STATUS'] == "Y"){
                    $html .= '<br /><span stroke="0" fill="true"><strong>วันซ้อมย่อย '.$practice_result['PRE_DATE'].'</strong></span><br />';
                    $html .= '<span stroke="0" fill="true">รอบ '.$practice_result['PRE_CALL'].' </span><span stroke="0" fill="true">'.$practice_result['CALL_PLACE'].' อาคารมหาวชิราลงกรณ ถนนสิรินธร</span> <br />';
                }

                $html .= '<br /><span stroke="0" fill="true"><strong>วันซ้อมใหญ่ (สวมครุย) '.$practice_result['PRE_DATEROUND'].'</strong></span><br />';
                $html .= '<span stroke="0" fill="true">'.$practice_result['PRE_ROUND'].'</span><span stroke="0" fill="true">&nbsp;เรียกแถวเวลา&nbsp; '.$practice_result['PRE_CALLROUND'].'</span><span stroke="0" fill="true">&nbsp;สถานที่&nbsp;'.$practice_result['PRE_CALL_PLACE'].'</span> <br />';

                $html .= '<br /><span stroke="0" fill="true"><strong>วันรับจริง '.$practice_result['GET_DATE'].'&nbsp;&nbsp;'.$practice_result['GET_ROUND'].'</strong></span><br />';
                $html .= '<span stroke="0" fill="true">เรียกแถวเวลา&nbsp;'.$practice_result['GET_CALL'].'</span><span stroke="0" fill="true">&nbsp;&nbsp;สถานที่&nbsp;'.$practice_result['GETCALL_PLACE'].'</span>';


                $html .= '<br /><br /><br /><span stroke="0" fill="true" style="text-align:center;color:red;"><strong>&nbsp;&nbsp;หากมีข้อสงสัยเกี่ยวกับกำหนดการฯ ติดต่อ โทร. 02-2445190-1 กองพัฒนานักศึกษา อาคาร 2 ชั้น 3</strong></span><br /><br />';
                $html .= '<span stroke="0" fill="true"><b>การแต่งกายในวันซ้อมย่อย  </b></span><br />';
                $html .= '<span stroke="0" fill="true">  &nbsp;&nbsp;&nbsp;&nbsp;   <b> บัณฑิตชาย </b> ให้สวมเสื้อเชิ้ต นุ่งกางเกงผ้าทรงสุภาพ (ห้ามนุ่งยีนส์เด็ดขาด) สวมรองเท้าคัตชูหนังเท่านั้น </span><br />';
                $html .= '<span stroke="0" fill="true">  &nbsp;&nbsp;&nbsp;&nbsp;   <b> บัณฑิตหญิง </b> สวมเสื้อสุภาพมีปก นุ่งกระโปรงไม่รัดรูปยาวคุมเข่าเล็กน้อย สวมรองเท้าคัตชู คู่ที่จะใส่ </span><br />';
                $html .= '<span stroke="0" fill="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; วันรับจริง (ห้ามสวมเสื้อแขนกุดหรือสายเดี่ยวเด็ดขาด) </span><br />';
                $html .= '<span stroke="0" fill="true">  &nbsp;&nbsp;&nbsp;&nbsp;   • บัณฑิต ที่มีการแต่งตั้งยศ หลังจากสำเร็จการศึกษา ให้นำคำสั่งแต่งตั้งยศ มายื่นหน้าห้องฝึกซ้อมย่อย </span><br />';
                $html .= '<span stroke="0" fill="true">  &nbsp;&nbsp;&nbsp;&nbsp;   • บัณฑิตที่เป็น ข้าราชการในพระองค์ฯ  ให้แจ้ง ชื่อ – สกุล ตำแหน่ง ในวันซ้อมย่อย หน้าห้องฝึกซ้อมย่อย </span><br />';
                $html .= '<span stroke="0" fill="true" style="color:#122c91;">  &nbsp;&nbsp;&nbsp;&nbsp;   • บัณฑิตที่ต้องการแต่งกายตามเพศสภาพ เพื่อเข้ารับพระราชทานปริญญาบัตร ประจำปี 2567</span><br />';
                $html .= '<span stroke="0" fill="true" style="color:#122c91;">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      สามารถยื่นคำร้องได้ที่หน้าห้องซ้อมย่อย ชั้น 2 หลังซ้อมย่อยเสร็จ และต้องแต่งการตามเพศสภาพ ในวันซ้อมย่อยด้วย </span><br />';

                $html .= '<br /><span stroke="0" fill="true"><strong>ข้อต้องปฏิบัติ </strong></span><br />';
                $html .= '<span stroke="0" fill="true" style="color:#122c91;">  &nbsp;&nbsp;&nbsp;&nbsp;   1. พิมพ์เอกสารนี้มาแสดงตน  ณ จุดรวมแถว ในวันซ้อมย่อย และซ้อมใหญ่</span><br />';
                $html .= '<span stroke="0" fill="true" style="color:#122c91;">  &nbsp;&nbsp;&nbsp;&nbsp;   2. เข้าฝึกซ้อมย่อย และฝึกซ้อมใหญ่ ตามวันเวลาที่มหาวิทยาลัยกำหนด</span><br />';
                $html .= '<span stroke="0" fill="true" style="color:#122c91;">  &nbsp;&nbsp;&nbsp;&nbsp;   3. แต่งกายให้ถูกต้องตามที่กำหนดมิฉะนั้น จะไม่อนุญาตให้เข้าฝึกซ้อม และรับพระราชทานปริญญาบัตร</span><br />';
                $html .= '<span stroke="0" fill="true" style="color:#122c91;">  &nbsp;&nbsp;&nbsp;&nbsp;   4. การแต่งการบัณฑิต ในวันซ้อมใหญ่ และรับจริง ตามประกาศการแต่งการบัณฑิต</span><br />';

                $pdf->writeHTML($html, true, 0, true, 0);



                $pdf->Output($export_filename, 'I');
        }else{
                echo "<center> ไม่พบข้อมูล </center>";
        }
    }





    function debug(){

        // $conditions = array(
        //     'STD_CODE' => base64_decode($stdcode)
        // );
        // header('Content-Type: application/json');
        // echo json_encode($conditions);

        if(ENVIRONMENT == "production"){
            $source_path = $_SERVER['DOCUMENT_ROOT']."ceremony/";
        }else{
            $source_path = $_SERVER['DOCUMENT_ROOT'];
        }
        echo $source_path;
    }
}
