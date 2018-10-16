<?php
class Dunya_asya_turkiye_akdeniz_antalya_Kepez_mahalle_Controller extends SHMVC_Controller{
	function __construct(){
		
	}
	
	public function index_Action(){
		echo("<h2>Burası Mahalle - Kepez Altında</h2>");
		
		$this->liste_Action();
		
	}
	
	public function liste_Action(){
		echo("<h2>- Şafak <br> - Gülveren</h2>");
	}
	
}