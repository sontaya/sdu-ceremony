<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Commencementlog_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function save($data) {
       $result = $this->db->insert('GRADUATE_COMMENCEMENT65_LOG', $data);
        return (isset($result)) ? $result : FALSE;
    }


}
