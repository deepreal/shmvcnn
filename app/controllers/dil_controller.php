<?php
class dil_Controller extends SHMVC_Controller{

	function __construct(){
		parent::__construct();
	}
	
	// Default Action
	public function index_Action(){
		shmvc_set_language("İngilizce from dil controller");
		echo "Dil ingilizce ayarlandı";
	}
}