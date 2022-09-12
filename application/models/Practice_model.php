<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Practice_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function get_practice_info($params = array())
  {
    if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
      $this->db->limit($params['limit'],$params['start']);
    }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
      $this->db->limit($params['limit']);
    }

    $this->db->select("STD_CODE, PREFIX_NAME_TH, FIRST_NAME_TH, LAST_NAME_TH
      ,DEGREELEVELNAMETH, DEGREENAMETH, FACULTYNAMETH, MAJORNAMETH
      ,PRE_DATE, PRE_ROUND, PRE_CALL, CALL_PLACE, PRE_CALL_PLACE, PRE_REMARK");

    //,TO_CHAR(PRE_DATE , 'DD MONTHYYYY', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') as PRE_DATE_TH


    $this->db->from("GRADUATE_PRACTICE_6062");

    if (!empty($params['conditions']['STD_CODE'])){
      $this->db->where('STD_CODE', $params['conditions']['STD_CODE']);
    }

    if (!empty($params['conditions']['ID_CARD_CODE'])){
      $this->db->where('ID_CARD_CODE', $params['conditions']['ID_CARD_CODE']);
    }

    // echo $this->db->get_compiled_select();
    $query = $this->db->get();
    return ($query->num_rows() > 0)?$query->result_array():FALSE;

  }

    function list($params = array()){

        if (!empty($params['conditions']['AUTH_STDCODE'])){
            $auth_cond = "AND GC.STD_CODE = '". $params['conditions']['AUTH_STDCODE'] ."' AND GC.ID_CARD_CODE = '". $params['conditions']['AUTH_IDCARD'] ."'";
        }else{
            $auth_cond = "";
        }

        if (!empty($params['conditions']['STDCODE'])){
            $info_cond = "AND GC.STD_CODE = ". $params['conditions']['STDCODE'];
        }else{
            $info_cond = "";
        }

        $query = $this->db->query("SELECT
                                        GC.ID_CARD_CODE, GC.STD_CODE,
                                        GC.PREFIX_NAME_TH, GC.FIRST_NAME_TH , GC.LAST_NAME_TH,
                                        GC.PREFIX_NAME_TH|| GC.FIRST_NAME_TH || ' ' || GC.LAST_NAME_TH AS FULLNAME,
                                        GC.DEGREENAMETH, GC.FACULTYNAMETH, GC.MAJORNAMETH, GC.SITENAMETH
                                    FROM GRADUATE_PRACTICE_6062 GC
                                WHERE 1=1  $auth_cond $info_cond ");
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }



}

