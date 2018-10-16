<?php
class SHMVC_View {
    
    private $data=Array();

    function __construct() {
        
    }
    
    function __set($name, $value) {
        $this->data[$name]=$value;
    }

    function __get($name) {
        return $this->data[$name];
    }

    /**
     * 
     * @param string $viewfile Yuklenecek ve Ekranda Gosterilecek Dosya Yolu/Ismi
     * @param array $data Gosterilecek verilerin tutuldugu key=>value Array
     */
    public function show_view($viewfile,$data=Array()) {
        if(is_readable(APP_PATH.'views/'.$viewfile)){
            if(!empty($data)){
                $this->data = $data;
            }
            extract($this->data);
            include APP_PATH.'views/'.$viewfile;
        } else {
            shmvc_show_error("View Dosyası Yuklenemedi: $viewfile ", TRUE);
            return FALSE;
        }
    }
    
    /**
     * 
     * @param string $viewfile Yuklenecek ve Hafiyaza Alinacak Dosya Yolu/Ismi
     * @param array $data Gosterilecek verilerin tutuldugu key=>value Array
     */   
    public function build_view($viewfile,$data=Array()) {
        if(is_readable(APP_PATH.'views/'.$viewfile)){
            if(!empty($data)){
                $this->data = $data;
            }
            extract($this->data);
            ob_start();
            include APP_PATH.'views/'.$viewfile;
            return ob_get_clean();
        } else {
            shmvc_show_error("View Dosyası Yuklenemedi: $viewfile ", TRUE);
            return FALSE;
        }
    }
    
    /**
     * 
     * @param string $content Gonderilen veriyi ekranda gosterir 
     */
    public function show_content($content='') {
        echo $content;
    }
	
    /**
     * 
     * @param string $content Gonderilen veriyi ekranda gosterir 
     */
    public function clear_data() {
        $this->data=array();
    }	
	

}