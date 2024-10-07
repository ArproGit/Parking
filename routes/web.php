<?php 
use Lib\Route;
use App\Controllers\AHomeController;
use App\Controllers\BEmpleado;


Route::get('/', [AHomeController::class, 'index']);
Route::get('/recuperar-clave-empleado', [AHomeController::class, 'recuperar_clave_empleado']);
Route::post('/ingresar-empleado/iniciar-sesion', [AHomeController::class, 'ingresar_empleado_sesion']);
Route::post('/ingresar-empleado/intentando-recuperar-clave', [AHomeController::class, 'intentando_recuperar_clave']);

Route::get('/panel-empleado', [BEmpleado::class, 'panel_empleado']);
Route::post('/editando/:tipo/:id', [BEmpleado::class, 'accion_editar']);
Route::post('/buscando/:tipo', [BEmpleado::class, 'buscando']);
Route::post('/agregar/:tipo/:id', [BEmpleado::class, 'accion_agregar']);

Route::get('/salir-empleado', [BEmpleado::class, 'salir_empleado']);


Lib\Route::dispatch();