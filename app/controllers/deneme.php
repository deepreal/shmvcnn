<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of newPHPClass
 *
 * @author Suleyman
 */
class deneme extends SHMVC_Controller {
	
	private $db;
	
    function __construct($url_params) {
		parent::__construct($url_params);
		$this->db = new \shDbmysqli('erp_kurumlar','id');
	}
	
	public function index(){
		echo("<h1>Burası deneme controller index fonksiyonu</h1>");
		$this->kurum_liste();
	}
	
	public function kurum_liste(){
		
		echo shmvc_get_language();

		
		$cache_sonuc = \SH_Cache::get_Cache('kurumlistehtml','',TRUE,4);
		
		if($cache_sonuc){
			echo("CACHE");
			$this->view->showContent($cache_sonuc);
			return;
		} else {
			//$liste = $this->db->GetList('id,ustkategoriisim,isim,ilisim','','isim ASC');
			$liste = $this->db->GetList('*','','isim ASC',100);

			$this->view->liste = $liste;
			$sonuc = $this->view->buildView('kurumliste.php');
			\SH_Cache::set_Cache('kurumlistehtml',$sonuc);
			$this->view->showContent($sonuc);
		}
		
		
	}
}