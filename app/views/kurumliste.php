<!DOCTYPE html>
<html>
    <head>
    <title>Kurum Liste</title>
    <meta charset="UTF-8">
</head>
<body>

<? if($liste){ ?>

<div><h2>Toplam : <?=sizeof($liste)?></h2></div>
<div>
	
	<table border="1" bgcolor="#CCCCCC">
		<tr>
        <th>ID</th>
        <th>Üst Kategori</th>
        <th>Kurum İsmi</th>
        <th>Şehir</th>
        </tr>    
		<? foreach($liste as $kurum) { ?>
		<tr>
        <td><?=$kurum->id?></td>
        <td><?=$kurum->ustkategoriisim?></td>
        <td><?=$kurum->isim?></td>
        <td><?=$kurum->ilisim?></td>
        </tr>
        
		
		<? } ?>
	</table>
	
</div>

<? } else { ?>

<div>YOKKKK</div>

<? } ?>

</body>
</html>
