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

function __construct(){
}

class admin_index_Controller extends SHMVC_Controller {
	public function index_Action() {
		SHMVC_Auth::is_Login_or_Redirect(ROOT.'login');
		$this->view->kullanici_adi = SHMVC_Auth::get_user_name();
		$this->view->show_view('admin/index.php');
	}
}



