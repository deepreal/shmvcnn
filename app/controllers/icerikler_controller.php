<?php
class icerikler_Controller extends SHMVC_Controller{

	function __construct(){
		parent::__construct();
	}
	
	// Default Action
	public function index_Action(){
		$this->goster_Action();
	}
	
	public function goster_Action(){
		$data['icerik_param_id']=$this->get_Url_Parameter(1);
		$data['icerik_param_baslik']=$this->get_Url_Parameter(2);
		$this->view->show_view('icerik_goster.php',$data);
	}
	
	public function yeni_icerik_Action(){
		
		shmvc_load_helper('kses_htmlfilter');	
		$allowed_tag =Array(
			'a'=>Array(
				'href'=>array()
			),
			'b'=>Array(),
			'strong'=>Array(),
			'i'=>Array(),
			'u'=>Array(),
			'ul'=>Array(),
			'ol'=>Array(),			
			'li'=>Array(),
			'h1'=>Array(),
			'h2'=>Array(),
			'h3'=>Array(),
		);
		$allowed_protocols = array('http','ftp');
		$this->view->show_view('yeni_icerik.php',$data);
		
	}
	
	public function ajax_image_upload_Action(){
		
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["dosya"]["name"]);
		$extension = end($temp);

		
		if(is_array(getimagesize($_FILES["dosya"]["tmp_name"]))){
		//	echo "Bu resim";
		} else {
		//	echo "Resim Değil !";
		}
		
		if ((($_FILES["dosya"]["type"] == "image/gif")
		|| ($_FILES["dosya"]["type"] == "image/jpeg")
		|| ($_FILES["dosya"]["type"] == "image/jpg")
		|| ($_FILES["dosya"]["type"] == "image/pjpeg")
		|| ($_FILES["dosya"]["type"] == "image/x-png")
		|| ($_FILES["dosya"]["type"] == "image/png"))
		&& in_array($extension, $allowedExts)) {
			if ($_FILES["dosya"]["error"] > 0) {
				$sonuc = 'error';
				$errorcode=$_FILES["dosya"]["error"];
			} else {
				$filename = $_FILES["dosya"]["name"];
			/*
				echo "Upload: " . $_FILES["dosya"]["name"] . "<br>";
				echo "Type: " . $_FILES["dosya"]["type"] . "<br>";
				echo "Size: " . ($_FILES["dosya"]["size"] / 1024) . " kB<br>";
				echo "Temp file: " . $_FILES["dosya"]["tmp_name"] . "<br>";
		*/
				move_uploaded_file($_FILES["dosya"]["tmp_name"], PUBLIC_PATH."uploads/" . $filename);
				$dosya_ismi = PL."uploads/" . $filename;
				$sonuc='success';
			}
		} else {
			$errorcode='Invalid file';
			$sonuc='error';
		}
		
		header('Content-Type: application/json');
		echo json_encode(array('sonuc' => $sonuc,'errorcode'=>$errorcode,'dosyaismi'=>$dosya_ismi));
		
	}
	

}