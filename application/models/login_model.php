<?php

class Login_model extends CI_Model {
  
  public function __construct() {
    parent::__construct();
    $this->load->database();
  }
  
  public function logUserAction($data){
    $this->db->insert('adobe_edu_logging', $data);
  }
  
  public function getUserInfo($username){
    $this->db->where('username', $username);
    $rows = $this->db->get('adobe_edu_aktionen_user');
    
    $result = $rows->result();
    if( !empty($result) && $result != false )
    {
      return $result; 
    }else{
      return false;
    }    
  }
}