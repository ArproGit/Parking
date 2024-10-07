<?php 

namespace App\Models\Helpers;

class SecurityHelper{

    public static function generarTokenCSRF(){
        $token1 = bin2hex(random_bytes(32));

        $token2 = $token1;
        // die();
        return $token2;
    }

    public static function validarTokenCSRF($token){
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

}
