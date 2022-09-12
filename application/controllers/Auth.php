<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

    // $this->load->model('Ceremony_model');
    $this->load->model('Practice_model');
    $this->load->model('Ceremonylog_model');

    // if(! $this->session->userdata('uid'))
    // {
    //   $allowed = array('index');
    //   if(! in_array($this->router->fetch_method(), $allowed))
    //   {
    //     redirect('auth/index');
    //   }
    // }
	}

	public function index()
	{
    $data['title'] = "Login | กำหนดการซ้อมย่อย รับพระราชทานปริญญาบัตร ประจำปี 2559-2560 มหาวิทยาลัยสวนดุสิต";
    $this->load->view('login',$data);
	}

  public function login()
  {

    $client_ip = get_client_ip();


    // $conditions = array(
    //     'AUTH_STDCODE' => '55113200003',
    //     'AUTH_IDCARD' => '55113200003'
    // );


    $conditions = array(
        'AUTH_STDCODE' => $this->input->post('username'),
        'AUTH_IDCARD' => $this->input->post('passwd')
    );

    $response = $this->Practice_model->list(array('conditions'=>$conditions));

    if($response == false){
        header('Content-Type: application/json');
        echo json_encode($response);
    }else{

        $arraydata = array(
          'std_code' => $response[0]["STD_CODE"],
          'fullname' => $response[0]["FULLNAME"]
        //   'grad_confirm_status' => $response[0]["GRAD_CONFIRM_STATUS"]
        );

        $log_data = array(
            'ACTION_TYPE' => "AUTH",
            'MESSAGE' => json_encode($arraydata),
            'CREATED_BY' => trim($response[0]["STD_CODE"]),
            'CREATED_BY_IP' => $client_ip
        );
        $log_result = $this->Ceremonylog_model->save($log_data);


        $this->session->set_userdata('auth_session',$arraydata);

        header('Content-Type: application/json');
        echo json_encode($response);
    }





  }


  public function logout()
  {
    $this->session->sess_destroy();
    redirect('auth/index');
  }

  public function ldap()
  {
    $response = ldap_authenticate('u6111011802016', 'admin@l;of6lb9');
    header('Content-Type: application/json');
    echo json_encode($response);

  }

  public function access_level()
  {
    $response = $this->auth_model->get_access_level('3340700388593');
    print_r($response);
  }

  public function debug(){
    //   $this->load->view('demo/login_demo');

    $username = 'phattaraphorn_run';
    $passwd = 'admin@sdu';
    $response = $this->Auth_model->login($username,$passwd);
    echo json_encode($response);
  }
}
