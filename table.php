<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?

$tabledata=Array(
	Array('id'=>'1','ad'=>'Süleyman','soyad'=>'HALEP','sil'=>'<a href="sil.php?id=$id">Sil</a>','duzenle'=>'<a href="duzenle.php?id=$id">Düzenle</a>'),
	Array('id'=>'2','ad'=>'Mücahit','soyad'=>'DOĞAN','sil'=>'<a href="sil.php?id=$id">Sil</a>','duzenle'=>'<a href="duzenle.php?id=$id">Düzenle</a>'),
	Array('id'=>'3','ad'=>'Ferhat','soyad'=>'COŞKUN','sil'=>'<a href="sil.php?id=$id">Sil</a>','duzenle'=>'<a href="duzenle.php?id=$id">Düzenle</a>'),
	Array('id'=>'4','ad'=>'Adem','soyad'=>'ÇAMURDAN','sil'=>'<a href="sil.php?id=$id">Sil</a>','duzenle'=>'<a href="duzenle.php?id=$id">Düzenle</a>')
);

/*
$tabledata=Array(
	Array('id'=>'1','ad'=>'Süleyman','soyad'=>'HALEP','sil'=>'<a href="sil.php>Sil</a>"','duzenle'=>'<a href="duzenle.php>Düzenle</a>'),
	Array('id'=>'2','ad'=>'Mücahit','soyad'=>'DOĞAN','sil'=>'<a href="sil.php>Sil</a>"','duzenle'=>'<a href="duzenle.php>Düzenle</a>'),
	Array('id'=>'3','ad'=>'Ferhat','soyad'=>'COŞKUN','sil'=>'<a href="sil.php>Sil</a>"','duzenle'=>'<a href="duzenle.php>Düzenle</a>'),
	Array('id'=>'4','ad'=>'Adem','soyad'=>'ÇAMURDAN','sil'=>'<a href="sil.php>Sil</a>"','duzenle'=>'<a href="duzenle.php?id=4>Düzenle</a>')
);
*/
$table_heads=Array('İd','Ad','Soyad','Sil','Düzenle');

echo "<table border='1'>";

echo "<tr>";
	foreach($table_heads as $th){
		echo "<th>".$th."</th>";
	}
echo "</tr>";

foreach($tabledata as $tr){
	echo "<tr>";
	echo "<td>".$tr['id']."</td>";
	echo "<td>".$tr['ad']."</td>";
	echo "<td>".$tr['soyad']."</td>";
	echo "<td>".$tr['sil']."</td>";
	echo "<td>".$tr['duzenle']."</td>";
	echo "</tr>";
}
echo "</table>";



?>

</body>
</html>