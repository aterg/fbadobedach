<?php

class Start extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('login_model');
	}
	public function index() {
		if( empty($_SESSION['user']) ) {
			$this->load->helper('url');
			redirect(site_url('admin/login'));
			exit;
		} else {
			$this->load->helper('url');
			redirect(site_url('admin/welcome'));
			exit;
		}
	}
	
	public function login() {
		$this->load->helper('url');
		$this->load->view('admin/login');
		
		if(!empty($_SESSION['loginerror']))
		  echo $_SESSION['loginerror'];
		
	}

	public function dologin() {
		$user = (string)$this->input->post('user');
		$pass = (string)$this->input->post('pass');
		
		if( !empty($user) && !empty($pass) ) {
			$hash = md5($user.$pass);
			$_SESSION['user'] = $hash;
			
			
			$userInfo = $this->login_model->getUserInfo($user);
			
			/*
			echo '<!--' .' ' . $user . ' ' . $pass . ' ' . $hash . '-->';
			var_dump($userInfo);
			*/
			
			if($userInfo != false && (strcmp($userInfo[0]->password , $hash)) == 0){
			  unset($_SESSION['loginerror']);
			  $_SESSION['userName'] = $user;
			  
			  $this->load->helper('url');
			  redirect('admin/welcome');			  
			}else{
			  $_SESSION['loginerror']  = 'Passwort oder User falsch';
			  $this->load->helper('url');
			  redirect('admin/login');
			}
		}		
	}
	
	public function logout() {
		if( !empty($_SESSION['user']))
			unset($_SESSION['user']);
		
		// redirect user to the login page
		$this->load->helper('url');
		redirect('admin/login');
	}
	
	public function welcome() {
		$this->load->view('admin/welcome');
	}
}