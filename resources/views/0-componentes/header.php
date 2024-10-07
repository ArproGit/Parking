<?php
    if(session_status() == PHP_SESSION_ACTIVE) { } else { session_start();}
    $url = explode('/', URL);
    $url = $url[0];
    if (strpos($url, '_') !== false) {
        $url = str_replace('_', ' ', $url);
        $url = ucwords($url);
    } else {
        $url = ucfirst($url);
    }

    $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', trim($urlPath, '/')); 

?>
<!DOCTYPE html>
<html lang="es">
<head> 
  <meta property="og:title" content="<?php  if (empty($urlPath) || $urlPath == '/') {
        echo "Inicio - ". NOMBRE_SITIO;
    } elseif (isset($segments[1])) { 
        echo ucwords(str_replace('_', ' ', $segments[1]))." - ". NOMBRE_SITIO;
    } elseif (isset($segments[0])) {
        echo ucwords(str_replace('_', ' ', $segments[0]))." - ". NOMBRE_SITIO;
    };?>"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= NOMBRE_SITIO ?> | <?php    
    if (empty($urlPath) || $urlPath == '/') {
        echo "Inicio";
    } elseif (isset($segments[1])) { 
        echo ucwords(str_replace('-', ' ', $segments[1])).'';
    } elseif (isset($segments[0])) {
        echo ucwords(str_replace('-', ' ', $segments[0])).'';
    };?></title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= URL_FRONT ?>public/plugins/fontawesome-free/css/all.min.css">
<!-- icheck bootstrap -->
<link rel="stylesheet" href="<?= URL_FRONT ?>public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= URL_FRONT ?>public/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?= URL_FRONT ?>public/plugins/toastr/toastr.min.css">

  <!-- DataTables -->
  
  <link rel="icon" type="image/png" href="<?= URL_BACK ?>public/img/fav-azul.png" sizes="32x32"> 
  
  <link rel="stylesheet" href="<?= URL_FRONT ?>public/plugins/datatables/datatables.min.css" rel="stylesheet">