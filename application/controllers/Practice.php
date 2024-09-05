<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Practice extends MY_Controller
{
	function __construct()
	{
        parent::__construct();
        $this->load->model('Practice_model');

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
        // $data['profile'] = $this->Ceremony_model->list(array('conditions'=>$conditions))[0];
        // $conditions = array(
        //     'STD_CODE' => '55113200003'
        // );



            $practice_result = $this->Practice_model->get_practice_info(array('conditions'=>$conditions))[0];

            $data['title'] = "กำหนดการรับพระราชทานปริญญาบัตร ประจำปี 2565";
            $data['subheader_title'] = "subheader_title";
            $data['subheader_desc'] = "";
            $data['active_tab'] = 'dashboard';
            $data["jsSrc"] = array(
                        'assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
                        'assets/js/custom.js',
                        'assets/js/schedule-index.js',
                        );
            $data['practice'] = $practice_result;
            $this->data = $data;
            $this->content = 'practice/index';
            $this->metronic_practice_render();

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


    function debug(){
        // $auth_info = ldap_authenticate('vip1', 'vip1');
        // $auth_info = ldap_authenticate('sontaya_yam', 'everyThing');
        // $register_info = $this->Ceremony_model->get_register_info('6111011802016');
        // $debug = $this->Ceremony_model->set_queue();

        // $active_slot  = $this->Ceremony_model->set_queue();
        // header('Content-Type: application/json');
        // echo json_encode($active_slot);

        echo ENVIRONMENT;

        // $slot_query = $this->db->get_where('VACCINE_SLOT', array('SLOT_STATUS'=>'A'));
        // $slot = $slot_query->result_array();

        // header('Content-Type: application/json');
        // echo json_encode($slot[0]["SLOT_ROUND"]);

    }

}
