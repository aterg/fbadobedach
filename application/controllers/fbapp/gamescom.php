<?php

class Gamescom extends CI_Controller{
  
  public function index(){
    $this->load->view('fbapp/gamescom');
  }
  
  public function redirect($params=null){
  	print '<script type="text/javascript">window.top.location.href="https://www.facebook.com/AdobeEduDACH/app_277223742390945";</script>';
  	exit;
  }
  
	public function like($params=null){
  	print '<script type="text/javascript">window.top.location.href="https://www.facebook.com/AdobeEduDACH/app_277223742390945";</script>';
  	exit;
  }
}

?>