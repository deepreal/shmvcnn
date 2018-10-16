<!DOCTYPE html>
<html>
    <head>
    <title>Kurum Liste</title>
    <meta charset="UTF-8">
</head>
<body>

<h1><?=$baslik?></h1>

<? if($liste){ ?>

<div><h2>Toplam : <?=sizeof($liste)?></h2></div>
<div>
	
	<table border="1" bgcolor="#CCCCCC">
		<tr>
        <th>ID</th>
        <th>İsim Soyisim</th>
        <th>Kurum İsmi</th>
        <th>Birim</th>
        </tr>    
		<? foreach($liste as $kurum) { ?>
		<tr>
        <td><?=$kurum->id?></td>
        <td><?=$kurum->isimsoyisim?></td>
        <td><?=$kurum->kurumisim?></td>
        <td><?=$kurum->birim?></td>
        </tr>
        
		
		<? } ?>
	</table>
	
</div>

<? } else { ?>

<div>YOKKKK</div>

<? } ?>

<div><a href="<?=ROOT?>uyeler/yeni">Yeni Üye Ekle</a></div>
</body>
</html>
