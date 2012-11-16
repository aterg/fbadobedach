<?php

class Angebote extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->load->helper('url');
		
		if(empty($_SESSION['userName']))
		  redirect(site_url('admin/login'));
		
		$this->load->model('angebote_model');
	}
	
	public function index() {
		$angebote = $this->angebote_model->listAngebote();
		$data = array(
			'angebote' => $angebote
		);
		$this->load->view('admin/angebote_overview', $data);
	}
	
	public function editangebot($id=null) {
		// handle empty id:
		// angebot is added later
		// otherwise angebot is saved only
		$data = array(
			'angebot' => $this->angebote_model->getAngebot($id)
		);
		$this->load->view('admin/angebote_edit', $data);
	} 
	
	public function saveangebot() {
		$id = $this->input->post('angebote_id');
		$angebote_name  = $this->input->post('angebote_name');
		$userName = $this->input->post('userName');
		
		$angebote_price_euro = $this->input->post('angebote_price_euro');
		$angebote_price_cent = $this->input->post('angebote_price_cent');
		$angebote_price = sprintf("%d.%02d", $angebote_price_euro, $angebote_price_cent);
	
		$angebote_offer_euro = $this->input->post('angebote_offer_euro');
		$angebote_offer_cent = $this->input->post('angebote_offer_cent');
		$angebote_offer = sprintf("%d.%02d", $angebote_offer_euro, $angebote_offer_cent);
		
		$angebote_start_data = $this->input->post('angebote_start');
		$angebote_end_data = $this->input->post('angebote_end');
		
		$angebote_start = '0000-00-00';
		$angebote_end = '0000-00-00';
		if( !empty($angebote_start_data) ) {
			$tmpdata1 = explode('-', $angebote_start_data);
			if( is_array($tmpdata1) && count($tmpdata1) == 3 ) {
				$angebote_start = sprintf('%04d-%02d-%02d', $tmpdata1[0], $tmpdata1[1], $tmpdata1[2]);
			}
		}
		
		if( !empty($angebote_end_data) ) {
			$tmpdata2 = explode('-', $angebote_end_data);
			if( is_array($tmpdata2) && count($tmpdata2) == 3 ) {
				$angebote_end = sprintf('%04d-%02d-%02d', $tmpdata2[0], $tmpdata2[1], $tmpdata2[2]);
			}
		}
		
		$data = array(
			'angebote_name' => $angebote_name,
			'angebote_price' => $angebote_price,
			'angebote_offer' => $angebote_offer,
			'angebote_start' => $angebote_start,
			'angebote_end' => $angebote_end
		);
		
		$this->angebote_model->save($data, $id);
		
		$this->angebote_model->logUserAction(array('user' => $userName , 'action' => 'Angebot mit dem Namen: "'. $angebote_name .'" geändert.'));
		
		redirect(site_url('admin/angebote'));
	}
	
	public function deleteangebot($angebote_id) {
		$this->angebote_model->deleteangebot($angebote_id);

		$this->angebote_model->logUserAction(array('user' => $_SESSION['userName'] , 'action' => 'Angebot mit ID: "'. $angebote_id .'" gelöscht.'));
		
  	//redirect to back to site
  	redirect(site_url('admin/angebote'));
	}
	
	public function toogleangebot() {
		$checked = $this->input->post('checked');
		$angebote_id = $this->input->post('angebote_id');
		$userName = $this->input->post('userName');
		
		$this->angebote_model->toggleangebot($checked, $angebote_id);
		
		if($checked == 1){
		  $this->angebote_model->logUserAction(array('user' => $userName , 'action' => 'Angebot "'. $angebote_id .'" aktiviert.'));
		}elseif($checked == 0){
		  $this->angebote_model->logUserAction(array('user' => $userName , 'action' => 'Angebot "'. $angebote_id .'" deaktiviert.'));		  
		}
	}
}