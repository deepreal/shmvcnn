<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>

<style type="text/css">

.box{
	border:1px solid #E7E7E7;
	background-color:#F1F1F1;
	color:#424242;
	font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size:14px;
	box-shadow:4px 4px 3px  rgba(0,0,0,0.16);
	width:700px;
	height:500px;
	overflow:scroll;
	position:fixed;
}

.abuton{
	display:inline-block;
	padding:10px;
	background-color:#E3DDDD;
	color:#353535;
	text-decoration:none;
	width:120px;
    color: #7bcd47;
}

</style>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<script>

$(document).ready(function(e) {
	
	lastwindow=1;
	top	=100;
	left=100;

	function pencere_ac(url){
		$("body").append("<div class='box' class='pencere' id='yenipencere"+lastwindow+"'>Loading...!</div>");
		$("#yenipencere"+lastwindow).load(url);
		$("#yenipencere"+lastwindow).css("top",top);
		$("#yenipencere"+lastwindow).css("left",left);
		top=top+30;
		left=left+30;
		lastwindow++;		
	}
	
	$(".yenipencere").click(function(e) {
		url=$(this).data("url");
		pencere_ac(url);
    });


});


</script>


</head>
<body>
<div id="suleyman"></div>
<a href="javascript:;" class="yenipencere abuton" data-url="pencere1.php">Yeni Pencere</a>
<a href="javascript:;" class="yenipencere abuton" data-url="http://localhost/"> Fayda Maliyet</a>
</body>
</html>
