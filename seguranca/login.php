<?php

include __DIR__ . "/../classes/host.php";
include __DIR__ . "/../funcoes.php";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>iMob</title>
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="/dist/css/adminlte.min.css">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="hold-transition login-page" style="background-color: #d2d6de">
<div class="login-box">
  <div class="login-logo bg-gradient-dark" style="margin-bottom: 0">
    <a href="../seguranca/login.php" style="color: white; font-size: 40px;">iMob</a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Faça seu login para continuar</p>
      <form method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="E-mail" name="ds_email" id="ds_email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Senha" name="senha" id="senha">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3"></div>
        <div class="row">
          <div class="col-12">
            <button type="button" id="logar" class="btn btn-success btn-block btn-flat">Acessar</button>
          </div>
        </div>
        <div class="input-group mb-3"></div>
      </form>

      <br>
      <div class="row">
        <div class="col-12">
          <p class="login-box-msg small" style="padding-bottom: 10px">Sistema iMob
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/dist/js/adminlte.min.js"></script>
<script src="/plugins/inputmask/jquery.inputmask.min.js"></script>

<script>

  $(function () {
    $("#menu_login").hide();
    $("#menu_login").fadeIn(2000);
  });

  $(document).ready(function () {

    $('[data-mask]').inputmask()

    $("#logar").on("click", function (e) {

      var ds_email = $('#ds_email').val();
      var senha = $('#senha').val();

      if (ds_email == '') {
        Swal.fire({
          title: 'Atenção!',
          html: 'Informe o e-mail.',
          icon: 'warning',
          confirmButtonColor: '#337ab7'
        });
        return false;
      }


      if (senha == '') {
        Swal.fire({
          title: 'Atenção!',
          html: 'Informe a senha.',
          icon: 'warning',
          confirmButtonColor: '#337ab7'
        });
        return false;
      }

      $.ajax({
        url: 'valida.php'
        , type: 'post'
        , data: {ds_email: ds_email, senha: senha}
        , dataType: 'json'
        , success: function (xhr) {
          $(location).attr('href', xhr.url);
        },
        error: function (data) {
          var message = JSON.parse(data.responseText).message;

          Swal.fire({
            title: 'Atenção!',
            html: message,
            icon: 'error',
            confirmButtonColor: '#337ab7'
          });
        }

      });

    });

  });
</script>
</body>
</html>
