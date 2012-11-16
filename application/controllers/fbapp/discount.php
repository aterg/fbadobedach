<?php

class Discount extends CI_Controller{
  public function __construct() {
    parent::__construct();
    $this->load->model('angebote_model');
  }
  
  public function index(){
    $angebote = $this->angebote_model->listActiveAngebote();
    $data = array(
      'angebote' => $angebote    
    );
    
    $this->load->view('fbapp/discount', $data);
  }
  
  public function like(){
    $this->load->view('fbapp/like_discount');
  }
}

?>