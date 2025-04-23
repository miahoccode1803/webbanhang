<?php 
// Tự động xác định URL gốc của website
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? "https://" : "http://";
$domain = $_SERVER['HTTP_HOST'];
$path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

define('INDEX_URL', $protocol . $domain . $path . '/');

define('DB_HOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','qlbh');

define('CONTROLLER_DEFAULT','index');
define('ACTION_DEFAULT','index');
?>
