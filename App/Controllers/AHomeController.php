<?php 

namespace App\Controllers;

use App\Models\Helpers\SecurityHelper;
use App\Models\Helpers\MyArchivoPdf;
use App\Models\AAdmin;
use App\Models\BEmpleados;
use App\Models\ELugares;
use App\Models\FAsignaciones;
use App\Models\GAsignacionesTemporales;
use App\Models\HIps;

class AHomeController extends Controller{
    
    public function index(){
        try {
            $ip_addres = $_SERVER['REMOTE_ADDR'];
            $model0 = new HIps;
            $registro = $model0 ->where('ip_address', "LIKE", $ip_addres)
                                 ->get();
            if($registro && $registro[0]["active"] == 1){
                header("Location: https://www.google.com");
                exit();     
            }
        } catch (\Exception $e) {$_SESSION['mensaje_error1'] = 'Error: ' . $e->getMessage();}
        session_start();
        if (isset($_SESSION["data_initEmpleado"]) || isset($_SESSION["data_initEmpleado"])  === true) {
            return $this->redirect('/panel-empleado');
        }
        return $this->view('0-inicio.0-index');
    }
    public function recuperar_clave_empleado(){
        try {
            $ip_addres = $_SERVER['REMOTE_ADDR'];
            $model0 = new HIps;
            $registro = $model0 ->where('ip_address', "LIKE", $ip_addres)
                                 ->get();
            if($registro && $registro[0]["active"] == 1){
                header("Location: https://www.google.com");
                exit();     
            }
        } catch (\Exception $e) {$_SESSION['mensaje_error1'] = 'Error: ' . $e->getMessage();}
        session_start();
        if (isset($_SESSION["data_initEmpleado"]) || isset($_SESSION["data_initEmpleado"])  === true) {
            return $this->redirect('/panel-empleado');
        }
        return $this->view('0-inicio.1-recuperar-clave-empleado');
    }


    // public function salir(){
    //     session_start();
    //     header("Location: /");
    //     $_SESSION = array();				
    //     $_SESSION["mensajes"]["mensaje_exito"] = 'toastr.success("Sesión cerrada con éxito")';
    //     setcookie(session_name(), '', time()-56000);	
    //     session_destroy();	
    // }

    public function ingresar_empleado_sesion(){
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token'])) {

            // $recaptchaResponse = $_POST['g-recaptcha-response'];
            // $secretKey = RECAP_G;
            // $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
            // $data = array(
            //     'secret' => $secretKey,
            //     'response' => $recaptchaResponse
            // );
            // $options = array(
            //     'http' => array(
            //         'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            //         'method' => 'POST',
            //         'content' => http_build_query($data)
            //     )
            // );
            // $context = stream_context_create($options);
            // $response = file_get_contents($verifyUrl, false, $context);
            // $recaptchaResult = json_decode($response);

            // if ($recaptchaResult->success && $recaptchaResult->score >= 0.7) {
            // } else {
            
            //     try {
            //         $ip_addres = $_SERVER['REMOTE_ADDR'];
            //         $model0 = new HIps;
            //         $registros = $model0 ->where('ip_address', "=", $ip_addres)
            //                              ->get();
            //         if(!$registros){
            //             $data = ["ip_address" => $ip_addres];
            //             $model = new HIps;
            //             $model->create($data);
            //         }
            //     } catch (\Exception $e) {$_SESSION['mensaje_error1'] = 'Error: ' . $e->getMessage();}
            //     $_SESSION["mensajes"]["mensaje_error"] = 'toastr.error("No tienes permisos para acceder")';
            //     return $this->redirect('/index');
            // }

            
            $data = $_POST;
            unset($data["g-recaptcha-response"]);
            unset($data['csrf_token']);
            $empleado_form = htmlspecialchars($data['empleado_form']);
            $data['email'] = htmlspecialchars($empleado_form);

            $password_form = htmlspecialchars($data['password_form']);
            $data['clave'] = htmlspecialchars($password_form);
            unset($data['password_form']);
            unset($data['empleado_form']);

            $model = new BEmpleados;
            $empleado_log = $model->checkEmpleado($data);
            if ($empleado_log) {
                $_SESSION["mensajes"]["mensaje_exito"] = 'toastr.success("Sesión iniciada con éxito")';
                return $this->redirect('/panel-empleado');
            } else {
                $_SESSION["mensajes"]["mensaje_error"] = 'toastr.warning("Credenciales inválidas")';
                return $this->redirect('/index');
            }
        }else {
            $_SESSION["mensajes"]["mensaje_error"] = 'toastr.error("No tienes permisos para acceder")';
            return $this->redirect('/index');
        }
    }
    public function intentando_recuperar_clave(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token'])) {

            // $recaptchaResponse = $_POST['g-recaptcha-response'];
            // $secretKey = RECAP_G;
            // $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
            // $data = array(
            //     'secret' => $secretKey,
            //     'response' => $recaptchaResponse
            // );
            // $options = array(
            //     'http' => array(
            //         'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            //         'method' => 'POST',
            //         'content' => http_build_query($data)
            //     )
            // );
            // $context = stream_context_create($options);
            // $response = file_get_contents($verifyUrl, false, $context);
            // $recaptchaResult = json_decode($response);

            // if ($recaptchaResult->success && $recaptchaResult->score >= 0.7) {
            // } else {
            
            //     try {
            //         $ip_addres = $_SERVER['REMOTE_ADDR'];
            //         $model0 = new HIps;
            //         $registros = $model0 ->where('ip_address', "=", $ip_addres)
            //                              ->get();
            //         if(!$registros){
            //             $data = ["ip_address" => $ip_addres];
            //             $model = new HIps;
            //             $model->create($data);
            //         }
            //     } catch (\Exception $e) {$_SESSION['mensaje_error1'] = 'Error: ' . $e->getMessage();}
            //     $_SESSION["mensajes"]["mensaje_error"] = 'toastr.error("No tienes permisos para acceder")';
            //     return $this->redirect('/index');
            // }

            
            $data = $_POST;

            unset($data["g-recaptcha-response"]);
            unset($data['csrf_token']);
            $email_recuperar = htmlspecialchars($data['email_recuperar']);
            $data['email_recuperar'] = htmlspecialchars($email_recuperar);

            if ($data['email_recuperar']) {         
                $empleado_encontrado = [];
                try {
                    $modelAdmin = new BEmpleados;
                    $empleado_encontrado = $modelAdmin ->where('email', "=", $data['email_recuperar'])
                                                    ->get();
                   
                } catch (\Exception $e) {$_SESSION['mensaje_error1'] = 'Error: ' . $e->getMessage();}

                if ($empleado_encontrado) {
                    $id_del_empleado_encontrado = $empleado_encontrado[0]['id'];
                    $email_del_empleado_encontrado = $empleado_encontrado[0]['email'];

                    $bytes = random_bytes(8);
                    $generar_clave = bin2hex($bytes);
                    $hashed_password = password_hash($generar_clave, PASSWORD_DEFAULT);
                    $fecha_expiracion = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                    $data_actualizada = [
                        'clave_recuperacion' => $hashed_password,
                        'fecha_expiracion' => $fecha_expiracion
                    ];
                    $actualizando_empleado = [];
                    try {
                        $model = new BEmpleados;
                        $actualizando_empleado = $model->update($id_del_empleado_encontrado, $data_actualizada);
                    } catch (\Exception $e) {$_SESSION['mensaje_error1'] = 'Error: ' . $e->getMessage();}

                    if ($actualizando_empleado) {
                        $subject = "Clave de acceso generada";
                        $message = "Hola $email_del_empleado_encontrado,\n\nTu nueva clave de acceso es: $generar_clave\n\nPor favor, cámbiala después de iniciar sesión.\n\n Clave válida durante los próximos 15 minutos.\n\n \n\nGracias.";

                        // Cabeceras del correo
                        $headers = "From: auxiliarti.arpro@somosgrupo-a.com\r\n";
                        $headers .= "Reply-To: auxiliarti.arpro@somosgrupo-a.com\r\n";
                        $headers .= "X-Mailer: PHP/" . phpversion();

                        // Enviar el correo
                        if (mail($email_del_empleado_encontrado, $subject, $message, $headers)) {
                            $_SESSION["mensajes"]["mensaje_exito"] = 'toastr.info("Validando la Información 1")';
                            return $this->redirect('/recuperar-clave-empleado');
                        } else {
                            $_SESSION["mensajes"]["mensaje_exito"] = 'toastr.info("Validando la Información 2")';
                            return $this->redirect('/recuperar-clave-empleado');
                        }
                    } else {
                        $_SESSION["mensajes"]["mensaje_exito"] = 'toastr.info("Validando la Información 3")';
                        return $this->redirect('/recuperar-clave-empleado');
                    }
                } else {
                    $_SESSION["mensajes"]["mensaje_exito"] = 'toastr.info("Validando la Información 4")';
                    return $this->redirect('/recuperar-clave-empleado');
                }

            } else{
                $_SESSION["mensajes"]["mensaje_exito"] = 'toastr.info("Ingrese un Email válido")';
                return $this->redirect('/recuperar-clave-empleado');
            }
        }else {
            $_SESSION["mensajes"]["mensaje_error"] = 'toastr.error("No tienes permisos para acceder")';
            return $this->redirect('/index');
        }
    }
    
}
