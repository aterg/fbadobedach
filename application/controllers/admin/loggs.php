<?php

class Loggs extends CI_Controller {
  public function __construct() {
    parent::__construct();

    $this->load->helper('url');

    if(empty($_SESSION['userName']))
      redirect(site_url('admin/login'));

    $this->load->model('logg_model');
  }
  
  public function index(){
    $loggs = $this->logg_model->listLoggs();
    $this->load->view('admin/logg_overview', array('loggs' => $loggs));
  }
}


?>