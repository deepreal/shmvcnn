<?php
/**
 * @param string $mesajtext Gösterilecek mesaj
 * @param bool $triggererror Hata tetiklemesi yapılsın mı?
 * @param bool $log Hata log dosyasına işlensin mi?
 */
function shmvc_show_error($mesajtext, $triggererror=TRUE, $log=FALSE){
    if($log){
        $logtext = date('d-m-Y H:i:s',  time())." - ". $mesajtext."\r\n";
        file_put_contents(APP_PATH.'log/error.log',$logtext, FILE_APPEND);
    }
    if($triggererror){
        trigger_error($mesajtext, E_USER_WARNING);
        die();
    }else{
        echo $mesajtext;
        die();
    }  
}


function shmvc_show_test_error($mesajtext, $triggererror=TRUE, $log=TRUE){
    if($log){
        $logtext = date('d-m-Y H:i:s',  time())." - ". $mesajtext."\r\n";
        file_put_contents(APP_PATH.'log/error.log',$logtext, FILE_APPEND);
    }
	
	if(ORTAM=='test'){
		if($triggererror){
			trigger_error($mesajtext, E_USER_WARNING);
		}else{
			echo $mesajtext;
		}  
	}
	
}



function shmvc_show_404(){
	header("HTTP/1.0 404 Not Found");
	echo "<div align='center'>";
	echo "<h1>404 Not Found</h1>";
	echo "The page that you have requested could not be found.";
	echo "</div>";
	exit();
}

/**
 * Yuklenecek helper dosyasi 'system/helpers/' klasorunde olmali ve _helper.php ile bitmeli
 * @param string $helperfile Yuklenecek helper dosyasi
 */

function shmvc_load_helper($helperfile){
	if(is_readable(SYS_PATH.'helpers/'.$helperfile.'_helper.php')){
		include_once(SYS_PATH.'helpers/'.$helperfile.'_helper.php');
		return true;
	} else {
		shmvc_show_test_error(SYS_PATH.'helpers/'.$helperfile.'_helper.php Dosyası yüklenemedi !');
		return false;
	}
}


/**
 * Yuklenecek Library dosyasi 'system/libraries/' klasorunde olmali 
 * @param string $class_file_path_n_file_name Yuklenecek class dosyasi yolu ve tam ismi
 */

function shmvc_load_library($class_file_path_n_file_name){
	if(is_readable(SYS_PATH.'libraries/'.$class_file_path_n_file_name)){
		include_once(SYS_PATH.'libraries/'.$class_file_path_n_file_name);
		return true;
	} else {
		shmvc_show_test_error(SYS_PATH.'libraries/'.$class_file_path_n_file_name.' Dosyası yüklenemedi !');
		return false;
	}
}


/**
 * Yuklenecek config dosyasi app/config/klasorunde olmali .php ile bitmeli
 * @param string $configfile Yuklenecek configurasyon dosyasi
 * @param string $return_config_item fonksiyonun dondurecegi configurasyon degiskeni
 */
function shmvc_load_config($config_file=NULL,$return_config_item=NULL){
	
	static  $_all_config_vars=Array();
	static  $_loaded_config_files=Array();
	
	if($config_file){
		if(!in_array($config_file,$_loaded_config_files)){
			
			if(is_readable(APP_PATH.'config/'.ORTAM.'/'.$config_file.'.php')){
				$_load_config_file = APP_PATH.'config/'.ORTAM.'/'.$config_file.'.php';
			} else if(is_readable(APP_PATH.'config/'.$config_file.'.php')){
				$_load_config_file = APP_PATH.'config/'.$config_file.'.php';
			} else {
				$_load_config_file = false;
			}
			
			if($_load_config_file){
				require_once($_load_config_file);
				foreach(get_defined_vars() as $key=>$val){
					if($key!='_all_config_vars' and $key!='_loaded_config_files' and $key!='config_file' and $key!='return_config_item' and $key!='_load_config_file'){
						$_all_config_vars[$key] = $val;
					}
				}
			}
			$_loaded_config_files[]=$config_file;
		}
	}
	
	if($return_config_item){
		if($return_config_item=='*'){
			return $_all_config_vars;
		}
		return $_all_config_vars[$return_config_item];
	}
}

/**
 * Configurasyon icerisinden istediginiz degiskenin degerini dondurur.
 * Isterseniz ayni zamanda bir config dosyasini da yukletebilirsiniz
 * @param string $config_item dondurulecek configurasyon degiskeni
 * @param string $load_config_file Yuklenecek configurasyon dosyasi
 */
function shmvc_config_item($config_item,$load_config_file=NULL){
	return shmvc_load_config($load_config_file,$config_item);
}

function shmvc_config_all_items(){
	return shmvc_load_config(NULL,'*');
}

function shmvc_set_language($language){
	$GLOBALS[APP_NAME]['_app_language']=$language;
}

function shmvc_get_language(){
	return $GLOBALS[APP_NAME]['_app_language'];
}

function shmvc_set_url_parameters($url_parameters_array){
	$GLOBALS[APP_NAME]['_url_parameters']=$url_parameters_array;
}

function shmvc_get_url_parameter($parameter_no){
	if(intval($parameter_no)>0){
		if(is_array($GLOBALS[APP_NAME]['_url_parameters']) and isset($GLOBALS[APP_NAME]['_url_parameters'][$parameter_no-1])){
			return($GLOBALS[APP_NAME]['_url_parameters'][$parameter_no-1]);
		} else {
			return NULL;
		}
	}
	return NULL;
}

function shmvc_get_number_of_url_parameters(){
	if(is_array($GLOBALS[APP_NAME]['_url_parameters'])){
		return(count($GLOBALS[APP_NAME]['_url_parameters']));
	} else {
		return 0;
	}
}

function shmvc_redirect_to($url){
	header ('Location:'."$url");
	exit();
}
