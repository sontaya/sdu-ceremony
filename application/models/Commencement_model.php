<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commencement_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
    }


    function update($id, $data) {
        $this->db->where('STD_CODE', $id);
        $result = $this->db->update('GRADUATE_COMMENCEMENT65', $data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }



    function save($data) {
        $result = $this->db->insert('GRADUATE_COMMENCEMENT65', $data);
        //  $id = $this->db->insert_id();
        //  return (isset($id)) ? $id : FALSE;
         return (isset($result)) ? $result : FALSE;
     }

    function confirm($id, $data) {
        $this->db->where('GRADUATE_COMMENCEMENT65', $id);
        $result = $this->db->update('GRADUATE_COMMENCEMENT65', $data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function save_upload_info($data) {
       // Prepare data for Oracle, converting the date to the correct format
       $user_id = $data['STD_CODE'];
       $upload_filename = $data['ID_PHOTO'];
       $upload_by_ip = $data['UPLOAD_BY_IP'];
       $upload_status = $data['UPLOAD_STATUS'];
       $upload_date = date('Y-m-d H:i:s', strtotime($data['UPLOAD_DATE']));

       // Build the SQL query
       $sql = "UPDATE GRADUATE_COMMENCEMENT65
                    SET ID_PHOTO = ?,
                        UPLOAD_DATE = TO_DATE(?, 'YYYY-MM-DD HH24:MI:SS'),
                        UPLOAD_BY_IP = ?,
                        UPLOAD_STATUS = ?
                    WHERE STD_CODE = ?";
        // return $sql;
       // Execute the query
       return $this->db->query($sql, array($upload_filename,$upload_date,$upload_by_ip, $upload_status, $user_id));
    }


    public function reject($data) {
        // Prepare data for Oracle, converting the date to the correct format
        $user_id = $data['STD_CODE'];
        $reject_reason = $data['REJECT_REASON'];
        $upload_status = $data['UPLOAD_STATUS'];
        $last_modify_by_ip = $data['LAST_MODIFY_BY_IP'];
        $last_modify_by = $data['LAST_MODIFY_BY'];
        $last_modify_date = date('Y-m-d H:i:s', strtotime($data['LAST_MODIFY_DATE']));



        // Build the SQL query
        $sql = "UPDATE GRADUATE_COMMENCEMENT65
                     SET
                         UPLOAD_STATUS = ?,
                         REJECT_REASON = ?,
                         LAST_MODIFY_BY_IP = ?,
                         LAST_MODIFY_BY = ?,
                         LAST_MODIFY_DATE = TO_DATE(?, 'YYYY-MM-DD HH24:MI:SS')
                     WHERE STD_CODE = ?";

        return $this->db->query($sql, array($upload_status,$reject_reason,$last_modify_by_ip, $last_modify_by, $last_modify_date , $user_id));
    }

    public function remark($data) {
        // Prepare data for Oracle, converting the date to the correct format
        $user_id = $data['STD_CODE'];
        $remark_get = $data['REMARK_GET'];
        $last_modify_by_ip = $data['LAST_MODIFY_BY_IP'];
        $last_modify_by = $data['LAST_MODIFY_BY'];
        $last_modify_date = date('Y-m-d H:i:s', strtotime($data['LAST_MODIFY_DATE']));



        // Build the SQL query
        $sql = "UPDATE GRADUATE_PRACTICE_65
                     SET
                         REMARK_GET = ?,
                         LAST_MODIFY_BY_IP = ?,
                         LAST_MODIFY_BY = ?,
                         LAST_MODIFY_DATE = TO_DATE(?, 'YYYY-MM-DD HH24:MI:SS')
                     WHERE STD_CODE = ?";

        return $this->db->query($sql, array($remark_get,$last_modify_by_ip, $last_modify_by, $last_modify_date , $user_id));
    }

    public function approve($data) {
        // Prepare data for Oracle, converting the date to the correct format
        $user_id = $data['STD_CODE'];
        $upload_status = $data['UPLOAD_STATUS'];
        $last_modify_by_ip = $data['LAST_MODIFY_BY_IP'];
        $last_modify_by = $data['LAST_MODIFY_BY'];
        $last_modify_date = date('Y-m-d H:i:s', strtotime($data['LAST_MODIFY_DATE']));



        // Build the SQL query
        $sql = "UPDATE GRADUATE_COMMENCEMENT65
                     SET
                         UPLOAD_STATUS = ?,
                         REJECT_REASON = '',
                         LAST_MODIFY_BY_IP = ?,
                         LAST_MODIFY_BY = ?,
                         LAST_MODIFY_DATE = TO_DATE(?, 'YYYY-MM-DD HH24:MI:SS')
                     WHERE STD_CODE = ?";

        return $this->db->query($sql, array($upload_status,$last_modify_by_ip, $last_modify_by, $last_modify_date , $user_id));
    }


    function list($params = array()){

        if (!empty($params['conditions']['AUTH_STDCODE'])){
            $auth_cond = "AND GC.STD_CODE = '". $params['conditions']['AUTH_STDCODE'] ."' AND GC.ID_CARD_CODE = '". $params['conditions']['AUTH_IDCARD'] ."'";
        }else{
            $auth_cond = "";
        }

        if (!empty($params['conditions']['STD_CODE'])){
            $info_cond = "AND GC.STD_CODE = ". $params['conditions']['STD_CODE'];
        }else{
            $info_cond = "";
        }

        $query = $this->db->query("SELECT
                                        GC.ID_CARD_CODE, GC.STD_CODE,
                                        GC.PREFIX_NAME_TH, GC.FIRST_NAME_TH , GC.LAST_NAME_TH,
                                        GC.PREFIX_NAME_TH|| GC.FIRST_NAME_TH || ' ' || GC.LAST_NAME_TH AS FULLNAME,
                                        GC.DEGREELEVELNAMETH, GC.DEGREENAMETH, GC.FACULTYNAMETH, GC.MAJORNAMETH, GC.SITENAMETH,
                                        GC.STD_CONFIRM_STATUS, GC.GRAD_CONFIRM_STATUS
                                        ,GC.ID_PHOTO, GC.UPLOAD_STATUS, GC.REJECT_REASON, TO_CHAR(GC.UPLOAD_DATE, 'dd/mm/yyyy HH24:MI', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') AS UPLOAD_DATE_TH
                                        ,TO_CHAR(GC.LAST_MODIFY_DATE, 'dd/mm/yyyy HH24:MI', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') AS LAST_MODIFY_DATE_TH
                                FROM GRADUATE_COMMENCEMENT65 GC
                                WHERE 1=1  $auth_cond $info_cond ");
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }


    function timestamp_save($data) {
        $result = $this->db->insert('GRADUATE_TIMESTAMP', $data);
         return (isset($result)) ? $result : FALSE;
     }

}
