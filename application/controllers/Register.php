<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller
{
	function __construct()
	{
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Ceremony_model');
        $this->load->model('Ceremonylog_model');

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

        //-- LOG
        $log_data = array(
            'ACTION_TYPE' => "REGISTER",
            'MESSAGE' => json_encode($data),
            'CREATED_BY' => $this->session->userdata('auth_session')['std_code'],
            'CREATED_BY_IP' => $client_ip
        );
        $log_result = $this->Ceremonylog_model->save($log_data);


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


}
