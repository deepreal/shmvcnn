<?php

class sayfa_Collector extends SHMVC_Controller{
	
	private $config;

	function __construct($config_array){
		$this->config = $config_array;
	}
	
	public function get_Sol_Menu(){
		$this->view->show_view('yeni_uye.php');
	}
	
	
	
	
}