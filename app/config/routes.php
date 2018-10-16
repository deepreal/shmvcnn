<?php
/*
$routes['product/(:num)'] 	= 'catalog/product_lookup_by_id/$1';
$routes['blog/joe'] 		= 'blogs/users/34';
$routes['urunler/goster/(:num)']= 'urunler/urundetay/$1';
$routes['kategori/(:any)/urun/(:any)']= 'cat/$1/product/$2';
$routes['suleyman/halep']       = 'urunler/suleyman_halep';
$routes['admin']       = 'admin/uyeler';
$routes['halep']       = 'admin/uyeler';

$routes['tr/deneme/(:num)']       = 'tr/deneme/kurum_liste/$1';
$routes['en/deneme/(:num)']       = 'en/deneme/kurum_liste/$1';
$routes['de/deneme/(:num)']       = 'de/deneme/kurum_liste/$1';
$routes['ru/deneme/(:num)']       = 'ru/deneme/kurum_liste/$1';
$routes['deneme/(:num)']	      = 'deneme/kurum_liste/$1';
*/

$routes['(:any)-(:num)']		= 'icerikler/goster?icerik_id=$2';
 $routes['(:any)-(:num)']		= 'icerikler/goster/$2/$1';