<?

class gorusme{
	public $gorusen;
	
	public function yenigorusme($isim){
		echo "isim:$isim<br>";
	}
}

class proje{
	public $projeismi;
	public $gorusme;
	
	
	 function __construct(){
		$this->gorusme=new gorusme();		 
	 }
	

}

$p=new proje;
$g=new gorusme;

$g->yenigorusme("Görüşme classından");


$p->gorusme->yenigorusme("Proje classından");



echo rtrim(str_replace("\\", "/", dirname(__FILE__)), "/") . "/";

echo "<br> ds:".(DIRECTORY_SEPARATOR);

?>