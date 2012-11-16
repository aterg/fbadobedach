<?php

class Angebote_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function logUserAction($data){
	  $this->db->insert('adobe_edu_logging', $data);
	}
	
	public function listAngebote() {
		$rows = $this->db->get_where('adobeedu_angebote',array('angebote_zombie' => 0));
		$data = array();
		
		foreach($rows->result() as $angebot) {
			$data[] = $angebot;
		}
		
		return $data;
	}

	public function listActiveAngebote() {
	  $rows = $this->db->get_where('adobeedu_angebote', array('angebote_active' => 1, 'angebote_zombie' => 0));
	  $data = array();
	
	  foreach($rows->result() as $angebot) {
	    $data[] = $angebot;
	  }
	
	  return $data;
	}
	
	public function getAngebot($id) {
		$row = $this->db->get_where('adobeedu_angebote',array('angebote_id' => $id), 1);
		$data = $row->result();
		return !empty($data[0]) ? $data[0] : null;
	}
	
	public function save($data, $id) {
		if( !empty($id) ) {
			$this->db->where('angebote_id', $id);
			$this->db->limit(1);
			$this->db->update('adobeedu_angebote', $data);
		} else {
			$this->db->insert('adobeedu_angebote', $data);
		}
	}
	
	public function toggleangebot($checked, $id) {
		$this->db->where('angebote_id', $id);
		$this->db->limit(1);
		$this->db->update('adobeedu_angebote', array('angebote_active' => $checked));
	}
	
	public function deleteangebot($id) {
		$this->db->where('angebote_id', $id);
		$this->db->limit(1);
		$this->db->update('adobeedu_angebote', array('angebote_zombie' => 1));
	}
}