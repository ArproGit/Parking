<?php

namespace App\Models\Helpers;
use App\Models\Nacionalidad;
use App\Models\Usuario;

class FunctionHelper {
    public static function convertir_guion_bajo($string) {
        $string = trim($string);
        $string = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ü', 'Ü'],
            ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N', 'u', 'U'],
            $string
        );
        $string = preg_replace('/[^\p{L}\s]/u', '', $string);
        $string = preg_replace('/\s+/', '_', $string);
        return $string;
    }

}