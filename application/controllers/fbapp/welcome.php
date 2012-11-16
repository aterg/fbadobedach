<?php

class Welcome extends CI_Controller{
  
	public function __construct() {
		parent::__construct();
		$this->load->model('aktionen_model');
	}
	
	public function index() {
		$containers = $this->aktionen_model->listActivContainers();
		$this->load->view('fbapp/welcome', array('containers' => $containers));  
	}
  
  public function like(){
    $this->load->view('fbapp/like_welcome');
  }
}
?>