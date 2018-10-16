<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Yeni İçerik</title>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


<script>

$(document).ready(function(e) {
    
	$("#gonder").click(function(e) {

		var formData = new FormData();
		formData.append('dosya', $('#dosya')[0].files[0]);
		$.ajax({
			   url : '<?=ROOT.'icerikler/ajax_image_upload'?>',
			   type : 'POST',
			   data : formData,
			   processData: false,  // tell jQuery not to process the data
			   contentType: false,  // tell jQuery not to set contentType
			   success : function(data) {
				   console.log(data);
				   if(data.sonuc=='success'){
					   $('#content').prepend('<img id="theImg" src="'+data.dosyaismi+'" />')					   
				   } else {
					   $("#uploadsonuc").html(data.errorcode);
				   }
				   console.log(data);
				   alert(data);
				   
			   }
		});		
        
    }); // gonder btn click bitiş
	
	
	
	
}); //dready bitiş


</script>

</head>

<body>
	<h1>YENİ İÇERİK</h1>
<div>

	<div id="content"></div>

    Yüklenecek dosya
    <input name="dosya" type="file" required="required" id="dosya">
    <input type="button" name="gonder" id="gonder" value="Gönder">
  <div id="uploadsonuc"></div>
  
</div>
</body>
</html>