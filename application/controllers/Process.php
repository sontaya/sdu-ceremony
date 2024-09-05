<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process extends MY_Controller
{
	function __construct()
	{
        parent::__construct();
        $this->load->model('Commencement_model');
        $this->load->model('Practice_model');
        $this->load->library('upload');

        if(! $this->session->userdata('auth_session')['std_code'])
        {
          $allowed = array('debug');
          if(! in_array($this->router->fetch_method(), $allowed))
          {
            redirect('auth/index');
          }
        }

        $this->set_active_tab('practice');
        // $this->load->library('Ajax_pagination');
        // $this->perPage = 50;
	}

	function index(){

        $std_code = $this->session->userdata('auth_session')['std_code'];
        $conditions = array(
            'STD_CODE' => $std_code
        );

            $request_result = $this->Commencement_model->list(array('conditions'=>$conditions))[0];
            $practice_result = $this->Practice_model->get_practice_info(array('conditions'=>$conditions))[0];


            $data['title'] = "อัพโหลดภาพชุดครุย";
            $data['subheader_title'] = "subheader_title";
            $data['subheader_desc'] = "";
            $data['active_tab'] = 'dashboard';
            $data["jsSrc"] = array(
                        'assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
                        // 'assets/js/custom.js',
                        'assets/js/request-index.js',
                        );
            $data['request'] = $request_result;
            $data['practice'] = $practice_result;
            $this->data = $data;
            $this->content = 'request/index';
            $this->metronic_render();

            // header('Content-Type: application/json');
            // echo json_encode($request_result);

    }
    function index2(){

        $auth_session = $this->session->userdata('auth_session');
        header('Content-Type: application/json');
        echo json_encode($auth_session);


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


    public function do_upload() {
        $std_code = $this->session->userdata('auth_session')['std_code'];
        $client_ip = get_client_ip();

        if(ENVIRONMENT == "production"){
            $upload_path = $_SERVER['DOCUMENT_ROOT']."commencement/uploads";
        }else{
            $upload_path = "D:\\laragon-storage\\www\\dusit-ceremony65\\uploads\\";
        }

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 10240; // 2MB
        $config['encrypt_name'] = FALSE;

        $this->upload->initialize($config);
    //     header('Content-Type: application/json');
    //   echo json_encode($config);

        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
            header('Content-Type: application/json');
            echo json_encode($error);
        } else {
            $upload_data = $this->upload->data();
            $timestamp = time();
            $new_filename = $std_code . '-' . $timestamp . $upload_data['file_ext'];
            rename($upload_data['full_path'], $upload_data['file_path'] . $new_filename);

            $data = array(
                'STD_CODE' => $std_code,
                'ID_PHOTO' => $new_filename,
                'UPLOAD_BY_IP' => $client_ip,
                'UPLOAD_STATUS' => 'pending',
                'UPLOAD_DATE' => date('Y-m-d H:i:s')
            );

            $save_result = $this->Commencement_model->save_upload_info($data);
            // header('Content-Type: application/json');
            // echo json_encode($save_result);
            redirect('process/index');
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

        // header('Content-Type: application/json');
        // echo json_encode($slot[0]["SLOT_ROUND"]);

        if(ENVIRONMENT == "production"){
            $source_path = $_SERVER['DOCUMENT_ROOT']."commencement/uploads";
        }else{
            $source_path = $_SERVER['DOCUMENT_ROOT'];
        }
        echo $source_path;

    }

}
