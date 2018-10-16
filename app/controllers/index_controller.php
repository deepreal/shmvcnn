<?php
class index_Controller extends SHMVC_Controller{

	function __construct(){
		parent::__construct();
		if(shmvc_get_number_of_url_parameters()>2){
			shmvc_show_404();
		}
	}
	
	// Default Action
	public function index_Action(){
		header('Content-Type: text/html; charset=utf-8');


		/*
		$hocalar = new SHMVC_Model("bh_sitekullanicilar","id",SHMVC_Db::get_connection('bekad_hoca_con','bekad_hoca'));
		
		$hocalar_list = $hocalar->get_list("*");

		
		echo("<pre>");
		print_r($hocalar_list);
		echo ("</pre>");
		*/
		
		$kisiler = new Kisiler_Model;	
		// $kisiler_render = SHMVC_Cache::get_file_cache("kisiler_liste",NULL,30);
		
		/*
		if($kisiler_render){ // Cache varsa
			echo("<h1>Cacheden geldi</h1>");			
		//	echo($kisiler_render);
		} else {
			
			$kisiler_list = $kisiler->get_list("*",'','',10000);
			$this->view->kisiler_list = $kisiler_list;
			$kisiler_render = $this->view->build_view('kisiler_liste.php');
 
			SHMVC_Cache::set_file_cache("kisiler_liste",$kisiler_render);

			echo("<h1>Normal sorgudan geldi</h1>");
		//	echo($kisiler_render);

		}
		*/
		
		// $this->view->show_view('kisiler_liste.php');
	}


	// Default Action
	public function halep_Action(){
		echo "<h1>Burası HALEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEP</h1>";
		// $this->view->show_view('index.php');
		header('Content-Type: text/html; charset=utf-8');

		echo "Birinci parametre :".shmvc_get_url_parameter(1)."<br>";
		echo "İkinci parametre :".shmvc_get_url_parameter(2)."<br>";		
		
		
		
	}
	
	public function css_Action(){
		$this->view->show_view("cssdeneme.php");
	}

	public function noaction(){
		echo "<h1>Bu fonksyion url den çalışmamalı</h1>";
	}


}