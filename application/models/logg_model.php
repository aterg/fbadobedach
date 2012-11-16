<?php

class Logg_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function listLoggs() {
	  $this->db->order_by('time', 'DESC');
		$rows = $this->db->get('adobe_edu_logging');
		$loggs = array();
		foreach( $rows->result() as $log ) {
			$loggs[] = $log;
		}
		
		return $loggs;
	}	
}