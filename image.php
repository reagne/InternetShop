<?php

require_once("src/connection.php");

header("Content-Type: image/jpeg");
$f = fopen('./src/images/0585fd9d1609519bc1a9a2fb3c1072d2.jpg', 'r');

// /var/www/html/warsztaty/InternetShop//src/images/0585fd9d1609519bc1a9a2fb3c1072d2.jpg

fpassthru($f);

