<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Dosya Upload</title>
<script>

var formData = new FormData();
formData.append('file', $('#file')[0].files[0]);

$.ajax({
       url : 'upload.php',
       type : 'POST',
       data : formData,
       processData: false,  // tell jQuery not to process the data
       contentType: false,  // tell jQuery not to set contentType
       success : function(data) {
           console.log(data);
           alert(data);
       }
});

</script>
</head>

<body>
<div><?=$mesaj?></div>
<div><?=$ustmesaj?></div>
<div>
  <form method="post" enctype="multipart/form-data" name="form1" id="form1">
    Yüklenecek dosya
    <input name="dosya" type="file" required="required" id="dosya">
    <input type="submit" name="submit" id="submit" value="Gönder">
  </form>
</div>

</body>
</html>