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
class Html5_Builder extends SHMVC_Builder {
	private $html_content	='';
	private $html_title		='';
	private $html_head_js	='';
	private $html_body_js	='';
	private $html_css		='';

    //put your code here
    private function __construct(){
		parent::__construct();
    }
	
	public function add_JavaScript($jsfile,$headorbody='head',$localorremote='local'){
		if($localorremote=='local'){
			js_line	= '<script src="'.$jsfile.'"></script>';
		} else {
			js_line	= '<script src="'.PUBLIC_PATH.'js/'.$jsfile.'"></script>';
		}
		
		if($headorbody=='body'){
			$this->html_body_js.= $js_line;
		} else {
			$this->html_head_js.= $js_line;
		}
		
	}
	

        
	
}