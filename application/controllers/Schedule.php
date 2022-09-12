<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends MY_Controller
{
	function __construct()
	{
        parent::__construct();
        $this->load->model('Schedule_model');
        $this->load->model('Ceremonylog_model');
        $this->load->library('Pdf');

        if(! $this->session->userdata('auth_session')['std_code'])
        {
          $allowed = array('debug');
          if(! in_array($this->router->fetch_method(), $allowed))
          {
            redirect('auth/index');
          }
        }

        $this->set_active_tab('schedule');

        // $this->load->library('Ajax_pagination');
        // $this->perPage = 50;
	}

	function index(){

        $std_code = $this->session->userdata('auth_session')['std_code'];
        $conditions = array(
            'STD_CODE' => $std_code
        );

            $schedule_result = $this->Schedule_model->get_schedule_info(array('conditions'=>$conditions))[0];

            $data['title'] = "กำหนดการรับพระราชทานปริญญาบัตร ประจำปี 2560 - 2562";
            $data['subheader_title'] = "subheader_title";
            $data['subheader_desc'] = "";
            $data['active_tab'] = 'dashboard';
            $data["jsSrc"] = array(
                        'assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
                        'assets/js/custom.js',
                        'assets/js/schedule-init-index.js',
                        );
            $data['schedule'] = $schedule_result;
            $this->data = $data;
            $this->content = 'schedule/index';
            $this->metronic_schedule_render();

    }


    public function get_schedule()
    {
      $std_code = $this->input->post('checkStdCode');
      $conditions = array(
        'STD_CODE' => '55113200003'
      );

      $practice_result = $this->Practice_model->get_practice_info(array('conditions'=>$conditions));

      header('Content-Type: application/json');
      echo json_encode($practice_result);
    }


    function export($stdcode)
    {
        if(ENVIRONMENT == "production"){
            $source_path = $_SERVER['DOCUMENT_ROOT']."ceremony/";
        }else{
            $source_path = $_SERVER['DOCUMENT_ROOT'];
        }

        $conditions = array(
            'STD_CODE' =>  $this->session->userdata('auth_session')['std_code']
        );


        $client_ip = get_client_ip();
        $log_data = array(
            'ACTION_TYPE' => "พิมพ์กำหนดการซ้อมใหญ่",
            'MESSAGE' => json_encode($conditions),
            'CREATED_BY' => $this->session->userdata('auth_session')['std_code'],
            'CREATED_BY_IP' => $client_ip
        );
        $log_result = $this->Ceremonylog_model->save($log_data);

        $schedule_result = $this->Schedule_model->get_schedule_info(array('conditions'=>$conditions));



    if(($schedule_result['0']['PRE_REMARK'] == null) OR ($schedule_result['0']['PRE_REMARK'] == '')){

        $pdf = new Pdf('', '', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('กำหนดการรับพระราชทานปริญญาบัตร ประจำปี 2560 - 2562');

        $pdf->setPrintHeader(false);
        // $pdf->setPrintFooter(false);

        // Set footer
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // กำหนดแบ่่งหน้าอัตโนมัติ
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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
        $pdf->SetXY(140, 35);
        $pdf->write1DBarcode($schedule_result['0']['STD_CODE'] , 'C39', '', '', '', 16, 0.4, $style, 'N');

        $pdf->Ln();


        $pdf->Ln();


            $pdf->SetFont('thsarabun', '', 16);
            $pdf->SetDisplayMode('real', 'default');
            $pdf->SetXY(10, 12);
            $pdf->Image($source_path.'assets/images/sdu.jpg', '', '', 23, 30, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

            $pdf->SetXY(35,17);
            $pdf->SetFont('thsarabun', '', 24);
            $pdf->Cell(0, 0, 'กำหนดการรับพระราชทานปริญญาบัตร ประจำปี 2560 - 2562', 0, 1, 'L', 0, '', 0);

            $pdf->SetXY(35,25);
            $pdf->Cell(0, 0, 'มหาวิทยาลัยสวนดุสิต', 0, 1, 'L', 0, '', 0);

            $pdf->SetFont('thsarabun', '', 16);


            $pdf->SetXY(10,30);

                $html = "<br /><br /><br /><br />";
                $html  .= '<span style="text-align:right;">
                                <span stroke="0" fill="true" >
                                    ชื่อ – สกุล :  <b>'.$schedule_result['0']['PREFIX_NAME_TH'].' '.$schedule_result['0']['FIRST_NAME_TH'].'   '.$schedule_result['0']['LAST_NAME_TH'].'</b>
                                </span>
                            </span><br />';
                $html .= '<span style="text-align:right;">
                                <span stroke="0" fill="true" >
                                    สาขาวิชา  : <b> '.$schedule_result['0']['DEGREENAMETH'].' </b>
                                </span>
                                <span stroke="0" fill="true">
                                    เกรดเฉลี่ย  : <b> '.$schedule_result['0']['GPA'].' </b>
                                </span>
                            </span><br />';
                $html .= '<span style="text-align:right;">
                                <span stroke="0" fill="true" >
                                    ลำดับที่  : <b> '.$schedule_result['0']['GET_ORDER_TEXT'].' </b>
                                </span>
                            </span><br />';

                if($schedule_result['0']['PRE_REMARK']==''){




                    $html .= '<span stroke="0" fill="true">วันซ้อมใหญ่(สวมครุย)  : <b> '.$schedule_result['0']['PRE_DATE_TH'].'</b> </span> <br />';
                    $html .= '<span stroke="0" fill="true">ซ้อมรอบที่  : <b> '.$schedule_result['0']['PRE_ROUND'].'</b> </span>  <br />';
                    $html .= '<span stroke="0" fill="true">เรียกแถวเวลา  :<b> '.$schedule_result['0']['PRE_CALL'].'</b> </span>  <span stroke="0" fill="true"> สถานที่รวมแถว : <b>  '.$schedule_result['0']['PRE_CALL_PLACE'].'</b> </span><br />';
                    $html .= '<span stroke="0" fill="true">หมายเหตุ : <b>กรุณาอ่านข้อต้องปฏิบัติด้านล่าง</b></span><br /><br />';

                    $html .= '<span stroke="0" fill="true"><b>ข้อต้องปฏิบัติ <span style="color:red;">วันซ้อมใหญ่</span> </b></span><br />';
                    $html .= '<span stroke="0" fill="true">1. บัณฑิตต้องเข้าฝึกซ้อมใหญ่ตาม วัน-เวลา และสถานที่ ที่มหาวิทยาลัยกำหนด</span><br />';
                    $html .= '<span stroke="0" fill="true">2. บัณฑิตต้องแต่งกายตามระเบียบการแต่งกาย (เอกสารแนบด้านล่าง)</span><br />';
                    $html .= '<span stroke="0" fill="true">3. บัณฑิตต้องแสดงหลักฐานผลการตรวจ ATK (Antigen test kit) จากสถานพยาบาล หรือจากการตรวจด้วยตนเอง </span><br />';
                    $html .= '<span stroke="0" fill="true">&nbsp;&nbsp;&nbsp;&nbsp;ภายในระยะเวลา 24 ชั่วโมงก่อนการเข้ารับการฝึกซ้อมใหญ่ โดยหากตรวจด้วยตนเอง ให้เขียน ชื่อ วันที่ เวลาตรวจ </span><br />';
                    $html .= '<span stroke="0" fill="true">&nbsp;&nbsp;&nbsp;&nbsp;ลงในเครื่องตรวจ และเขียนชื่อ-นามสกุล รหัสนักศึกษาลงในกระดาษ แล้ววางทั้งคู่ไว้ด้วยกัน จากนั้นถ่ายรูปและพิมพ์ </span><br />';
                    $html .= '<span stroke="0" fill="true">&nbsp;&nbsp;&nbsp;&nbsp;ภาพผลการตรวจที่ยืนยันว่าไม่มีเชื้อไวรัสโคโรนา 2019 (COVID-19)มาแสดงต่อเจ้าหน้าที่ ณ จุดรวมแถวบัณฑิต</span><br />';
                    $html .= '<span stroke="0" fill="true">4. บัณฑิตต้องนำบัตรซ้อมย่อยที่มีตราประทับผ่านการฝึกซ้อมย่อย มาแสดงต่อคณะกรรมการฝ่ายรวมแถวบัณฑิต </span><br />';
                    $html .= '<span stroke="0" fill="true">&nbsp;&nbsp;&nbsp;&nbsp;ณ จุดรวมแถวบัณฑิต อาคารรักตะกนิษฐ ชั้น1</span><br />';
                    $html .= '<span stroke="0" fill="true">5. บัณฑิตที่ไม่ได้เข้ารับการซ้อมใหญ่จะไม่อนุญาตให้เข้ารับพระราชทานปริญญาบัตรในวันจริงได้</span><br />';
                    $html .= '<span stroke="0" fill="true" style="text-align:center;">****************************************</span><br />';


                    $html .= '<span stroke="0" fill="true">วันรับจริง  :<b>  '.$schedule_result['0']['GET_DATE_TH'].'</b> </span>  <br />';
                    $html .= '<span stroke="0" fill="true">เรียกแถวเวลา   :<b>  '.$schedule_result['0']['GET_CALL'].'</b> </span>  <span stroke="0" fill="true">  สถานที่รวมแถว :<b>  '.$schedule_result['0']['CALL_PLACE'].'</b> </span><br />';
                    $html .= '<span stroke="0" fill="true">หมายเหตุ : <b>กรุณาอ่านข้อต้องปฏิบัติด้านล่าง</b></span><br /><br />';

                    $html .= '<span stroke="0" fill="true"><b>ข้อต้องปฎิบัติ <span style="color:red;">วันรับจริง</span></b></span><br />';
                    $html .= '<span stroke="0" fill="true">1. บัณฑิตทุกคนต้องเข้ารับการตรวจ ATK (Antigen test kit) ก่อนเวลารวมแถวอย่างน้อย 1 ชั่วโมง ณ ใต้อาคารศูนย์</span><br />';
                    $html .= '<span stroke="0" fill="true">&nbsp;&nbsp;&nbsp;&nbsp;ภาษา ศูนย์คอมพิวเตอร์ มหาวิทยาลัยราชภัฏนครปฐม </span><br />';
                    $html .= '<span stroke="0" fill="true">2. บัณฑิตต้องถึงสถานที่รวมแถวตามวัน - เวลา และสถานที่ ที่มหาวิทยาลัยกำหนด</span><br />';
                    $html .= '<span stroke="0" fill="true">3. บัณฑิตต้องแต่งกายตามระเบียบการแต่งกาย และต้องปฏิบัติตามข้อปฏิบัติของบัณฑิต (เอกสารแนบด้านล่าง) </span><br />';
                    $html .= '<span stroke="0" fill="true" style="text-align:center;color:red;"><b>มีข้อสงสัยเพิ่มเติม กรุณาติดต่อ กองพัฒนานักศึกษา  02-2445190-1</b></span><br />';

                }


            // output the HTML content
            $pdf->writeHTML($html, true, 0, true, 0);
            $pdf->AddPage();

            $pdf->SetXY(90, 12);
            $pdf->Image($source_path.'assets/images/sdu.jpg', '', '', 23, 30, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $pdf->Ln();

            $html_pg2 = '<br /><br /><br /><h2 style="text-align:center;font-size: 20px;">ระเบียบการแต่งกายบัณฑิต มหาบัณฑิต และดุษฎีบัณฑิต<br />มหาวิทยาลัยสวนดุสิต</h2>';
            $pdf->SetFont('thsarabun', '', 16);
            $html_pg2 .= '<h3>1. การแต่งกายของบัณฑิต มหาบัณฑิต และดุษฎีบัณฑิต</h3>';
            $html_pg2 .= '<p style="color:#2a6fdb;font-weight: bold; ">&nbsp;&nbsp;1.1บัณฑิต มหาบัณฑิต และดุษฎีบัณฑิตชาย</p>';
            $html_pg2 .= '<ul style="color:#2a6fdb;">
                                <li>สวมเสื้อเชิ้ตแขนยาวสีขาวไม่มีลวดลาย</li>
                                <li>สวมชุดสูทสีกรมท่าหรือสีน้ำเงินเข้ม (กางเกงและเสื้อสูทสีเดียวกัน)</li>
                                <li>ผูกเนกไทตราสัญลักษณ์ของมหาวิทยาลัยหรือเนคไทสีกรมท่าไม่มีลวดลาย</li>
                                <li>สวมถุงเท้าสีดำไม่มีลวดลาย ยาวเลยข้อเท้าไม่ต่ำกว่า 3 นิ้ว</li>
                                <li>สวมรองเท้าหนังหุ้มส้นสีดำล้วน ไม่มีลวดลาย หรือเครื่องตกแต่งที่เป็นโลหะ (ไม่อนุญาตให้ สวมรองเท้าหนังแก้ว กำมะหยี่</li>
                                <li>ตัดผมทรงสุภาพ ไม่ไว้หนวดเครา</li>
                                <li>สวมครุยวิทยฐานะ ตามสาขาวิชา</li>
                            </ul>
                            <p style="color:#122c91;font-weight: bold;">1.2 บัณฑิต มหาบัณฑิต และดุษฎีบัณฑิตหญิง</p>
                            <ul style="color:#122c91;">
                                <li>สวมเสื้อเครื่องแบบของมหาวิทยาลัย หรือเสื้อเชิ้ตแขนสั้นสีขาวมีสาบหน้า ติดกระดุมเครื่องหมายของมหาวิทยาลัยรางดุมเสื้อเม็ดบนสุดด้วย</li>
                                <li>สวมกระโปรงเข้ารูปทรงตรงหรือทรงสอบ สีกรมท่าหรือสีน้ำเงินเข้ม ยาวคลุมเข่าเล็กน้อย ผ่าหลัง</li>
                                <li>สวมถุงน่องสีเนื้อ ไม่มีลวดลาย (แบบเต็มตัว)</li>
                                <li>สวมรองเท้าหนังหุ้มส้นสีดำ ไม่มีลวดลาย และไม่เปิดหัว สูงไม่เกิน 2.5 นิ้ว (ไม่อนุญาตให้ สวมรองเท้าหนังแก้ว กำมะหยี่ และส้นเข็ม)</li>
                                <li>สวมครุยวิทยาฐานะ ตามสาขาวิชา</li>
                                <li style="color:red;">ให้เกล้าผมขึ้นให้หมด (ห้ามปล่อยหางม้า) ใช้กิ๊บสีดำเท่านั้น เพื่อความเป็นระเบียบเรียบร้อย</li>
                                <li>บัณฑิต และมหาบัณฑิตหญิงที่ตั้งครรภ์ ไม่เกิน 4 เดือน นับถึงวันที่รับพระราชทานปริญญาบัตร ต้องสวมชุดคลุมท้อง (เสื้อสีขาวคอเชิ้ตต่อกับกระโปรง สีกรมท่าหรือสีน้ำเงินเข้ม ติดซิปหลัง)</li>

                            </ul>
                            ';

            $pdf->SetFont('thsarabun', '', 16);


            $pdf->writeHTML($html_pg2, true, 0, true, 0);

            $pdf->AddPage();
            $pdf->SetXY(90, 30);
            $html_pg3 = '<h3>2.	การแต่งกายของบัณฑิต มหาบัณฑิต และดุษฎีบัณฑิต ที่เป็นข้าราชการ พนักงานราชการ พนักงานมหาวิทยาลัย พนักงานรัฐวิสาหกิจ และครูโรงเรียนเอกชน</h3>';
            $html_pg3 .= '<p style="color:#2a6fdb;font-weight: bold;">&nbsp;&nbsp;2.1 ข้าราชการพลเรือน พนักงานราชการ พนักงานมหาวิทยาลัย พนักงานรัฐวิสาหกิจ และครูโรงเรียนเอกชน</p>';
            $html_pg3 .= '<ul style="color:#2a6fdb;">
                                <li>สวมเครื่องแบบชุดปกติขาวตามระเบียบของต้นสังกัด ไม่สวมหมวก</li>
                                <li>สวมครุยวิทยฐานะ ตามสาขาวิชา</li>
                            </ul>
                            <p style="color:#70380f;font-weight: bold;">&nbsp;&nbsp;2.2 ข้าราชการทหาร ตำรวจ ชั้นสัญญาบัตร และชั้นประทวน (ชาย)</p>
                            <ul style="color:#70380f;">
                                <li>สวมเครื่องแบบปกติขาวที่ส่วนราชการต้นสังกัดกำหนด</li>
                                <li>ตัดผมทรงตามระเบียบ ข้าราชการ ทหาร ตำรวจ
                                    <ul style="color:#2a6fdb;">
                                        <li>ข้าราชการทหารประทวนชายชั้นยศ จ่านายสิบ (จ่าสิบตรี จ่าสิบโท จ่าสิบเอก) สังกัดกองทัพบก</li>
                                        <li>ข้าราชการทหารประทวนชายชั้นยศ พันจ่า (พันจ่าตรี พันจ่าโท พันจ่าเอก) สังกัดกองทัพเรือ</li>
                                        <li>ข้าราชการทหารประทวนชายชั้นยศ พันจ่าอากาศ (พันจ่าอากาาตรี พันจ่าอากาศโท พันจ่าอากาศเอก) สังกัดกองทัพเรือ</li>
                                        <li>ข้าราชการตำรวจชั้นประทวนชาย ยศจ่าสิบตำรวจ และนายดาบตำรวจ สังกัดสำนักงานตำรวจแห่งชาติ</li>
                                    </ul>
                                </li>
                                <li>คาดกระบี่กับสามชาย</li>
                                <li>นำถุงมือสีขาวมาด้วย</li>
                                <li>สวมครุยวิทยฐานะ ตามสาขาวิชา</li>
                            </ul>
                            <p style="color:#3c77a9;font-weight: bold;">&nbsp;&nbsp;2.3 ข้าราชการทหาร ตำรวจ ขั้นสัญญาบัตร (หญิง) ชั้นประทวน (ชาย-หญิง)</p>
                            <ul style="color:#3c77a9;">
                                <li>สวมเครื่องแบบปกติขาวที่ส่วนราชการต้นสังกัดกำหนด</li>
                                <li>ตัดผมทรงตามระเบียบข้าราชการ ทหารตำรวจ</li>
                                <li>สวมครุยวิทยฐานะ ตามสาขาวิชา</li>
                            </ul>
                            <p style="color:#3c77a9;font-weight: bold;">&nbsp;&nbsp;2.4 ข้าราชการทหาร ตำรวจ ชั้นประทวน (หญิง)</p>
                            <ul style="color:#3c77a9;">
                                <li>สวมเครื่องแบบปกติขาวที่ส่วนราชการต้นสังกัดกำหนด</li>
                                <li>สวมครุยวิทยฐานะ ตามสาขาวิชา</li>
                            </ul>
                            <p><b><u>หมายเหตุ</u></b>&nbsp;บัณฑิตชาวมุสลิม หรือนักบวชคาทอลิกแต่งกายตามระเบียบของศาสนา</p>
                            ';
            $pdf->writeHTML($html_pg3, true, 0, true, 0);

            $pdf->AddPage();
            // $pdf->Ln();
            // $pdf->SetXY(90, 30);
            $html_pg4 = '<br /><h2 style="text-align:center; color:#122c91;font-size: 24px;">ข้อปฏิบัติของบัณฑิตก่อนการเข้ารับพระราชทานปริญญาบัตร</h2>';
            $html_pg4 .= '
            <ol style="color:#2a6fdb;font-size: 18px;">
                <li>เข้าฝึกซ้อมย่อย และฝึกซ้อมใหญ่ ตามวันเวลาที่มหาวิทยาลัยกำหนด</li>
                <li>การแต่งกายไม่ถูกต้องตามระเบียบการแต่งกายที่กำหนด ไม่อนุญาตให้เข้าฝึกซ้อม และเข้ารับพระราชทานปริญญาบัตร</li>
                <li style="color:red;">บัณฑิต มหาบัณฑิต และดุษฎีบัณฑิตที่ทำสีผม ต้องเปลี่ยนสีผมให้เป็นสีธรรมชาติ  ก่อนวันเข้ารับพระราชทานปริญญาบัตร</li>
                <li>ในวันเข้ารับพระราชทานปริญญาบัตรห้ามตกแต่งร่างกายด้วยเครื่องประดับต่างๆ เช่น ต่างหู สร้อย แหวน นาฬิกา สายรัดข้อมือ สายสิญจน์</li>
                <li>ห้ามสวมแว่นดำ อนุญาตให้สวมแว่นสายตา และใส่คอนแทคเลนส์ สีธรรมชาติ เท่านั้น</li>
                <li>ห้ามทาเล็บ และห้ามไว้เล็บยาว</li>
                <li>ห้ามออกจากหอประชุมเมื่อเข้าที่นั่งเรียบร้อยแล้ว ถ้ามีเหตุจำเป็น ให้แจ้งอาจารย์ ผู้ควบคุมแถวทราบ เพื่อแจ้งฝ่ายฝึกซ้อมให้ช่วยดูแล</li>
                <li>ห้ามนำอาหาร เครื่องดื่ม ของขบเคี้ยว บุหรี่ ไม้ขีดไฟ ไฟแช็ค เศษสตางค์ ปากกา ทิชชู พวงกุญแจ ยาอม ยาหม่อง ฯลฯ เข้าหอประชุมอาคารสิริวรปัญญา มหาวิทยาลัยราชภัฏนครปฐม โดยเด็ดขาด</li>
                <li style="color:red;">ห้ามนำเครื่องมือสื่อสารทุกชนิด เข้าหอประชุมอาคารสิริวรปัญญา มหาวิทยาลัยราชภัฏนครปฐม โดยเด็ดขาด</li>
            </ol>
            ';

            $pdf->writeHTML($html_pg4, true, 0, true, 0);


            $pdf->Output('schedule.pdf', 'I');
        }
        else{
            echo "<center> ไม่พบข้อมูล </center>";
        }
    }


    function debug(){
        // $auth_info = ldap_authenticate('vip1', 'vip1');
        // $auth_info = ldap_authenticate('sontaya_yam', 'everyThing');
        // $register_info = $this->Ceremony_model->get_register_info('6111011802016');
        // $debug = $this->Ceremony_model->set_queue();

        // $active_slot  = $this->Ceremony_model->set_queue();
        // header('Content-Type: application/json');
        // echo json_encode($active_slot);

        // echo ENVIRONMENT;

        // $slot_query = $this->db->get_where('VACCINE_SLOT', array('SLOT_STATUS'=>'A'));
        // $slot = $slot_query->result_array();



        $std_code = $this->session->userdata('auth_session')['std_code'];
        $conditions = array(
            'STD_CODE' => $std_code
        );

        $schedule_result = $this->Schedule_model->get_schedule_info(array('conditions'=>$conditions))[0];
        header('Content-Type: application/json');
        echo json_encode($schedule_result);

    }

}
