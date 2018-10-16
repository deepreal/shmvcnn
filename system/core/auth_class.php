<?php
class SHMVC_Auth{
	
	private static $default_login_address;
	private static $default_exit_message='Giris yapilmamis veya Yetkisiz Alan !';

	function __construct(){
	}
	
	public static function is_login_or_redirect($redirect_address=NULL){
		if(!self::is_login()){
			shmvc_redirect_to($redirect_address);
			exit();
		} else {
			return;
		}
	}

	public static function is_login_or_exit($message_before_exit=NULL){
		if(!self::is_login()){
			if(!$message_before_exit){
				$message_before_exit=self::$default_exit_message;
			}
			echo $message_before_exit;
			exit();
		} else {
			return;
		}
	}
	
	public static function is_login(){
		$session_id = session_id();
		if($_SESSION[APP_NAME]['user']['is_login']===true and $_SESSION[APP_NAME]['user']['login_key'] == md5($session_id.$_SERVER['REMOTE_ADDR'])){
			$_SESSION[APP_NAME]['user']['last_active_time'] = time();
			$_SESSION[APP_NAME]['user']['last_request_url'] = $_SERVER['REQUEST_URI'];
			return true;
		} else {
			return false;
		}
	}
	
	public static function set_user_login($user_id=0,$user_name='',$user_info_array=array()){
		// session_regenerate_id(); // Aynı sistem altında birden fazla proje ve farklı kullanıcı girişleri olduğu için problem oluşturuyor o yüzden şimdilik kaldırıldı
		self::logout_user();
		$session_id = session_id();
		$_SESSION[APP_NAME]['user']['is_login']		= true;
		$_SESSION[APP_NAME]['user']['user_id']		= $user_id;
		$_SESSION[APP_NAME]['user']['user_name']	= $user_name;
		$_SESSION[APP_NAME]['user']['session_id']	= $session_id;
		$_SESSION[APP_NAME]['user']['login_key']	= md5($session_id.$_SERVER['REMOTE_ADDR']);
		$_SESSION[APP_NAME]['user']['login_time']	= time();
		$_SESSION[APP_NAME]['user']['last_active_time'] = time();
		$_SESSION[APP_NAME]['user']['last_request_url'] = $_SERVER['REQUEST_URI'];

		if(is_array($user_info_array) and sizeof($user_info_array)>0){
			$_SESSION[APP_NAME]['user']['user_info']=$user_info_array;
		}
	}
	
	public static function set_user_info($info_name,$info_value){
		$_SESSION[APP_NAME]['user']['user_info'][$info_name]=$info_value;
	}
	
	public static function get_user_info($info_name){
		if(isset($_SESSION[APP_NAME]['user']['user_info'][$info_name])){
			return $_SESSION[APP_NAME]['user']['user_info'][$info_name];
		} else {
			return NULL;
		}
	}

	public static function get_user_id(){
		return($_SESSION[APP_NAME]['user']['user_id']);
	}
	
	public static function get_user_name(){
		return($_SESSION[APP_NAME]['user']['user_name']);
	}
	
	public static function logout_user(){
		unset($_SESSION[APP_NAME]['user']);
	}

	public static function can_come_here($section_name){
	}
	
	public static function can_show_all($section_name){
	}
	
	public static function can_edit_all($section_name){
	}

	public static function can_create_all($section_name){
	}

	/*
	can_Show_All($section_name){	// Tüm Kayıtları görebilir
	can_Show_Public($section_name) 	// Ortak kayıtları görebilir
	can_Show_Own($section_name)		// Kendi kayıtlarını görebilir

	can_Show_All($section_name){	// Tüm Kayıtları görebilir
	can_Show_Public($section_name) 	// Ortak kayıtları görebilir
	can_Show_Own($section_name)		// Kendi kayıtlarını görebilir

	*/


}