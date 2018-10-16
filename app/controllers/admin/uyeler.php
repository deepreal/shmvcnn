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
class uyeler extends SHMVC_Controller {
    //put your code here

	public function uyekaydet(){
		// shmvc_load_helper('string');
		echo("in func:". harf_say("süleyman"));
	}
        
        public function index() {
            echo "<h1>Bu admin uyeler ici</h1>";
        }
}



