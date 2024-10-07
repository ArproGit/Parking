<?php include "resources/views/0-componentes/header.php"; ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<style>.d-grid {display: grid !important;}</style>
<?php
  $token_1 = \App\Models\Helpers\SecurityHelper::generarTokenCSRF();
  $_SESSION['csrf_token'] = $token_1;
?>
<style>
    body {
      background-color: #000000;
      background-image: url("/../../public/img/estacionamiento.png"); 
      background-attachment: fixed;
      background-size: cover;
      align-items: center;
      display: flex;
      flex-direction: column;
      height: 100vh;
      justify-content: center;
    }
</style>
</head>

<body class="hold-transition">
<div class="login-box">
  <!-- /.login-logos -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= URL_BACK ?>" class="h1"><b><img src="<?= URL_BACK ?>public/img/Logo_45.png" class="" alt="User Image" height="100px"></b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Iniciar sesión como Empleado</p>


      <form method="post" action="/ingresar-empleado/iniciar-sesion" id="demo-form">
        <input type="hidden" name="csrf_token" value="<?= $token_1 ?>">
        <div class="input-group mb-3">
          <input type="email" name="empleado_form" id="empleado_form" class="form-control" placeholder="Correo Empleado">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-at"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password_form" id="password_form" class="form-control" placeholder="Contraseña">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="show-password">
          <label class="form-check-label" for="show-password">Mostrar contraseña</label>
        </div>

        <div class="row pt-3">
          <!-- /.col -->
          <div class="col-12 d-grid ">
            <button  
              data-sitekey="<?= SITE_KEY ?>" 
              data-callback='onSubmit' 
              data-action='submit' type="submit" class="g-recaptcha btn btn-primary btn-block">INGRESAR</button>
          </div>
          <!-- /.col -->

          <div class="text-center mt-4" style="margin: 0 auto;">
            <!-- <p class="mt-3">¿No tienes una cuenta? <strong><a href="vista/registro.php" class="text-[#11126A] font-bold">Regístrate aquí</a></strong></p> -->
            <p>¿Olvidó su contraseña? <strong><a href="<?= URL_FRONT ?>recuperar-clave-empleado" class="text-[#11126A] font-bold">Restablecer contraseña</a></strong></p>
            <p>¿Eres administrador? <strong><a href="<?= URL_BACK ?>" class="text-[#11126A] font-bold">Ingresar</a></strong></p>
          </div>
        </div>
      </form>



      <!-- <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Ingresar using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Ingresar using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= URL_BACK ?>public/js/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= URL_BACK ?>public/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= URL_BACK ?>public/js/dist/adminlte.js"></script>

<script src="<?= URL_BACK ?>public/js/plugins/toastr/toastr.min.js"></script>
<script>
   function onSubmit(token) {
     document.getElementById("demo-form").submit();
   }
 </script>
 <script>
    document.getElementById('password_form').addEventListener('keyup', function(event) {
      var capsLockWarning = document.getElementById('caps-lock-warning');
      if (event.getModifierState('CapsLock')) {
        capsLockWarning.style.display = 'block';
      } else {
        capsLockWarning.style.display = 'none';
      }
    });

    document.getElementById('show-password').addEventListener('change', function() {
      var passwordField = document.getElementById('password_form');
      if (this.checked) {
        passwordField.type = 'text';
      } else {
        passwordField.type = 'password';
      }
    });
  </script>
<?php if (isset($_SESSION["mensajes"]) && !empty($_SESSION["mensajes"])): ?>
  <?php foreach ($_SESSION["mensajes"] as $key => $value) :?>
    <script><?= $value ?></script>
  <?php endforeach; ?>
<?php endif; unset($_SESSION["mensajes"]);  ?>

</body>
</html>
