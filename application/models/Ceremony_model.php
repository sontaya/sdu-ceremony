<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ceremony_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
    }


    function update($id, $data) {
        $this->db->where('STD_CODE', $id);
        $result = $this->db->update('GRADUATE_CEREMONY65', $data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }



    function save($data) {
        $result = $this->db->insert('GRADUATE_CEREMONY65', $data);
        //  $id = $this->db->insert_id();
        //  return (isset($id)) ? $id : FALSE;
         return (isset($result)) ? $result : FALSE;
     }

    function confirm($id, $data) {
        $this->db->where('GRADUATE_CEREMONY65', $id);
        $result = $this->db->update('GRADUATE_CEREMONY65', $data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }




    function list($params = array()){

        if (!empty($params['conditions']['AUTH_STDCODE'])){
            $auth_cond = "AND GC.STD_CODE = '". $params['conditions']['AUTH_STDCODE'] ."' AND GC.IDCARD = '". $params['conditions']['AUTH_IDCARD'] ."'";
        }else{
            $auth_cond = "";
        }

        if (!empty($params['conditions']['STDCODE'])){
            $info_cond = "AND GC.STD_CODE = ". $params['conditions']['STDCODE'];
        }else{
            $info_cond = "";
        }

        $query = $this->db->query("SELECT
                                        GC.IDCARD, GC.STD_CODE,
                                        GC.PREFIX_NAME_TH, GC.FIRST_NAME_TH , GC.LAST_NAME_TH,
                                        GC.PREFIX_NAME_TH|| GC.FIRST_NAME_TH || ' ' || GC.LAST_NAME_TH AS FULLNAME,
                                        GC.EDULEVELNAMETH, GC.DEGREENAMETH, GC.FACULTYNAMETH, GC.MAJORNAMETH, GC.SITENAMETH,
                                        GC.STD_CONFIRM_DATE, TO_CHAR(GC.STD_CONFIRM_DATE, 'dd/mm/yyyy', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') AS STD_CONFIRM_DATE_TH,
                                        GC.STD_CONFIRM_STATUS, GC.GRAD_CONFIRM_STATUS
                                FROM GRADUATE_CEREMONY65 GC
                                WHERE 1=1  $auth_cond $info_cond ");
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }


}
