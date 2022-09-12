<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Schedule_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function get_schedule_info($params = array())
  {
    if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
      $this->db->limit($params['limit'],$params['start']);
    }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
      $this->db->limit($params['limit']);
    }

    $this->db->select("STD_CODE, PREFIX_NAME_TH, FIRST_NAME_TH, LAST_NAME_TH
      ,EDULEVELNAMETH, DEGREENAMETH, FACULTYNAMETH, MAJORNAMETH, GPA
      ,PRE_DATE, PRE_ROUND, PRE_CALL, CALL_PLACE, PRE_CALL_PLACE, PRE_REMARK
      ,GET_DATE, GET_ROUND, GET_CALL, GET_ORDER, GET_ORDER_TEXT
      ,TO_CHAR(PRE_DATE , 'DD MONTHYYYY', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') as PRE_DATE_TH
      ,TO_CHAR(GET_DATE , 'DD MONTHYYYY', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') as GET_DATE_TH
      "
    );
    $this->db->from('GRADUATE_SCHEDULE_6062');

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
}

