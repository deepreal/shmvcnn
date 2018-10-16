<?php
class SHMVC_Cache {
	
	private static $request_caches=array();

    private function __construct() {
    }
	
	public static function set_file_cache($cache_name,$cache_data,$cache_parameter=NULL){
		if(is_array($cache_data) or is_object($cache_data)){
			$cache_data=serialize($cache_data);
			$fileext='_o';
		} else {
			$fileext='_t';
		}
		
		if(is_array($cache_parameter) or is_object($cache_parameter)){
			$filename=md5($cache_name).'_'.md5(serialize($cache_parameter)).$fileext;	
		} else {
			$filename=md5($cache_name).'_'.md5($cache_parameter).$fileext;	
		}

		if (file_put_contents(APP_PATH.'cache/'.$filename,$cache_data)){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public static function get_file_cache($cache_name,$cache_parameter=NULL,$max_life_time=0,$is_array_or_object=FALSE){

		if($is_array_or_object===FALSE){
			$fileext = '_t';
			$serial  = FALSE;
		} else {
			$fileext = '_o';
			$serial	 = TRUE;
		}

		if(is_array($cache_parameter) or is_object($cache_parameter)){
			$filename=md5($cache_name).'_'.md5(serialize($cache_parameter)).$fileext;
		} else {
			$filename=md5($cache_name).'_'.md5($cache_parameter).$fileext;
		}
		
		if(file_exists(APP_PATH.'cache/'.$filename)){
			if($max_life_time==0){
				if($serial){
					return(unserialize(file_get_contents(APP_PATH.'cache/'.$filename)));	
				} else {
					return(file_get_contents(APP_PATH.'cache/'.$filename));
				}
			} else if((time() - filemtime(APP_PATH.'cache/'.$filename)) < $max_life_time){
				if($serial){
					return(unserialize(file_get_contents(APP_PATH.'cache/'.$filename)));	
				} else {
					return(file_get_contents(APP_PATH.'cache/'.$filename));
				}
			}
		}
		
		return FALSE;
		
	} // get_Cache function sonu
	
	/**
	* cache klasöründeki Tüm cache dosyalarını siler
	**/
	public static function delete_all_file_caches(){
		$files = glob(APP_PATH.'cache/*'); 
		foreach($files as $file){
		  if(is_file($file)) {
			  unlink($file);
		  }
		}
	}
	
	public static function set_session_cache($name,$value){
		$_SESSION[APP_NAME]['session_cache'][$name]=$value;
	}
	
	public static function get_session_cache($name){
		return $_SESSION[APP_NAME]['session_cache'][$name];
	}
	
	public static function delete_all_session_caches(){
		$_SESSION[APP_NAME]['session_cache']=array();
	}
	
	public static function set_request_cache($name,$value){
		self::$request_caches[$name]=$value;
	}

	public static function get_request_cache($name){
		return self::$request_caches[$name];
	}

	public static function delete_all_request_caches(){
		self::$request_caches=array();
	}
	
}
