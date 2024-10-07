<?php
// FRONT - FORMULARIO de Consulta
// Credenciales Base de Hostinger Ramon
define('DB_HOST', 'localhost');
define('DB_USER', 'u649020098_maat');
define('DB_PASS', 'Limpieza_online33');
define('DB_NAME', 'u649020098_limpieza');
define('URL_FRONT', 'http://maatreeftest1.tech/');
define('URL_BACK', 'http://admin.maatreeftest1.tech/');

// Credenciales En local Mías
// define('DB_HOST', 'localhost');
// define('DB_USER', 'root');
// define('DB_PASS', '');
// define('DB_NAME', 'aaparking');
// define('URL_FRONT', 'http://parking.test/');
// define('URL_BACK', 'http://adminparking.test/');


define('NOMBRE_SITIO', 'Arpro Parking');
define('MAX_INACTIVITY_TIME', 600);

// Credenciales GOOGLE RECAPTCHA V3
define('RECAP_G', '6LcnyR4qAAAAAP8gaetm6v7bhtb5pb1Ts0LVaPsD');
define('SITE_KEY', '6LcnyR4qAAAAAEKgb6lWzMx4lRQ0gYHz4NgvOQbn');

// Para nombrar los títulos de cada página
$folderPath = dirname($_SERVER['SCRIPT_NAME']);
$urlPath = $_SERVER['REQUEST_URI'];
$url = substr($urlPath, strlen($folderPath));
define('URL', $url); 
