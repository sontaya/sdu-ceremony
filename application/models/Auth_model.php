<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();

	}

  public function login($identity, $password)
  {
    if(empty($identity) || empty($password))
    {
      //-- Set error msg
      return false;
    }

        //-- LDAP Auth
        $auth_info = ldap_authenticate($identity, $password);

        if($auth_info != null)
        {

            $auth['uid'] = $auth_info["uid"]["0"];
            $auth['idcode'] = $auth_info["idcode"]["0"];
            $auth['hrcode'] = $auth_info["hrcode"]["0"];
            $auth['citizencode'] = $auth_info["idcardno"]["0"];
            $auth['displayname'] = $auth_info["displayname"]["0"];
            $auth['employeetype'] = $auth_info["employeetype"]["0"];
            $auth['firstname'] = $auth_info["thcn"]["0"];
            $auth['lastname'] = $auth_info["thsn"]["0"];

        return $auth;

        }else{
            $auth['uid'] = "";
            $auth['idcode'] = "";
            $auth['hrcode'] = "";
            $auth['citizencode'] = "";
            $auth['displayname'] = "";
            $auth['employeetype'] = "";
            $auth['firstname'] = "";
            $auth['lastname'] = "";

        return $auth;
        }



  }


}
