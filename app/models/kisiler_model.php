<?php
class Kisiler_Model extends SHMVC_Model{
	protected $table_fields=array(
	  array('name'=>'id','types'=>'INT(10) UNSIGNED NOT NULL AUTO_INCREMENT'),
	  array('name'=>'aktif','types'=>'TINYINT(1) UNSIGNED NOT NULL'),
	  array('name'=>'isimsoyisim','types'=>'VARCHAR(255) NOT NULL'),
	  array('name'=>'kurumid','types'=>'INT(10) UNSIGNED'),
	  array('name'=>'kurumisim','types'=>'VARCHAR(255)'),
	  array('name'=>'birim','types'=>'VARCHAR(255)'),
	  array('name'=>'birim2','types'=>'VARCHAR(255)'),		  
	  array('name'=>'gorev','types'=>'VARCHAR(255)'),
	  array('name'=>'gorev2','types'=>'VARCHAR(255)'),
	  array('name'=>'statu','types'=>'VARCHAR(255)'),
	  array('name'=>'meslek','types'=>'VARCHAR(255)'),
	  array('name'=>'kararverici','types'=>'TINYINT(1) UNSIGNED NOT NULL'),
	  array('name'=>'gsm','types'=>'VARCHAR(255)'),
	  array('name'=>'gsm2','types'=>'VARCHAR(255)'),		  
	  array('name'=>'telefon','types'=>'VARCHAR(255)'),
	  array('name'=>'dahilino','types'=>'VARCHAR(255)'),
	  array('name'=>'fax','types'=>'VARCHAR(255)'),
	  array('name'=>'eposta1','types'=>'VARCHAR(255)'),
	  array('name'=>'eposta2','types'=>'VARCHAR(255)'),
	  array('name'=>'yasadigisehir','types'=>'VARCHAR(255)'),
	  array('name'=>'adres','types'=>'VARCHAR(255)'),
	  array('name'=>'website','types'=>'VARCHAR(255)'),
	  array('name'=>'facebook','types'=>'VARCHAR(255)'),
	  array('name'=>'twitter','types'=>'VARCHAR(255)'),
	  array('name'=>'dogumtarihi','types'=>'DATE'),
	  array('name'=>'aciklama','types'=>'TEXT'),
	  array('name'=>'musteritemsilcisiid','types'=>'INT(10) UNSIGNED'),
	  array('name'=>'siniflandirma','types'=>'VARCHAR(255)'),
	  array('name'=>'mailonay','types'=>'TINYINT(1) UNSIGNED NOT NULL'),
	  array('name'=>'smsonay','types'=>'TINYINT(1) UNSIGNED NOT NULL'),
	  array('name'=>'faxonay','types'=>'TINYINT(1) UNSIGNED NOT NULL'),
	  array('name'=>'aramaonay','types'=>'TINYINT(1) UNSIGNED NOT NULL'),		  
	  array('name'=>'bilgiistemiyor','types'=>'TINYINT(1) UNSIGNED NOT NULL'),		  
	  array('name'=>'gorusmesayisi','types'=>'INT(10) UNSIGNED NOT NULL'),		  
	  array('name'=>'seminerkatilimsayisi','types'=>'INT(10) UNSIGNED NOT NULL'),		  
	  array('name'=>'kilit','types'=>'TINYINT(1) UNSIGNED NOT NULL'),
	  array('name'=>'olusturanid','types'=>'INT(10) UNSIGNED'),
	  array('name'=>'olusturmazamani','types'=>'INT(10) UNSIGNED'),
	  array('name'=>'degistirenid','types'=>'INT(10) UNSIGNED'),
	  array('name'=>'degistirmezamani','types'=>'INT(10) UNSIGNED'),
	  array('name'=>'sonislemzamani','types'=>'INT(10) UNSIGNED'),
	  array('name'=>'toplamislemsayisi','types'=>'INT(10) UNSIGNED'),
	  array('name'=>'kayitsahibid','types'=>'INT(10) UNSIGNED'),
	  array('name'=>'olusturanbilgileri','types'=>'VARCHAR(255) NOT NULL'),
	  array('name'=>'degistirenbilgileri','types'=>'VARCHAR(255) NOT NULL'),
	);

	function __construct(){
		$this->copyfield="";
		$this->defaultcharset="utf8";
		$this->dbengine="MYISAM";
		parent::__construct('erp_kisiler','id');
	}

}