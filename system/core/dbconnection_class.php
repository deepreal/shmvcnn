<?php
class SHMVC_Db {
	private static $connections			= array();
	private static $default_connection	= NULL;
	private function __construct() {}
	private function __clone() {}
	
	
	/*
	public static function get_connection($db_name=NULL,$db_host=NULL,$user_name=NULL,$user_password=NULL){
		// Defaults
		
		$host		= shmvc_config_item('mysql_host','config');
		$username	= shmvc_config_item('mysql_username');
		$password	= shmvc_config_item('mysql_password');
		$db			= shmvc_config_item('mysql_defaultdb');
		
		if($db_name		 !=NULL){ $db		= $db_name		;} 
		if($db_host		 !=NULL){ $host		= $db_name		;} 
		if($user_name	 !=NULL){ $username	= $user_name	;} 
		if($user_password!=NULL){ $password	= $user_password;}
		
		$connection_md5_id = md5($db.$host.$user_name.$password);
		
		//$connection_md5_id = base64_encode($db.$host.$user_name.$password);
		
		//$connection_md5_id = ($db.$host.$user_name.$password);
		
		if(self::$connections[$connection_md5_id]){
			return(self::$connections[$connection_md5_id]);
		} else {
			self::$connections[$connection_md5_id] = mysqli_connect($host,$username,$password,$db);

			if(mysqli_connect_errno()){
				shmvc_show_error("MySQL Database bağlantı problemi: " . mysqli_connect_errno() ." - ". mysqli_connect_error());
			} else {
				mysqli_query(self::$connections[$connection_md5_id],"SET NAMES 'utf8' COLLATE 'utf8_general_ci'");	
				return(self::$connections[$connection_md5_id]);
			}
		}
		
		
		//echo $connection_md5_id."<br>";

		
	}
	*/
	
	
	public static function get_connection($connection_name=NULL,$db_name=NULL,$db_host=NULL,$user_name=NULL,$user_password=NULL){
		
		if(!$connection_name){
			if(!self::$default_connection){
				$host		= shmvc_config_item('mysql_host','config');
				$username	= shmvc_config_item('mysql_username');
				$password	= shmvc_config_item('mysql_password');
				$db			= shmvc_config_item('mysql_defaultdb');
				self::$default_connection = mysqli_connect($host,$username,$password,$db);
				
				if(mysqli_connect_errno()){
					shmvc_show_error("MySQL Connection Error : " . mysqli_connect_errno() ." - ". mysqli_connect_error());
					return FALSE;
				} else {
					mysqli_query(self::$default_connection,"SET NAMES 'utf8' COLLATE 'utf8_general_ci'");	
				}
			
			}
			return(self::$default_connection);
		} else {
			if(self::$connections[$connection_name]){
				return(self::$connections[$connection_name]);
			} else {
				$host		= shmvc_config_item('mysql_host','config');
				$username	= shmvc_config_item('mysql_username');
				$password	= shmvc_config_item('mysql_password');
				$db			= shmvc_config_item('mysql_defaultdb');				
				if($db_name		 !=NULL){ $db		= $db_name		;} 
				if($db_host		 !=NULL){ $host		= $db_host		;} 
				if($user_name	 !=NULL){ $username	= $user_name	;} 
				if($user_password!=NULL){ $password	= $user_password;}				
				self::$connections[$connection_name] = mysqli_connect($host,$username,$password,$db);
				
				if(mysqli_connect_errno()){
					shmvc_show_error("MySQL Connection Error : " . mysqli_connect_errno() ." - ". mysqli_connect_error());
					return FALSE;
				} else {
					mysqli_query(self::$connections[$connection_name],"SET NAMES 'utf8' COLLATE 'utf8_general_ci'");	
					return(self::$connections[$connection_name]);
				}
				
			}
		}

	}
	


	
}
