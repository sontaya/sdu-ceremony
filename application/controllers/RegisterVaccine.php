<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller
{
	function __construct()
	{
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Ceremony_model');

        if(! $this->session->userdata('auth_session')['std_code'])
        {
          $allowed = array('debug');
          if(! in_array($this->router->fetch_method(), $allowed))
          {
            redirect('auth/index');
          }
        }

        // $this->load->library('Ajax_pagination');
        // $this->perPage = 50;
	}

	function index(){


            // redirect('auth/logout');
             redirect('register/form');
    }


    function form(){

        $std_code = $this->session->userdata('auth_session')['std_code'];
        $conditions = array(
            'STDCODE' => $std_code
        );
        $data['profile'] = $this->Ceremony_model->list(array('conditions'=>$conditions))[0];

            // if($register_info === false){
            //     $data['profile'] = array(
            //         'CODE_PERSON' => $this->session->userdata('auth_session')['hrcode'],
            //         'CITIZEN_CODE' => $this->session->userdata('auth_session')['citizencode'],
            //         'FIRST_NAME_THA' => $this->session->userdata('auth_session')['firstname'],
            //         'LAST_NAME_THA' => $this->session->userdata('auth_session')['lastname'],
            //         'NAME_FACULTY' => '',
            //         'MOBILE1' =>'',
            //     );
            // }else{
            //     $data['profile'] = $profile[0];
            // }


            // $data['profile'] = $profile[0];


            $data['title'] = "ยืนยันการเข้ารับพระราชทาน ปริญญาบัตร";
            $data['subheader_title'] = "ยินดีต้อนรับ ".$this->session->userdata('auth_session')['fullname'];
            $data['subheader_desc'] = "";
            $data['active_tab'] = 'dashboard';
            $data["jsSrc"] = array(
                        'assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
                        'assets/js/custom.js',
                        'assets/js/register-form-6364.js'
                        );

            $this->data = $data;
            $this->content = 'register-form-std6364';
            $this->metronic_render();

            // redirect('register/closed');


    }

    public function form_store(){
        $client_ip = get_client_ip();
        $confirm_status = $this->input->post('confirm_status');
        $std_code = $this->input->post('std_code');

        $data = array(
            'STD_CONFIRM_STATUS' => $confirm_status,
            'STD_CONFIRM_BY_IP' => $client_ip
        );

        $res = $this->Ceremony_model->update($std_code,$data);

        if($res === true){
            $conditions = array(
                'STD_CODE' => $std_code
            );
            $register_info = $this->Ceremony_model->list(array('conditions'=>$conditions))[0];

            header('Content-Type: application/json');
            echo json_encode($register_info);
        }


    }

    public function form_confirm_delete(){

        $register_id = $this->input->post('register_id');

        $res = $this->Ceremony_model->delete($register_id);

        header('Content-Type: application/json');
        echo json_encode($res);

    }

    public function closed(){


            $data['title'] = "ปิดรับลงทะเบียน";
            $data['subheader_title'] = "ยินดีต้อนรับ ".$this->session->userdata('auth_session')['displayname'];
            $data['subheader_desc'] = "";
            $data['active_tab'] = 'dashboard';

            $this->data = $data;
            $this->content = 'register-closed';
            $this->metronic_render();

    }


    public function export($key){

        if (isset($key)) {

            $register_info = $this->Ceremony_model->get_register_info($key);

            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('ลงทะเบียนแสดงความประสงค์เข้ารับบริการฉีดวัคซีนเข็ม 3 Pfizer (Booster) สำหรับบุคลากรมหาวิทยาลัยสวนดุสิต');

            $pdf->SetMargins(20, 10, 10, true);
            // $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            // $pdf->SetAuthor('Author');

            $pdf->SetFont('thsarabun', '', 16);
            $pdf->SetDisplayMode('real', 'default');
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);
            $pdf->AddPage();


            $html = '<table width="100%" cellpadding="2" cellspacing="0" border="0">
                        <tr >
                        <td colspan="2" align="center"><img src="assets/images/sdu-logo.svg" height="75" ></td>
                        </tr>
                        <tr >
                        <td colspan="2" align="center"><h3>ลงทะเบียนแสดงความประสงค์เข้ารับบริการฉีดวัคซีนเข็ม 3 Pfizer (Booster) สำหรับบุคลากรมหาวิทยาลัยสวนดุสิต</h3></td>
                        </tr>
                        <tr>
                        <td colspan="2"><br></td>
                        </tr>
                        <tr >
                        <td colspan="2" align="left"><strong>เลขบัตรประชาชน : </strong>'.$register_info['0']['CITIZEN_CODE'].'</td>
                    </tr>
                    <tr >
                        <td colspan="2" align="left"><strong>ชื่อ - นามสกุล : </strong>'.$register_info['0']['FIRST_NAME_THA']." ". $register_info['0']['LAST_NAME_THA'] .'</td>
                    </tr>
                    <tr >
                        <td align="left" colspan="2"><strong>เบอร์โทรศัพท์มือถือ  : </strong>'.$register_info['0']['MOBILE'].'</td>
                    </tr>
                    <tr >
                        <td align="left" colspan="2"><strong>วันที่ : </strong> '. $register_info['0']['SLOT_DATE_TH'].' <strong>เวลาที่นัดหมาย  : </strong> '.$register_info['0']['SLOT_TIME'].'</td>

                    </tr>
                    <tr >
                        <td align="left" colspan="2"><strong>สถานที่  : </strong>'.$register_info['0']['SLOT_DESC'].'</td>
                    </tr>

                    </table>';

            $pdf->writeHTML($html, true, false, true, false, '');

            ob_end_clean();
            $filename = time().".pdf";
            $pdf->Output($filename, 'I');
        }

      }





    function debug(){
        // $auth_info = ldap_authenticate('vip1', 'vip1');
        // $auth_info = ldap_authenticate('sontaya_yam', 'everyThing');
        // $register_info = $this->Ceremony_model->get_register_info('6111011802016');
        // $debug = $this->Ceremony_model->set_queue();

        $active_slot  = $this->Ceremony_model->set_queue();
        header('Content-Type: application/json');
        echo json_encode($active_slot);

        // $slot_query = $this->db->get_where('VACCINE_SLOT', array('SLOT_STATUS'=>'A'));
        // $slot = $slot_query->result_array();

        // header('Content-Type: application/json');
        // echo json_encode($slot[0]["SLOT_ROUND"]);

    }

}
