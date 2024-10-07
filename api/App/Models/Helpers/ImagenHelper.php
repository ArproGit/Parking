<?php

namespace App\Models\Helpers;

class ImagenHelper {

    
    public static function subirImagen($imagen, $nuevoAncho,$nuevoAlto,$directorioDestino) {
        list($ancho, $alto) = getimagesize($imagen["tmp_name"]);
        $rutaTempArchivo = $imagen["tmp_name"];
        $type_image = $imagen["type"];
        if($type_image == "image/jpeg"){
            $aleatorio1 = mt_rand(100,999);
            $aleatorio2 = mt_rand(100,999);
            $ruta_imagen_perfil = $directorioDestino."administrador_".$aleatorio1.$aleatorio2.".jpeg";
            $ruta_perfil_guardar = $directorioDestino."administrador_".$aleatorio1.$aleatorio2.".jpeg";
            $origen = imagecreatefromjpeg($rutaTempArchivo);						
            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
            imagejpeg($destino, $ruta_imagen_perfil);
            return $ruta_perfil_guardar;
        }

        if($type_image ==  "image/png"){
            $aleatorio1 = mt_rand(100,999);
            $aleatorio2 = mt_rand(100,999);
            $ruta_perfil = $directorioDestino."administrador_".$aleatorio1.$aleatorio2.".png";
            $ruta_perfil_guardar = $directorioDestino."administrador_".$aleatorio1.$aleatorio2.".png";
            $origen = imagecreatefrompng($rutaTempArchivo);						
            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
            imagepng($destino, $ruta_perfil);
            return $ruta_perfil_guardar;
        }		
    }

}