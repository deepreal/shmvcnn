<?php 
// autoload function
/*
function __autoload($class) {
	$class = APP_PATH. str_replace('\\', '/', $class) . '.php';
        if (is_readable($class)){
            require_once($class);
        } else {
            // shmvc_show_error("Class Dosyası Bulunamadı !:$class",TRUE);
            return FALSE;
        }
}
*/

function __autoload($class) {

	$class_arr = explode("_",strtolower($class));


/*
	echo "<br>--- AUTOLOADER -------<br>";
	echo "CLASS İlk çağrılan isimm : ".$class;	
	
	echo "<pre>";
	print_r($class_arr);
	echo "<pre>";
*/
	
	$load_arr  		 = Array("controller","model","builder","collector","worker");
	$class_section	 = $class_arr[count($class_arr)-1];
	$class_file_name = '';
	$addfolder		 = '';
	
//	echo "CLass section :".($class_section)."<br>";
	
	if(count($class_arr)>1 and in_array($class_section,$load_arr)){

		$control_dir	= APP_PATH.$class_section.'s/';		
		array_pop($class_arr);

		foreach($class_arr as $tek_class){
			//echo "Tek Class :".$tek_class."<br>";
			if(is_dir($control_dir.$addfolder.$tek_class)){ // Bölüm Klasör ise
				//echo "Is dir :".$control_dir.$addfolder.$tek_class."<br>";
				$addfolder.=$tek_class.'/';
				array_shift($class_arr);
			} else {
				break;
			}
		}
		
		$class_file_name = $control_dir.$addfolder.implode("_",$class_arr).'_'.$class_section.'.php';
		
		// echo "CLASS File Name : ".$class_file_name."<br>";

        if (is_readable($class_file_name)){
            require_once($class_file_name);
        } else {
			shmvc_show_test_error("Class Dosyası Bulunamadı ! :$class",TRUE);
            return FALSE;
        }		
		
	} else {
		shmvc_show_test_error("Class Dosyası Bulunamadı ! :$class",TRUE);
		return FALSE;
	}
	
}


