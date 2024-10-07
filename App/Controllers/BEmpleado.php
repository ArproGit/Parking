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

class BEmpleado extends Controller{
    public function panel_empleado(){
        session_start();
        if (!isset($_SESSION["data_initEmpleado"]) || $_SESSION["data_initEmpleado"]  === NULL) {
            $_SESSION["mensajes"]["mensaje_error"] = 'toastr.error("No tienes permisos para acceder")';
            return $this->redirect('/index');
        }
        $_SESSION['last_activity'] = time();

        return $this->view('1-empleado.0-index');
    }

    public function accion_editar($tipo,$id){
        session_start();
        $data = $_POST;
        if (!isset($_SESSION["data_initEmpleado"]) || $_SESSION["data_initEmpleado"]  === NULL) {
            $_SESSION["mensajes"]["mensaje_error"] = 'toastr.error("No tienes permisos para acceder")';
            return $this->redirect('/index');
        }
        if ($tipo == "editando_mi_perfil") {
            if ($data["clave"] !== "") {
                $hashed_password = password_hash($data["clave"], PASSWORD_DEFAULT);
                $data['clave'] = $hashed_password;
            } else { unset($data["clave"]); }
            try {
                $model = new BEmpleados;  
                $darle_update_al_empleado = $model->update($id, $data);
            } catch (\Exception $e) {$_SESSION['mensaje_error1'] = 'Error: ' . $e->getMessage();}
        
            if ($darle_update_al_empleado) {
                $_SESSION["mensajes"]["mensaje_exito"] = 'toastr.success("Actualización exitosa, verá sus cambios al iniciar sesión nuevamente.")';
            } else {
                $_SESSION["mensajes"]["mensaje_error"] = 'toastr.warning("Hubo un error al intentar crear el registro")';
            }
            return $this->redirect('/panel-empleado');
        }
    }

    public function accion_agregar($tipo,$id){
        session_start();
        if (!isset($_SESSION["data_initEmpleado"]) || $_SESSION["data_initEmpleado"]  === NULL) {
            $_SESSION["mensajes"]["mensaje_error"] = 'toastr.error("No tienes permisos para acceder")';
            return $this->redirect('/index');
        }

        if ($tipo == "reservar_asignacion_temporal") {
            $data = $_POST;
            $numero_parqueadero = $data["idParking"];
            $id_del_parqueadero_encontrado = [];
            try {
                $modelCustom1 = new ELugares;
                $lugar_encontrado = $modelCustom1
                                        ->where('numero_parqueadero', '=', $numero_parqueadero)
                                        ->get();
                $id_del_parqueadero_encontrado = $lugar_encontrado[0]['id'];
            } catch (\Throwable $th) { $lugar_encontrado = []; }

            if ($id_del_parqueadero_encontrado) {
                try {
                    $modelCustom1 = new GAsignacionesTemporales;
                    $asignacion_temporal_encontrada = $modelCustom1
                                                ->where('lugar_id', '=', $id_del_parqueadero_encontrado, 'AND')
                                                ->where('fecha', '=', $data['fechaSeleccionada'], 'AND')
                                                ->get();
                } catch (\Throwable $th) { $asignacion_temporal_encontrada = []; }
                // print '<pre>';
                // var_dump( $asignacion_temporal_encontrada);
                // print '</pre>';
                // die();
                if ($asignacion_temporal_encontrada) {
                    $turnosExistentes = [
                        'manana' => 0,
                        'tarde' => 0,
                        'dia_completo' => 0
                    ];
                
                    foreach ($asignacion_temporal_encontrada as $asignacion) {
                        if (isset($turnosExistentes[$asignacion["turno"]])) {
                            $turnosExistentes[$asignacion["turno"]]++;
                        }
                    }
                
                    if ($turnosExistentes[$data["estado"]] > 0) {
                        echo json_encode(['status' => 'error', 'message' => 'Ya existe una asignación temporal del turno seleccionado para esta fecha en ese lugar']);
                        exit;
                    }
                
                    if ($turnosExistentes['dia_completo'] > 0) {
                        echo json_encode(['status' => 'error', 'message' => 'Ya existe una asignación temporal de día completo para esta fecha en ese lugar']);
                        exit;
                    }
                
                    if ($turnosExistentes['manana'] > 0 && $turnosExistentes['tarde'] > 0) {
                        echo json_encode(['status' => 'error', 'message' => 'Ya existe una asignación temporal de día completo para esta fecha en ese lugar']);
                        exit;
                    }
                
                    if ($data["estado"] === 'dia_completo' && ($turnosExistentes['manana'] > 0 || $turnosExistentes['tarde'] > 0)) {
                        echo json_encode(['status' => 'error', 'message' => 'Ya existe una asignación temporal esta fecha en ese lugar, no es posible asignar día completo']);
                        exit;
                    }
                }
                // try {
                //     $modelCustom3 = new FAsignaciones;
                //     $encontrando_cliente_id = $modelCustom3
                //                             ->where('lugar_id', '=', $data["idParking"])
                //                             ->get();
                //     $id_del_parqueadero_encontrado = $lugar_encontrado[0]['id'];
                // } catch (\Throwable $th) { $encontrando_cliente_id = []; }
                // if ($encontrando_cliente_id) {
                //     $asignando_lugar = [
                //         'lugar_id' => $id_del_parqueadero_encontrado,
                //         'empleado_id' => $encontrando_cliente_id[0]['empleado_id'],
                //         'turno' => $data["estado"],
                //         'fecha' => $data["fechaSeleccionada"],
                //         'tipo_asignacion' => 'empleado'
                //     ];
                // } else {
                $asignando_lugar = [
                    'lugar_id' => $id_del_parqueadero_encontrado,
                    'turno' => $data["estado"],
                    'fecha' => $data["fechaSeleccionada"],
                    'empleado_id' => $id,
                    'tipo_asignacion' => 'Empleado'
                ];
                // }
                // print '<pre>';
                // var_dump( $encontrando_cliente_id);
                // print '</pre>';
                // die();

                try {
                    $model = new GAsignacionesTemporales;
                    $creando_asignacion_fija = $model->create($asignando_lugar);
                } catch (\Exception $e) {
                    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
                    exit;
                }
                
                if ($creando_asignacion_fija) {
                    echo json_encode(['status' => 'success', 'message' => 'Asignación Temporal creada con éxito']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'aHubo un error al intentar crear el registro']);
                }
                exit;
            } else {
                $_SESSION["mensajes"]["mensaje_error"] = 'toastr.warning("Hubo un ERROR al intentar crear el REGISTRO")';
                return $this->redirect('/asignaciones-temporales');
            }
        }
        return $this->redirect('/panel-empleado');
    }

    public function buscando($tipo, $id_empleado=null){
        session_start();
        if (!isset($_SESSION["data_initEmpleado"]) || $_SESSION["data_initEmpleado"]  === NULL) {
            $_SESSION["mensajes"]["mensaje_error"] = 'toastr.error("No tienes permisos para acceder")';
            return $this->redirect('/index');
        }
        // print '<pre>';
        // var_dump( $id_empleado);
        // print '</pre>';
        // die();
        switch ($tipo) {
            case "buscandoasignacionestemporaltes":
                $data = array();
                $fechaConsultada = $_POST["fechaConsultar"];
                $fechas_encontradas = [];
                try {
                    $model2 = new GAsignacionesTemporales;
                    $fechas_encontradas = $model2
                                            ->where('fecha', '=', $fechaConsultada)
                                            ->get();
                } catch (\Exception $e) {$_SESSION['mensaje_error1'] = 'Error: ' . $e->getMessage();}
                
                if ($fechas_encontradas) {
                    foreach ($fechas_encontradas as $key => &$fecha_encontrada) {
                        $buscando_lugar = [];
                        $lugar_id = $fecha_encontrada['lugar_id'];
                        try {
                            $model2 = new ELugares;
                            $buscando_lugar = $model2
                                                    ->find($lugar_id);
                            if ($buscando_lugar) {
                                $fecha_encontrada['nombre_parking'] = $buscando_lugar['numero_parqueadero'];
                            }
                                            
                        } catch (\Exception $e) {$_SESSION['mensaje_error1'] = 'Error: ' . $e->getMessage();}
                    }
                    // print '<pre>';
                    // var_dump( $fechas_encontradas);
                    // print '</pre>';
                    // die();
                    $response = [
                        'status' => 'correcto',
                        'data' => $fechas_encontradas
                    ];
                } else {
                    // Si no hay fechas, devuelve un JSON con el mensaje 'sin_reservas'
                    $response = [
                        'status' => 'sin_reservas'
                    ];
                }
                echo json_encode($response);

                // print '<pre>';
                // var_dump( $fechas_encontradas);
                // print '</pre>';
                // die();
                // echo $respuesta;
                break;
            case "buscandoreservados":
                    try {
                        $model2 = new FAsignaciones;
                        $asignaciones_fijas = $model2 
                                                ->where('compartido', '=', false)
                                                ->get();
                    } catch (\Exception $e) {$_SESSION['mensaje_error1'] = 'Error: ' . $e->getMessage();}
                   
                if( $asignaciones_fijas){
                    foreach ($asignaciones_fijas as $key => &$asignacion_fija) {
                        $buscando_lugar = [];
                        $lugar_id = $asignacion_fija['lugar_id'];
                        try {
                            $model2 = new ELugares;
                            $buscando_lugar = $model2
                                                    ->find($lugar_id);
                            if ($buscando_lugar) {
                                $asignacion_fija['nombre_parking'] = $buscando_lugar['numero_parqueadero'];
                            }
                                            
                        } catch (\Exception $e) {$_SESSION['mensaje_error1'] = 'Error: ' . $e->getMessage();}
                    }
                    // print '<pre>';
                    // var_dump( $lugares_compartidos);
                    // print '</pre>';
                    // die();
                    $response = [
                        'status' => 'correcto',
                        'data' => $asignaciones_fijas
                    ];
                } else {
                    // Si no hay fechas, devuelve un JSON con el mensaje 'sin_reservas'
                    $response = [
                        'status' => 'sin_reservas'
                    ];
                }
                echo json_encode($response);

                // print '<pre>';
                // var_dump( $fechas_encontradas);
                // print '</pre>';
                // die();
                // echo $respuesta;
                break;
            default:
                break;
        }
    }

    public function salir_empleado(){
        session_start();
        if (!isset($_SESSION["data_initEmpleado"]) || $_SESSION["data_initEmpleado"]  === NULL) {
            $_SESSION["mensajes"]["mensaje_error"] = 'toastr.error("No tienes permisos para acceder")';
            return $this->redirect('/index');
        }
        $_SESSION["mensajes"]["mensaje_exito"] = 'toastr.success("Sesión cerrada con éxito")';

        $_SESSION = array();				
        setcookie(session_name(), '', time()-56000);	
        session_destroy();	

        if (URL_FRONT == '') {
            $url = dirname($_SERVER['SCRIPT_NAME']). '/';
            header("Location: {$url}");
            exit();	
        } else{
            $url = URL_FRONT ;
            header("Location: {$url}");
            exit();	
        }	

    }
    
}
