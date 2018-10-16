<?php
class login_Controller extends SHMVC_Controller{

	function __construct(){
		parent::__construct();
	}
	
	// Default Action
	public function index_Action(){
		
		if(SHMVC_Auth::is_login()){
			shmvc_redirect_to(ROOT.'admin');
		}
		
		if($_POST){
			
			if($_POST['kullaniciadi']==''){
				$this->view->loginhata="Lütfen kullanıcı adınızı boş geçmeyiniz !";
			} else {
				
				if($_POST['kullaniciadi']=='suleyman' or $_POST['kullaniciadi']=='yusuf' or $_POST['kullaniciadi']=='yunus'){
					SHMVC_Auth::set_user_login('0',$_POST['kullaniciadi']);
					shmvc_redirect_to(ROOT.'admin');
				} else {
					$this->view->loginhata="Girdiğiniz kullanıcı adı yanlış !";
				}
			}
			
		}
		$this->view->show_view('login_form.php');
	}
	
	
	public function logout_Action(){
		SHMVC_Auth::logout_user();
		shmvc_redirect_to(ROOT.'login');
	}
	
	
}