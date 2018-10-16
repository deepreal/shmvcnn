<?php
class SHMVC_Controller {
    
    protected $model;
    protected $view;
	protected $url_params=array();
	
    function __construct() {
        $this->view = new SHMVC_View;
    }

    /**
     * @param $url_params
     */
    public function __set_Url_Params($url_params){
		if(is_array($url_params) and sizeof($url_params)>0){
			$this->url_params = $url_params;
		}
	}
	
	public function get_Number_of_Url_Parameters(){
		if(is_array($this->url_params)){
			return(count($this->url_params));
		} else {
			return FALSE;
		}
	}
	
	public function get_Url_Parameter($parameter_no=0){
		if(intval($parameter_no)>0){
			if(is_array($this->url_params) and isset($this->url_params[$parameter_no-1])){
				return($this->url_params[$parameter_no-1]);
			} else {
				return NULL;
			}
		}
	}

	
}