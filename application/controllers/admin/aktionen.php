<?php

class Aktionen extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->load->helper('url');
		
		if(empty($_SESSION['userName']))
		  redirect(site_url('admin/login'));
		
		$this->load->model('aktionen_model');
		$this->load->model('login_model');
	}
	
	public function index() {
		$containers = $this->aktionen_model->listContainers();
		$this->load->view('admin/aktionen_overview', array('containers' => $containers));
	}
	
	public function editaktion($id) {
		$container = $this->aktionen_model->getContainer($id);
		$this->load->view('admin/aktionen_edit', array('container' => $container));
	}
	
	public function addaktion() {
	  $this->aktionen_model->addaktion();
	  redirect(site_url('admin/aktionen'));
	}
		
	public function saveaktion() {

	  $data = $this->input->post('data');
	  $container_id = $data['container_fid'];
	  $container_name = $data['container_name'];
	  $userName = $this->input->post('userName');
	  
	  $this->aktionen_model->changeContainerName($container_name, $container_id);

	  $this->aktionen_model->logUserAction(array('user' => $userName , 'action' => 'Name der Aktionsgruppe zu "'. $container_name .'" geändert.'));
	}
	
	public function sortAktionen(){
	  $data = $this->input->post('order');
	  $userName = $this->input->post('username');
	  
	  
	  $index = 1;
	  foreach($data as $value)
	  {
	    $this->aktionen_model->sortAktionen($index, $value['container_id']);
	    $index++;
	  }
	  
	  $this->aktionen_model->logUserAction(array('user' => $userName , 'action' => 'Reihenfolge der Aktionsgruppen geändert.'));
	}
	
	public function deleteaktion($container_id){
	  $this->aktionen_model->deleteaktion($container_id);
	  
	  $this->aktionen_model->logUserAction(array('user' => $_SESSION['userName'] , 'action' => 'Aktionsgruppe mit ID: "'. $container_id .'" gelöscht.'));
	  
	  //redirect to back to site
	  redirect(site_url('admin/aktionen'));
	}
	
	public function deleteelement($element_id){
	  $this->aktionen_model->deleteelement($element_id);

	  $this->aktionen_model->logUserAction(array('user' => $_SESSION['userName'] , 'action' => 'Element mit ID: "'. $element_id .'" gelöscht.'));
	  
	  //redirect to back to site
	  redirect(site_url('admin/aktionen'));
	}
	
	// called through AJAX from aktionen_overview
	public function toggleaktion() {
	  
		$checked = $this->input->post('checked');
		$containerid = $this->input->post('containerid');
		$userName = $this->input->post('userName');
		
		$this->aktionen_model->toggleaktion($checked, $containerid);
		
		if( $checked == 1 ){
		  $this->aktionen_model->logUserAction(array('user' => $userName , 'action' => 'Aktionsgruppe mit ID: "'. $containerid .'" aktiviert.'));
		}elseif( $checked == 0 ){
		  $this->aktionen_model->logUserAction(array('user' => $userName , 'action' => 'Aktionsgruppe mit ID: "'. $containerid .'" deaktiviert.'));
		}
		
	}
	
	public function toggleelement() {
	  
		$checked = $this->input->post('checked');
		$elementid = $this->input->post('elementid');
		$userName = $this->input->post('userName');
		
		$this->aktionen_model->toggleelement($checked, $elementid);
		
		if( $checked == 1 ){
		  $this->aktionen_model->logUserAction(array('user' => $userName , 'action' => 'Aktionselement mit ID: "'. $elementid .'" aktiviert.'));
		}elseif( $checked == 0 ){
		  $this->aktionen_model->logUserAction(array('user' => $userName , 'action' => 'Aktionselement mit ID: "'. $elementid .'" deaktiviert.'));
		}
		
	}
	
	public function createelement($id) {
		$this->load->view('admin/element_edit', array('element' => null, 'container' => $id));
		
		//$this->aktionen_model->logUserAction(array('user' => $userName , 'action' => 'Aktionselement mit ID: "'. $id .'" erstellt.'));
	}
	
	public function saveelement() {
		$container_fid = $this->input->post('container_fid');
		$element_id = $this->input->post('element_id');
		$element_url   = $this->input->post('element_url');
		//$userName  = $this->input->post('userName');
		$imagefile = $this->uploadimage();
		
		$aktionen_start_data = $this->input->post('aktionen_start');
		$aktionen_end_data = $this->input->post('aktionen_end');
		
		$aktionen_start = '0000-00-00';
		$aktionen_end = '0000-00-00';
		if( !empty($aktionen_start_data) ) {
			$tmpdata1 = explode('-', $aktionen_start_data);
			if( is_array($tmpdata1) && count($tmpdata1) == 3 ) {
				$aktionen_start = sprintf('%04d-%02d-%02d', $tmpdata1[0], $tmpdata1[1], $tmpdata1[2]) . ' 00:01:00';
			}
		}
		
		if( !empty($aktionen_end_data) ) {
			$tmpdata2 = explode('-', $aktionen_end_data);
			if( is_array($tmpdata2) && count($tmpdata2) == 3 ) {
				$aktionen_end = sprintf('%04d-%02d-%02d', $tmpdata2[0], $tmpdata2[1], $tmpdata2[2]) . ' 23:59:00';
			}
		}
		
		$data = array(
			'aktionen_elements_containers_fid' => $container_fid,
			'aktionen_elements_url' => $element_url,
			'aktionen_elements_start' => $aktionen_start,
			'aktionen_elements_end' => $aktionen_end
		);
		
		// because we reuse this function, check if we need to update the image
		// field in our database.
		// TODO: check, if we are coming from a addition function, if so, check
		// for empty image file and through a error response here
		if( !empty($imagefile) ) {
			$data['aktionen_elements_image'] = $imagefile;
		}
		
		$element_id = $this->aktionen_model->saveElement($data, $element_id);
		
		$this->aktionen_model->logUserAction(array('user' => $_SESSION['userName'] , 'action' => 'Aktionselement mit ID: "'. $element_id .'" bearbeitet.'));
		
		redirect('admin/aktionen/editaktion/'.$container_fid);
	}
	
	public function editelement($id) {
		$element = $this->aktionen_model->getElement($id);
		$this->load->view('admin/element_edit', array('element' => $element, 'container' => null));
	}
	
	public function sortElements(){
	  $data = $this->input->post('order');
	  $userName = $this->input->post('userName');
	
	  if($userName != 'undefined'){
	    $this->aktionen_model->logUserAction(array('user' => $_SESSION['userName'] , 'action' => 'Reihenfolge der Aktionselemente geändert.'));
	    
	    $index = 1;
	    foreach($data as $value)
	    {
	      $this->aktionen_model->sortElements($index, $value['container_id']);
	      $index++;
	    }
	  }else{
	    echo 'User undefined, please login';
	  }
	  
	}
	
	public function uploadImage() {
		if(!empty($_FILES['element_image']['tmp_name']) ) {
			$tmpfile = $_FILES['element_image']['tmp_name'];
			$info = getimagesize($tmpfile);
			$image = null;
			
			switch( $info[2] ) {
				case IMAGETYPE_PNG:
					$image = imagecreatefrompng($tmpfile);
					break;
				case IMAGETYPE_JPEG:
					$image = imagecreatefromjpeg($tmpfile);
					break;
				case IMAGETYPE_GIF:
					$image = imagecreatefromgif($tmpfile);
					break;
			}
			
			if( !empty($image) ) {
			  
			  $this->aktionen_model->logUserAction(array('user' => $_SESSION['userName'] , 'action' => 'Neues Bild für Aktionselement hochgeladen.'));
			  
				$resized = imagecreatetruecolor(750, 185);
				imagecopyresampled($resized, $image, 0, 0, 0, 0, 750, 185, imagesx($image), imagesy($image));
				
				$hash = md5(time(true));
				$file = $hash.'.jpg';
				imagejpeg($resized, dirname(BASEPATH).'/files/'.$file, 100);
				return $file;
			}
		}
		
		// we have nothing, return null
		return null;
	}
}