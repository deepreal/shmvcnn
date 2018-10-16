<!DOCTYPE html>
<html>
    <head>
    <title>Kişiler Liste</title>
    <meta charset="UTF-8">
</head>
<body>

<h1><?=$baslik?></h1>

<? if($kisiler_list){ ?>

<div><h2>Toplam : <?=sizeof($kisiler_list)?></h2></div>
<div>
	
	<table border="1" bgcolor="#CCCCCC">
		<tr>
        <th>ID</th>
        <th>İsim Soyisim</th>
        <th>Kurum İsmi</th>
        <th>Birim</th>
        </tr>    
		<? foreach($kisiler_list as $kisi) { ?>
		<tr>
        <td><?=$kisi->id?></td>
        <td><?=$kisi->isimsoyisim?></td>
        <td><?=$kisi->kurumisim?></td>
        <td><?=$kisi->birim?></td>
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
