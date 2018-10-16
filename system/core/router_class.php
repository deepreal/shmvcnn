<?php
class SHMVC_Router {
    
    private $action;
    private $routes;
    private $default_action     ='index';
    private $default_controller ='index';
    private $urlsections=array();
    private $_tempClass;
    private $controller;
	private $languages;

	// deneme ekleme

    /**
     * 
     * @param array $routes
     */
    function __construct($routes=Array(),$app_languages=Array()) {
        $this->routes       = $routes;
        $this->controller   = $this->default_controller.'_Controller';
        $this->action       = $this->default_action.'_Action';
		$this->languages	= $app_languages;
    }

    private function extract_Url($url) {
		
        if($_SERVER['QUERY_STRING']){
            $url = substr($url, 0, strpos($url,'?'));
        }

		$url = substr($url, strlen(SUB_FOLDER));
        $url = trim($url,'?');
        
        if(!preg_match("/^\/?([a-zA-Z0-9-_]+\/?)*$/",$url)){
            shmvc_show_404();
        }

        $url=trim($url,'/?');
        return($url);
    }
	
	
    public function add_one_route($from,$goto){
		$this->routes[$from]=$goto;
    }
	
	public function get_All_Routes(){
		return($this->routes);
	}
	
    
	private function set_If_Language($urlsection){
		if(!$this->languages){
			return;
		}
		foreach($this->languages as $lang){
			if($urlsection==$lang){
				shmvc_set_language($lang);
				array_shift($this->urlsections);
				return $lang;
			}
		}
	}
	
    private function check_Routes($url) {
        $url=rtrim($url,'/');
        if(!empty($this->routes) and is_array($this->routes)){
            foreach($this->routes as $key=>$val){
                $key = str_replace(array(':any', ':num'), array('[^/]+', '[0-9]+'), $key);
                if (preg_match('#^'.$key.'$#', $url, $matches)){
                    if (strpos($val, '$') !== FALSE && strpos($key, '(') !== FALSE)
                    {
                        $val = preg_replace('#^'.$key.'$#', $val, $url);
                    }
                    return $val;
                }
            }
            return FALSE;
        } else {
            return FALSE;
        }
    }

	private function is_controller_file_load($floadpath){
		
		// echo "Yüklenecek cont dosyası :".strtolower(APP_PATH.'controllers/'.$floadpath.$this->controller.'.php');
		
		if(is_readable(strtolower (APP_PATH.'controllers/'.$floadpath.$this->controller.'.php'))){
			require_once(strtolower(APP_PATH.'controllers/'.$floadpath.$this->controller.'.php'));
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
    public function go(){
        $lasturl     			= trim($this->extract_Url($_SERVER['REQUEST_URI']),'/');
		$f_load_path 			= '';
		$addfolder	 			= '';
		$class_directory_name	= '';

		if($this->languages){
			shmvc_set_language($this->languages[0]); // Default Language (First item)
		}				

		if(strlen($lasturl)>0){
            $checkedroutes = $this->check_Routes($lasturl);
            if($checkedroutes){
                $lasturl=$checkedroutes;
            }
            
            $this->urlsections  = explode('/',$lasturl);
			
			if(sizeof($this->urlsections)>0){

				$this->set_If_Language($this->urlsections[0]);

				foreach ($this->urlsections as $urlsection){
					if(is_dir(APP_PATH.'controllers/'.$addfolder.$urlsection)){
						$addfolder.=$urlsection.'/';
						array_shift($this->urlsections);
					} else {
						break;
					}
				}
				$f_load_path = $addfolder;
				$class_directory_name = str_replace('/','_',$f_load_path);
			}
			
			if(isset($this->urlsections[0])){
				$this->controller	= str_replace('-','_',$this->urlsections[0].'_Controller');
				$url_have_controller= TRUE;
				array_shift($this->urlsections);
			} else {
				$url_have_action	= FALSE;
				$url_have_controller= FALSE;
			}

			if(isset($this->urlsections[0])){
				$this->action		= str_replace('-','_',$this->urlsections[0].'_Action');
				$url_have_action	= TRUE;
				array_shift($this->urlsections);
			}
		}
			
		// Controller kontrol/load ve nesne ornegi olusturma
		if($this->is_controller_file_load($f_load_path)){
			shmvc_set_url_parameters($this->urlsections);
			$_classname  = $class_directory_name.$this->controller;
			$_tempClass  = new $_classname();
			if(!is_subclass_of($_tempClass,"SHMVC_Controller")){
				shmvc_show_test_error('Class tanimlanmis:'.$_classname.' fakat SHMVC_Controller ile extend edilmemis !', TRUE);
			}
		}else{
			if($url_have_controller){
				shmvc_show_404();
			} else {
				shmvc_show_test_error('Default: ('.$this->default_controller.') controller clasi mevcut degil !',TRUE);
				shmvc_show_404();
			}
		}

		// Action kontrol ve çalıştırma 
		if(method_exists($_tempClass, $this->action)){
			//call_user_func_array(array($_tempClass, $this->action),array());
			$_tempClass->{$this->action}();
		} else {
			if($url_have_action){
				shmvc_show_404();
			}else{
				shmvc_show_test_error($_classname.' Class icerisinde tanimli default: ('.$this->default_action.'_Action) metodu mevcut degil !');
				shmvc_show_404();
			}
		}
		return;

    } // go function bitişi
	
} // Class bitiş << açıklama silinecek