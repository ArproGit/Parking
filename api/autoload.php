<?php

spl_autoload_register(function($clase){
    $ruta =  str_replace("\\", "/", $clase ). ".php";

    if (file_exists($ruta)) {
        require_once dirname(__FILE__) .  "/". $ruta;
    } else {
        print '<pre>';
        var_dump( $ruta);
        print '</pre>';
        die("No se pudo cargar la clase $clase");
    }   
});