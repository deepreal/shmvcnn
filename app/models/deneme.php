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
class deneme extends shController {
    //put your code here
    function __construct() {
        echo " models/deneme"."<br>";
        echo __NAMESPACE__;
    }
    
    function topla1($a,$b){
        return topla($a, $b);
    }
    
}
