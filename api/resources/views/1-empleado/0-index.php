<?php include "resources/views/0-componentes/header.php"; 
$tipo_vehiculo = isset($_SESSION["data_empleado"]["tipo_vehiculo"]) ? htmlspecialchars($_SESSION["data_empleado"]["tipo_vehiculo"], ENT_QUOTES, 'UTF-8') : '';
if ($tipo_vehiculo == 'carro') {
  $su_vehiculo = '<b class="text-info">Carro <i class="fas fa-car"></i> </b>';
} elseif ($tipo_vehiculo == 'moto') {
  $su_vehiculo = '<b class="text-danger">Moto <i class="fas fa-motorcycle"></i> </b>';
}

?>
<input type="hidden" value="<?= $_SESSION["data_empleado"]["id"] ?>" id="id_empleado">
<input type="hidden" value="<?= $_SESSION["data_empleado"]["seccion_sotano"] ?>" id="seccion_sotano">
<style>
  body {
    background-color: #000000;
    background-image: url("/../../public/img/estacionamiento.png"); 
    background-attachment: fixed;
    background-size: cover;
  }
  .widget-user .widget-user-image>img{
    border: 0px !important;
    margin-top: 15px !important;
    height: auto;
    width: 90px;
  }
  .widget-user .widget-user-header{
    height: 190px !important;
  }
  .bg-manana {
      background: linear-gradient(to bottom, yellow 50%, transparent 50%);
  }

  .bg-manana .text-content i{
      color: black !important;
  }

  .bg-tarde {
      background: linear-gradient(to bottom, transparent 50%, orange 50%);
  }
  .bg-tarde .text-content h5{
      background: linear-gradient(to bottom, transparent 50%, orange 50%);
      color: black !important;
  }

  .bg-libre {
      background-color: green !important;
  }
  .bg-completo {
      background-color: red !important;
  }
  .bg-completo .text-content i, .bg-completo .text-content h5{
      color: black !important;
  }
  .bg-reserva {
      background-color: purple !important;
  }
  .bg-reserva .text-content i, .bg-reserva .text-content h5{ 
    color: white !important;
  }

  .text-content-vehiculo{
    border: 2px solid black;
    background-color: green;
    margin: 2px;
    height: 150px;
    width: 100%;
    display: flex;
    font-size: 30px;
    justify-content:center;
    align-items: center;
  }

  .text-content-vehiculo a .text-content{
    color: white;
  }
</style>

</head>

<body class="hold-transition" >
<div class="" >
  <!-- /.login-logos -->
  <div class="container bg-light-subtle text-light-emphasis col-12 col-md-9" >
    <div class="content">
      <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
          <!-- Widget: user widget style 1 -->
          <div class="card card-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-info">
              <h3 class="widget-user-username"><?= $_SESSION["data_empleado"]["nombre"] ?></h3>
              <h5 class="widget-user-desc mb-5 pb-5"><?= $_SESSION["data_empleado"]["email"] ?>  </h5>
            </div>
            <div class="widget-user-image ">
                <img src="<?= URL_FRONT ?>public/img/Logo_45.png" class="" alt="User Image">
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-sm-6 border-right">
                  <h5>Su Vehículo:</h5>
                  <?= $su_vehiculo ?>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                  <h5>Descripción del Puesto:</h5>
                  <?= $_SESSION["data_empleado"]["puesto"] ?>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
  </div>
  <!-- <div class="row"> -->
    <div class="container bg-light-subtle text-light-emphasis col-12 col-md-9">
        <div class="card card-dark card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="inicio-tab" data-toggle="pill" href="#inicio" role="tab" aria-controls="inicio" aria-selected="true">INICIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="planos-tab" data-toggle="pill" href="#planos" role="tab" aria-controls="planos" aria-selected="true">RESERVAR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="actualizar-tab" data-toggle="pill" href="#actualizar" role="tab" aria-controls="actualizar" aria-selected="true">ACTUALIZAR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL_FRONT ?>salir-empleado">SALIR</a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="custom-tabs-five-tabContent">
                    <div class="bg-transparent tab-pane fade show active" id="inicio" role="tabpanel" aria-labelledby="inicio-tab">
                      <div>
                        <h4 class="">Bienvenido<?php echo isset($_SESSION["data_empleado"]["nombre"]) ? ' '.htmlspecialchars($_SESSION["data_empleado"]["nombre"], ENT_QUOTES, 'UTF-8') : ''; ?>.</h4>
                        <ul>
                          <li>Actualiza, reserva y revisa la disponibildiad de tu lugar.</li>
                          <li>No olvides actualiza tu información.</li>
                          <li>En caso de inconvenientes contactar con la administración.</li>
                        </ul>
                      </div>
                    </div>
                    <div class="bg-transparent tab-pane fade show" id="planos" role="tabpanel" aria-labelledby="planos-tab">
                      <h4 class="text-start mb-3">CONSULTAR DISPONIBILIDAD</h4>
                      <div>

                      
                      <form id="consultar-disponibilidad-sotanos">
                        <div class="row col-12 mb-3" >
                          <div class='col-12 col-md-10  mb-3'>
                            <input type='date' name='fecha-consultar-sotano' id='fecha-consultar-sotano' class='fecha-consultar-sotano form-control' value='' required>
                          </div>

                          <div class='col-12 col-md-2 mb-3 d-grid'>
                            <button type='submit' class='btn bg-dark enviar-consulta' id="">CONSULTAR</button>
                          </div>
                        </div>
                      </form>
                      <div class="row mt-3 text-center">
                        <div class="col-sm-3 bg-libre py-3 text-white">
                          <h5>Disponible</h5>
                        </div>
                        <div class="col-sm-3 bg-tarde py-3 ">
                          <h5>Ocupado Tarde</h5>
                        </div>
                        <div class="col-sm-3 bg-manana py-3 ">
                          <h5>Ocupado Mañana</h5>
                        </div>
                        <div class="col-sm-3 bg-completo py-3 ">
                          <h5>Ocupado Todo el Día</h5>
                        </div>
                        <div class="col-sm-12 bg-reserva py-3 text-white">
                          <h5>Reservado</h5>
                        </div>
                      </div>
                      
                      <div class="contenedor-layout-1-1-2 mb-3"> 
                        <!-- SOTANO 1 1/2 CARROS -->  
                        <div class="grid-overlay-arriba d-none" id="sotano-1-1-2-carro">
                          <h3 class="my-5 text-center">SÓTANO 1 1/2</h3>
                          <div class="col-12 row gap-1" style="display: flex; justify-content: center;">
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="12"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>12</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="14"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>14</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="16"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>16</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="18"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>18</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="20"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>20</h5> 
                                </div> 
                              </a>
                            </div>
                          </div>
                        </div>
                        
                        <!-- SOTANO 1 1/2 MOTOS -->
                        <div class="grid-overlay-abajo d-none" id="sotano-1-1-2-moto">
                          <h3 class="my-5 text-center">SÓTANO 1 1/2</h3>
                          <div class="col-12 row gap-1" style="display: flex; justify-content: center;">
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="46-A"> 
                                <div class="text-content">
                                  <i class="fas fa-motorcycle"></i>
                                  <h5>46-A</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="46-B"> 
                                <div class="text-content">
                                  <i class="fas fa-motorcycle"></i>
                                  <h5>46-B</h5> 
                                </div> 
                              </a>
                            </div>
                          </div>
                          
                          <div class="col-12 row gap-1" style="display: flex; justify-content: center;">
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="46-C"> 
                                <div class="text-content">
                                  <i class="fas fa-motorcycle"></i>
                                  <h5>46-C</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="46-D"> 
                                <div class="text-content">
                                  <i class="fas fa-motorcycle"></i>
                                  <h5>46-D</h5> 
                                </div> 
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>

                      
                      <div class="contenedor-layout-2 mb-3" >   
                        <!-- SOTANO 2 CARROS-->
                        <div class="grid-overlay-arriba  d-none" id="sotano-2-carro">
                          <h3 class="my-5 text-center">SÓTANO 2</h3>
                          <div class="col-12 row gap-1" style="display: flex; justify-content: center;">
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="1"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>1</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="2"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>2</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="3"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>3</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="4"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>4</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="5"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>5</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="6"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>6</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="6"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>7</h5> 
                                </div> 
                              </a>
                            </div>
                          </div>
                        </div>

                        <!-- SOTANO 2 MOTOS -->
                        <div class="grid-overlay-abajo d-none" id="sotano-2-moto">
                          <h3 class="my-5 text-center">SÓTANO 2</h3>
                          <div class="col-12 row gap-1" style="display: flex; justify-content: center;">
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="M1-A"> 
                                <div class="text-content">
                                  <i class="fas fa-motorcycle"></i>
                                  <h5>M1-A</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="M1-B"> 
                                <div class="text-content">
                                  <i class="fas fa-motorcycle"></i>
                                  <h5>M1-B</h5> 
                                </div> 
                              </a>
                            </div>
                          </div>
                          <div class="col-12 row gap-1" style="display: flex; justify-content: center;">
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="M2-A"> 
                                <div class="text-content">
                                  <i class="fas fa-motorcycle"></i>
                                  <h5>M2-A</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="M2-B"> 
                                <div class="text-content">
                                  <i class="fas fa-motorcycle"></i>
                                  <h5>M2-B</h5> 
                                </div> 
                              </a>
                            </div>
                          </div>
                          <div class="col-12 row gap-1" style="display: flex; justify-content: center;">
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="M3-A"> 
                                <div class="text-content">
                                  <i class="fas fa-motorcycle"></i>
                                  <h5>M3-A</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="M3-B"> 
                                <div class="text-content">
                                  <i class="fas fa-motorcycle"></i>
                                  <h5>M3-B</h5> 
                                </div> 
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                      

                      <!-- SOTANO 2 1/2 CARROS-->
                      <div class="contenedor-layout-2 mb-3 d-none" id="sotano-2-1-2-carro"> 
                        <h3 class="my-5 text-center">SÓTANO 2 1/2</h3>  
                        <div class="grid-overlay-arriba" style="display: flex; justify-content: center;">
                          <div class="col-12 row gap-1">
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="17"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>17</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="18"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>18</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="19"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>19</h5> 
                                </div> 
                              </a>
                            </div>
                            <div class="col-md-2 col-6 text-center text-content-vehiculo">
                              <a href="#" class="asignarPosicion" data-toggle="modal" data-target="#asignarPosicion" tipoTurno="" idParking="20"> 
                                <div class="text-content">
                                  <i class="fas fa-car"></i>
                                  <h5>20</h5> 
                                </div> 
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Modal para Asignar Posición -->
                      <div class='modal fade' id='asignarPosicion'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header bg-primary'>
                                <h4 class='modal-title'>¿Asignar Parqueadero?</h4>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                                </div>
                                <form action='agregar/reservar_asignacion_temporal/<?= $_SESSION["data_empleado"]["id"] ?>' method='post'>
                                    <div class='modal-body'>

                                      <div class="row col-12">
                                        <div class='col-12 col-md-12  mb-3'>
                                          <label for='estado' class='form-label'>Turno:</label>
                                          <select id="turno_seleccionado" name="estado" class="estado form-control" required>
                                            <option value='manana'>Mañana</option>
                                            <option value='tarde'>Tarde</option>
                                            <option value='dia_completo'>Día Completo</option>
                                          </select>
                                        </div>
                                      </div>

                                      <div class="row col-12">
                                        <div class='col-12 col-md-6  mb-3'>
                                            <label for='fecha_recibido' class='form-label'>Desde:</label>
                                            <div class="input-group date" id="reservationDesde" data-target-input="nearest">
                                                <input type="text" name="reservationDesde" class="form-control datetimepicker-input" id='fecha_desde' data-target="#reservationDesde" disabled/>
                                                <div class="input-group-append" data-target="#reservationDesde" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-12 col-md-6  mb-3'>
                                            <label for='fecha_recibido' class='form-label'>Hasta:</label>
                                            <div class="input-group date" id="reservationHasta" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" id='fecha_hasta' data-target="#reservationHasta" disabled/>
                                                <div class="input-group-append" data-target="#reservationHasta" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id='fecha_seleccionada_form'>
                                    </div>

                                    </div>

                                    <div class='modal-footer justify-content-between'>
                                        <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
                                        <button type='submit' class='btn bg-primary'>Asignar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                      </div>

                      </div>
                    </div>
                    <div class="bg-transparent tab-pane fade show" id="actualizar" role="tabpanel" aria-labelledby="actualizar-tab">
                      <div class="content">
                        <h4 class="">ACTUALIZAR SU INFORMACIÓN</h4>
                        <form action='/editando/editando_mi_perfil/<?= $_SESSION["data_empleado"]["id"] ?>' method='post' id='editarFormEmpleado'>
                            <div class='modal-body'>
                              <div class="row col-12">
                                <div class='col-12 col-md-6  mb-3'>
                                  <label for='nombre_del_empleado' class='form-label'>Actualizar su Nombre Completo:</label>
                                  <input type='text' name='nombre' id='' class='nombre_del_empleado form-control' placeholder='Actualizar su Nombre completo' value='<?php echo isset($_SESSION["data_empleado"]["nombre"]) ? htmlspecialchars($_SESSION["data_empleado"]["nombre"], ENT_QUOTES, 'UTF-8') : ''; ?>'>
                                </div>
                                <div class='col-12 col-md-6  mb-3'>
                                  <label for='email_del_empleado' class='form-label'>Actualizar su Email:</label>
                                  <input type='email' name='email' id='' class='email_del_empleado form-control' placeholder='Actualizar su Email' value='<?php echo isset($_SESSION["data_empleado"]["email"]) ? htmlspecialchars($_SESSION["data_empleado"]["email"], ENT_QUOTES, 'UTF-8') : ''; ?>''>
                                </div>
                              </div>
                              <div class="row col-12">
                                <div class='col-12 col-md-6  mb-3'>
                                  <label for='telefono' class='form-label'>Actualizar su Telefono:</label>
                                  <input type='number' name='telefono' id='' class='telefono_empleado form-control' placeholder='Actualizar su Teléfono' value='<?php echo isset($_SESSION["data_empleado"]["telefono"]) ? htmlspecialchars($_SESSION["data_empleado"]["telefono"], ENT_QUOTES, 'UTF-8') : ''; ?>' required>
                                  <p class='mt-1'>*Ingresar solo el área y el número. <br>+57 viene por defecto.</p>
                                </div>
                                <div class='mb-3 col-12 col-md-6'>
                                    <label for='clave' class='form-label'>Actualizar su Contraseña:</label>
                                    <input type='text' name='clave' id='clave' class='form-control' placeholder='Actualizar su Contraseña' value=''>
                                    <p class='mt-1'>*Si desea actualizar la contraseña, rellene el campo. <br>De lo contrario déjelo vacío.</p>
                                </div>
                              </div>
                              <div class="row col-12">
                                <div class='col-12 col-md-12  mb-3'>
                                  <label for='puesto' class='form-label'>Actualizar Referencia de su Parqueadero:</label>
                                  <textarea name="puesto" id="" rows="2" class="puesto form-control" placeholder='Actualizar su referencia del puesto de Parqueadero'><?php echo isset($_SESSION["data_empleado"]["puesto"]) ? htmlspecialchars($_SESSION["data_empleado"]["puesto"], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
                                </div>
                              </div>
                            </div>
                            <div class='modal-footer justify-content-end'>
                                <button type='submit' class='btn bg-primary'>ACTUALIZAR</button>
                            </div>
                        </form>
                      </div>
                      
                    </div>
                </div>
            </div>
        </div>
      
    <!-- </div>
 </div> 
 </div>  -->

<!-- jQuery -->
<script src="<?= URL_BACK ?>public/js/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= URL_BACK ?>public/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= URL_BACK ?>public/js/dist/adminlte.js"></script>

<script src="<?= URL_BACK ?>public/js/plugins/toastr/toastr.min.js"></script>
<script src="<?= URL_BACK ?>public/plugins/moment/moment.min.js"></script> 
<script src="<?= URL_BACK ?>public/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?= URL_BACK ?>public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js"></script> 

<script>
      function getCurrentDate() {
        var now = new Date();
        var year = now.getFullYear();
        var month = ("0" + (now.getMonth() + 1)).slice(-2); // +1 porque getMonth() es 0-indexado
        var day = ("0" + now.getDate()).slice(-2);
    
        return year + "-" + month + "-" + day;
    }
    
    // Usar la función para crear el objeto con la fecha actual
    var fechaConsultar = getCurrentDate();
    
    var fecha = {
        fechaConsultar: fechaConsultar
    };
  $.ajax({
      url: '/buscando/buscandoasignacionestemporaltes/', 
      type: 'POST',
      data: fecha,
      success: function(response) {
        var mensaje = JSON.parse(response);

        if(mensaje.status === "sin_reservas"){
          var parkingLugares = ['12', '14', '16', '18','20', '46-A', '46-B','46-C','46-D', '1', '2', '3', '4', '5', '6', '7', 'M1-A', 'M1-B', 'M2-A','M2-B', 'M3-A','M3-B', '17','18','19','20'];
          parkingLugares.forEach(function(idParking) {
              var parkingSpot = $('a[idParking="' + idParking + '"]').parent();
              var parkingLink = parkingSpot.find('a');
              parkingSpot.removeClass('bg-manana bg-tarde bg-completo');
              parkingLink.css({
                  'color': '',
                  'cursor': ''
              });
              parkingLink.attr('data-target', '#asignarPosicion');
              parkingLink.off('click');
          });
          buscandoReservados();
          toastr.info("Sin reservas para esta Fecha");
        } else if (mensaje.status === "correcto") {
          var parkingLugares = ['12', '14', '16', '18','20', '46-A', '46-B','46-C','46-D', '1', '2', '3', '4', '5', '6', '7', 'M1-A', 'M1-B', 'M2-A','M2-B', 'M3-A','M3-B', '17','18','19','20'];
          parkingLugares.forEach(function(idParking) {
              var parkingSpot = $('a[idParking="' + idParking + '"]').parent();
              var parkingLink = parkingSpot.find('a');
              parkingSpot.removeClass('bg-manana bg-tarde bg-completo');
              parkingLink.css({
                  'color': '',
                  'cursor': ''
              });
              parkingLink.attr('data-target', '#asignarPosicion');
              parkingLink.off('click');
          });

          // Agrupar las reservas por nombre_parking
          var reservasPorParking = {};

          mensaje.data.forEach(function(reserva) {
              if (!reservasPorParking[reserva.nombre_parking]) {
                  reservasPorParking[reserva.nombre_parking] = [];
              }
              reservasPorParking[reserva.nombre_parking].push(reserva);
          });

          // Procesar las reservas agrupadas
          Object.keys(reservasPorParking).forEach(function(nombre_parking) {
              var reservas = reservasPorParking[nombre_parking];
              var tieneManana = reservas.some(function(reserva) { return reserva.turno === 'manana'; });
              var tieneTarde = reservas.some(function(reserva) { return reserva.turno === 'tarde'; });
              var tieneDiaCompleto = reservas.some(function(reserva) { return reserva.turno === 'dia_completo'; });

              // Obtener el elemento del parking spot
              var parkingSpot = $('a[idParking="' + nombre_parking + '"]').parent();
              var parkingLink = parkingSpot.find('a');

              if (tieneDiaCompleto || (tieneManana && tieneTarde)) {
                  // Si tiene el turno "dia_completo" o ambos turnos "manana" y "tarde"
                  parkingSpot.addClass('bg-completo');
                  parkingLink.attr('tipoTurno', 'dia_completo');
                  parkingLink.removeAttr('data-target');
                  parkingLink.css({
                      'color': 'black',
                      'cursor': 'default'
                  });
                  parkingLink.on('click', function(e) {
                      e.preventDefault();
                  });
              } else {
                  // Inicializar una variable para rastrear si se encontró alguna coincidencia
                  let foundMatch = false;

                  // Aplicar estilos según el turno correspondiente
                  reservas.forEach(function(reserva) {
                      if (reserva.turno === "manana") {
                          parkingSpot.addClass('bg-manana');
                          parkingLink.attr('tipoTurno', 'manana');
                          foundMatch = true;
                      } else if (reserva.turno === "tarde") {
                          parkingSpot.addClass('bg-tarde');
                          parkingLink.attr('tipoTurno', 'tarde');
                          foundMatch = true;
                      }
                  });

                  // Si no se encontró ninguna coincidencia, habilitar todas las opciones
                  if (!foundMatch) {
                      parkingSpot.addClass('bg-all');
                      parkingLink.attr('tipoTurno', 'all');
                  }
              }
          });
          buscandoReservados();
          toastr.success("Consulta realizada correctamente");
        }
      },
      error: function(xhr, status, error) {

          // console.error('Error en la solicitud AJAX:', status, error);
          // $('#result').html('<div class="alert alert-danger">Ocurrió un error al realizar la consulta.</div>');
      }
  });

</script>
<script>
  $(document).on('click', '.asignarPosicion', function() {
      var tipoTurno = $(this).attr('tipoTurno');
      var idParking = $(this).attr('idParking');
    
      $('#asignarPosicion').find('form').append('<input type="hidden" name="idParking" value="' + idParking + '">');
      var fechaConsultar = $('#consultar-disponibilidad-sotanos #fecha-consultar-sotano').val();
              
      $('#asignarPosicion #fecha_seleccionada_form').val(fechaConsultar);
      actualizarFechas(fechaConsultar);
      var turnoSelect = $('#turno_seleccionado');
      turnoSelect.find('option').prop('disabled', false);
      
        if (tipoTurno === "manana") {
            turnoSelect.find('option[value="dia_completo"]').prop('disabled', true);
            turnoSelect.find('option[value="manana"]').prop('disabled', true);
            turnoSelect.find('option[value="tarde"]').prop('disabled', false);
            turnoSelect.val('tarde'); 
        } else if (tipoTurno === "tarde") {
            turnoSelect.find('option[value="dia_completo"]').prop('disabled', true);
            turnoSelect.find('option[value="tarde"]').prop('disabled', true);
            turnoSelect.find('option[value="manana"]').prop('disabled', false);
            turnoSelect.val('manana'); 
        } else if (tipoTurno === "dia_completo") {
          turnoSelect.find('option').prop('disabled', true); 
      }

      
  });

  $('#asignarPosicion form').on('submit', function(e) {
      e.preventDefault();
      var fechaSeleccionada = $('#fecha_seleccionada_form').val();

      $(this).append('<input type="hidden" name="fechaSeleccionada" value="' + fechaSeleccionada + '">');

      var formData = $(this).serialize();

      $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              toastr.success('Recargando en 3 Segundos');
              toastr.success(response.message);
              setInterval(function() {
                  location.reload();
              }, 3000);
            } else {
              toastr.info(response.message);
            }
          },
          error: function(xhr, status, error) {
            toastr.error('Hubo un error al intentar crear el registro');
          }
      });
  });

  $(function () {
    var today = new Date();
    var yyyy = today.getFullYear();
    var mm = String(today.getMonth() + 1).padStart(2, '0'); 
    var dd = String(today.getDate()).padStart(2, '0');

    var currentDate = yyyy + '-' + mm + '-' + dd;
    $('#asignarPosicion #fecha_seleccionada_form').val(currentDate);
    $('#consultar-disponibilidad-sotanos #fecha-consultar-sotano').val(currentDate);

    function setDefaultDates() {
      var today = moment().startOf('day');
      var defaultFromTime = today.clone().hour(7).minute(0);
      var defaultToTime = today.clone().hour(11).minute(59);

      $('#reservationDesde').datetimepicker({
        defaultDate: defaultFromTime,
        format: 'YYYY-MM-DD HH:mm',
        icons: { time: 'far fa-clock' }
      });
      
      $('#reservationHasta').datetimepicker({
        defaultDate: defaultToTime,
        format: 'YYYY-MM-DD HH:mm',
        icons: { time: 'far fa-clock' },
        useCurrent: false 
      });
    }

    function updateDateTimePicker(turno) {

      // var today = moment().startOf('day');
      var today = $('#consultar-disponibilidad-sotanos #fecha-consultar-sotano').val();
      if (turno === 'manana') {
        $('#reservationDesde').datetimepicker('date', today.clone().hour(7).minute(0));
        $('#reservationHasta').datetimepicker('date', today.clone().hour(11).minute(59));
      } else if (turno === 'tarde') {
        $('#reservationDesde').datetimepicker('date', today.clone().hour(12).minute(0));
        $('#reservationHasta').datetimepicker('date', today.clone().hour(21).minute(0));
      } else if (turno === 'dia_completo') {
        $('#reservationDesde').datetimepicker('date', today.clone().hour(7).minute(0));
        $('#reservationHasta').datetimepicker('date', today.clone().hour(21).minute(0));
      }
    }

    setDefaultDates();

    $('#asignarPosicion #turno_seleccionado').change(function() {
      var selectedTurno = $(this).val();
      updateDateTimePicker(selectedTurno);
    });
  });

  function buscandoReservados() {
    $.ajax({
      url: '/buscando/buscandoreservados/', 
      type: 'POST',
      success: function(response) {
        var mensaje = JSON.parse(response);

        if (mensaje.status === "correcto") {
          var parkingLugares = ['12', '14', '16', '18', '20', '46-A', '46-B', '46-C', '46-D', '1', '2', '3', '4', '5', '6', '7', 'M1-A', 'M1-B', 'M2-A', 'M2-B', 'M3-A', 'M3-B', '17', '18', '19', '20'];
          // Recorrer los datos de reservas
          mensaje.data.forEach(function(reserva) {
            if (parkingLugares.includes(reserva.nombre_parking)) {
              // Obtener el elemento del parking spot
              var parkingSpot = $('a[idParking="' + reserva.nombre_parking + '"]').parent();
              var parkingLink = parkingSpot.find('a');

              // Agregar la clase 'bg-reserva' al padre y 'bg-completo' al link
              parkingSpot.addClass('bg-reserva');
              parkingLink.removeAttr('data-target');
              // Bloquear la selección del elemento <a>
              parkingLink.attr('data-target', '');
              parkingLink.css({
                  'color': 'black',
                  'cursor': 'default'
              });
              parkingLink.on('click', function(e) {
                  e.preventDefault();
              });
            }
          });
        }
      },
      error: function(xhr, status, error) {

      }
    });
  }
</script> 
<script>
    $('#consultar-disponibilidad-sotanos .enviar-consulta').on('click', function(e) {
        e.preventDefault();

        
        var fechaConsultar = $('#consultar-disponibilidad-sotanos #fecha-consultar-sotano').val();
        
        $('#asignarPosicion #fecha_seleccionada_form').val(fechaConsultar);
        var fecha = {
          fechaConsultar: fechaConsultar,
        };
        $.ajax({
            url: '/buscando/buscandoasignacionestemporaltes/', 
            type: 'POST',
            data: fecha,
            success: function(response) {
              
              actualizarFechas(fechaConsultar);
              var mensaje = JSON.parse(response);

              if(mensaje.status === "sin_reservas"){
                var parkingLugares = ['12', '14', '16', '18','20', '46-A', '46-B','46-C','46-D', '1', '2', '3', '4', '5', '6', '7', 'M1-A', 'M1-B', 'M2-A','M2-B', 'M3-A','M3-B', '17','18','19','20'];
                parkingLugares.forEach(function(idParking) {
                    var parkingSpot = $('a[idParking="' + idParking + '"]').parent();
                    var parkingLink = parkingSpot.find('a');
                    parkingSpot.removeClass('bg-manana bg-tarde bg-completo');
                    parkingLink.css({
                        'color': '',
                        'cursor': ''
                    });
                    parkingLink.attr('data-target', '#asignarPosicion');
                    parkingLink.off('click');
                    parkingSpot.addClass('bg-all');
                    parkingLink.attr('tipoTurno', 'all');
                    console.log('SIN RESERVAS');
                });
                buscandoReservados();
                toastr.info("Sin reservas para esta Fecha");
              } else if (mensaje.status === "correcto") {
                var parkingLugares = ['12', '14', '16', '18','20', '46-A', '46-B','46-C','46-D', '1', '2', '3', '4', '5', '6', '7', 'M1-A', 'M1-B', 'M2-A','M2-B', 'M3-A','M3-B', '17','18','19','20'];
                parkingLugares.forEach(function(idParking) {
                    var parkingSpot = $('a[idParking="' + idParking + '"]').parent();
                    var parkingLink = parkingSpot.find('a');
                    parkingSpot.removeClass('bg-manana bg-tarde bg-completo');
                    parkingLink.css({
                        'color': '',
                        'cursor': ''
                    });
                    parkingLink.attr('data-target', '#asignarPosicion');
                    parkingLink.off('click');
                    parkingSpot.addClass('bg-all');
                    parkingLink.attr('tipoTurno', 'all');
                });

                // Agrupar las reservas por nombre_parking
                var reservasPorParking = {};

                mensaje.data.forEach(function(reserva) {
                    if (!reservasPorParking[reserva.nombre_parking]) {
                        reservasPorParking[reserva.nombre_parking] = [];
                    }
                    reservasPorParking[reserva.nombre_parking].push(reserva);
                });

                // Procesar las reservas agrupadas
                Object.keys(reservasPorParking).forEach(function(nombre_parking) {
                    var reservas = reservasPorParking[nombre_parking];
                    var tieneManana = reservas.some(function(reserva) { return reserva.turno === 'manana'; });
                    var tieneTarde = reservas.some(function(reserva) { return reserva.turno === 'tarde'; });
                    var tieneDiaCompleto = reservas.some(function(reserva) { return reserva.turno === 'dia_completo'; });

                    // Obtener el elemento del parking spot
                    var parkingSpot = $('a[idParking="' + nombre_parking + '"]').parent();
                    var parkingLink = parkingSpot.find('a');
                    if (tieneDiaCompleto || (tieneManana && tieneTarde)) {
                        // Si tiene el turno "dia_completo" o ambos turnos "manana" y "tarde"
                        parkingSpot.addClass('bg-completo');
                        parkingLink.attr('tipoTurno', 'dia_completo');
                        parkingLink.removeAttr('data-target');
                        parkingLink.css({
                            'color': 'black',
                            'cursor': 'default'
                        });
                        parkingLink.on('click', function(e) {
                            e.preventDefault();
                        });
                    } else {
                        // Inicializar una variable para rastrear si se encontró alguna coincidencia
                        let foundMatch = false;

                        // Aplicar estilos según el turno correspondiente
                        reservas.forEach(function(reserva) {
                            if (reserva.turno === "manana") {
                                parkingSpot.addClass('bg-manana');
                                parkingLink.attr('tipoTurno', 'manana');
                                foundMatch = true;
                            } else if (reserva.turno === "tarde") {
                                parkingSpot.addClass('bg-tarde');
                                parkingLink.attr('tipoTurno', 'tarde');
                                foundMatch = true;
                            }
                        });

                        // Si no se encontró ninguna coincidencia, habilitar todas las opciones
                        if (!foundMatch) {
                            parkingSpot.addClass('bg-all');
                            parkingLink.attr('tipoTurno', 'all');
                        }
                    }
                });
                buscandoReservados();
                toastr.success("Consulta realizada correctamente");
              }
            },
            error: function(xhr, status, error) {

                
            }
        });


        
    });

    function actualizarFechas(fecha) {
      var today = moment(fecha).startOf('day');
      var defaultFromTime = today.clone().hour(7).minute(0);
      var defaultToTime = today.clone().hour(11).minute(59);
      $('#reservationDesde').datetimepicker('date', defaultFromTime);
      $('#reservationHasta').datetimepicker('date', defaultToTime);
    }
</script>
<script>
        // toastr.options = {
        //   "timeOut": "10000", // 10 segundos
        //   "extendedTimeOut": "1000" // 1 segundo extra
        // };
        toastr.options = {"timeOut": "0","extendedTimeOut": "0","closeButton": true };
</script>
<script>
  $(document).ready(function(){
      // Obtener el valor del input
      var seccion = $('#seccion_sotano').val();
      
      // Seleccionar el div con el id correspondiente y quitarle la clase d-none
      $('#' + seccion).removeClass('d-none');
  });
</script>
<?php if (isset($_SESSION["mensajes"]) && !empty($_SESSION["mensajes"])): ?>
  <?php foreach ($_SESSION["mensajes"] as $key => $value) :?>
    <script><?= $value ?></script>
  <?php endforeach; ?>
<?php endif; unset($_SESSION["mensajes"]);  ?>
</body>
</html>
