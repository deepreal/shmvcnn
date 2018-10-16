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
class admin_gizli_uyeler_Controller extends SHMVC_Controller {
    //put your code here
    function __construct() {
        // echo " controllers/deneme";
        echo "CLASS Construct icinden".__NAMESPACE__;
    }
	
	public function uyekaydet_Action(){
		shmvc_load_helper('string');
		echo("in func:". harf_say("süleyman"));
	}

        
        public function halep_Action(){
            echo '<h1>halep YUPPPPPPPPPPPPPPPPPPPPPPPIIIIIIIIIIIIIIIIIIIIII</h1>';
        }

        
        public function index_Action(){
            echo '<h1>index YUPPPPPPPPPPPPPPPPPPPPPPPIIIIIIIIIIIIIIIIIIIIII</h1>';
        }
}



