<?php

class Aktionen_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function listContainers() {
	  $this->db->where('aktionen_container_zombie', 0);
		$this->db->order_by('aktionen_container_sort', 'ASC');
		$rows = $this->db->get('adobeedu_aktionen_container');
		$containers = array();
		foreach( $rows->result() as $container ) {
			$container->elements = $this->listContainerElements($container->aktionen_container_id);
			$containers[] = $container;
		}
		
		return $containers;
	}
	
	public function listActivContainers() {
	  $this->db->where('aktionen_container_activ', 1);
	  $this->db->where('aktionen_container_zombie', 0);
	  $this->db->order_by('aktionen_container_sort', 'ASC');
	  $rows = $this->db->get('adobeedu_aktionen_container');
	  $containers = array();
	  foreach( $rows->result() as $container ) {
	    $container->elements = $this->listActiveContainerElements($container->aktionen_container_id);
	    $containers[] = $container;
	  }
	
	  return $containers;
	}
	
	public function getContainer($id) {
		$row = $this->db->get_where('adobeedu_aktionen_container', array('aktionen_container_id' => $id), 1);
		$container = $row->result();
		if( !empty($container[0]) ) {
			$container[0]->elements = $this->listContainerElements($id);
			return $container[0];
		} else {
			return null;
		}
	}

	public function getActiveContainer($id) {
	  //$this->db->where();
	  $row = $this->db->get_where('adobeedu_aktionen_container', array('aktionen_container_id' => $id), 1);
	  $container = $row->result();
	  if( !empty($container[0]) ) {
	    $container[0]->elements = $this->listContainerElements($id);
	    return $container[0];
	  } else {
	    return null;
	  }
	}
	
	public function logUserAction($data){
	  $this->db->insert('adobe_edu_logging', $data);
	}
	
	public function sortAktionen($position, $container_id){
	  $this->db->where('aktionen_container_id', $container_id);
	  $this->db->update('adobeedu_aktionen_container', array('aktionen_container_sort' => $position));
	}
	
	public function changeContainerName($container_name, $container_id){
	  $this->db->where('aktionen_container_id', $container_id);
	  $this->db->update('adobeedu_aktionen_container', array('aktionen_container_name' => $container_name));
	}
	
	public function toggleaktion($checked, $container_id){
	  $this->db->where('aktionen_container_id', $container_id);
	  $this->db->update('adobeedu_aktionen_container', array('aktionen_container_activ' => $checked) );
	}
	
	public function toggleelement($checked, $element_id){
	  $this->db->where('aktionen_elements_id', $element_id);
	  $this->db->update('adobeedu_aktionen_elements', array('aktionen_elements_active' => $checked) );
	}
	
	public function addaktion(){
	  $this->db->insert('adobeedu_aktionen_container', array('aktionen_container_name' => 'defaultname'));
	}
	
	public function deleteaktion($container_id){
	  $this->db->where('aktionen_container_id', $container_id);
	  $this->db->update('adobeedu_aktionen_container', array('aktionen_container_zombie' => 1));
	  
	  $this->db->where('aktionen_container_id', $container_id);
	  $this->db->update('adobeedu_aktionen_container', array('aktionen_container_sort' => 0));
	}
	
	public function deleteelement($element_id){
	  $this->db->where('aktionen_elements_id', $element_id);
	  $this->db->update('adobeedu_aktionen_elements', array('aktionen_elements_zombie' => 1));
	  
	  $this->db->where('aktionen_elements_id', $element_id);
	  $this->db->update('adobeedu_aktionen_elements', array('aktionen_elements_sort' => 0));
	}
	
	public function listContainerElements($id) {
		$this->db->order_by('aktionen_elements_sort', 'ASC');
		$rows = $this->db->get_where('adobeedu_aktionen_elements', array('aktionen_elements_containers_fid' => $id, 'aktionen_elements_zombie' => 0));

		$elements = array();
		foreach( $rows->result() as $element ) {
			$elements[] = $element;
		}
		
		return $elements;
	}

	public function listActiveContainerElements($id) {
	  $this->db->order_by('aktionen_elements_sort', 'ASC');
	  $rows = $this->db->get_where('adobeedu_aktionen_elements', array('aktionen_elements_containers_fid' => $id, 'aktionen_elements_zombie' => 0 , 'aktionen_elements_active' => 1));
	
	  $today = new DateTime('now');
	   
	  $elements = array();
	  foreach( $rows->result() as $element ) {
	    $start = new DateTime( $element->aktionen_elements_start );
	    $end = new DateTime( $element->aktionen_elements_end );
	    
	    if( $today >= $start && $today <= $end){
	      $elements[] = $element;
	    }else{
	    }
	  }
	
	  return $elements;
	}
	
	public function getElement($id) {
		$row = $this->db->get_where('adobeedu_aktionen_elements', array('aktionen_elements_id' => $id));
		$result = $row->result();
		return !empty($result[0]) ? $result[0] : null;
	}
	
	public function saveElement($data, $id = null) {
		if( empty($id)) {
			$this->db->insert('adobeedu_aktionen_elements', $data);
			$id = $this->db->insert_id();
		} else {
			$this->db->where('aktionen_elements_id', $id);
			$this->db->update('adobeedu_aktionen_elements', $data);
		}
		
		return $id;
	}
	
	public function sortElements($position, $container_id){
	  $this->db->where('aktionen_elements_id', $container_id);
	  $this->db->update('adobeedu_aktionen_elements', array('aktionen_elements_sort' => $position));
	}
}