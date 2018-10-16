<?php
class uyeler_Controller extends SHMVC_Controller{

	function __construct(){
		parent::__construct();
	}
	
	// Default Action
	public function index_Action(){
		$kisi = new \Models\Kisiler_Model();
		$liste=$kisi->getList('*','','',20);
		$this->view->baslik  = 'ÜYE LİSTESİ';
		$this->view->liste   = $liste;
		$this->view->show_view('uyeler.php');
	}
	
	public function yeni_Action(){
		$this->view->show_view('yeni_uye.php');
	}
	
}