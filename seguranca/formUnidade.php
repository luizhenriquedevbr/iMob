<?php

require __DIR__ . '/../vendor/autoload.php';
include __DIR__ . "/../classes/Service.php";

$usuario = Security::getUser()['co_autorizado'];

$service = new Service();
$unidade = $service->listarUnidadeLogin($usuario);

?>

<!DOCTYPE html>

<html style="height: auto; min-height: 100%; background-color: #d2d6de ;">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Sistema de Investigação da Resistência - Login</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.7 -->
      <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
      <link rel="stylesheet" href="dist/css/skins/skin-blue.css">
      <link rel="stylesheet" href="../plugins/iCheck/square/blue.css">
     
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
      <style>
          .disclaimer {
            color:#000;
            position:absolute;
            bottom:100px;
            width:100%;
            text-align:center;
          }
      </style>
    </head>
    <!--class="hold-transition login-page -->
    <body class="login-page" style="height: auto; min-height: 100%;">
      <div class="login-box">
      <br>
      <br>
      <br>
      <br>
      <div id="menu_login">
        <div class="login-logo" style="background-color: #6f5499; margin-bottom: 0px">
        <a href="../seguranca/login.php" style="color: white; font-size: 40px;">sigif2</a>
        </div>
          <div class="login-box-body">
                <p class="login-box-msg"></p>
                <p class="login-box-msg"><?php echo Security::getUser()['nm_aut'];?></p>
                <form action="/classes/Login.php" method="post">
                      <div class="form-group has-feedback">
                        <select name="unidade" id="unidade" class="form-control">
                            <option>Selecione a unidade para continuar...</option>
                            <?php foreach ($unidade as $value): ?>
                              <?php $name = $value['no_unidade']; ?>
                              <option value="<?php echo $value['co_perfil'];?>">
                                <?php if ($value['co_tipo_autorizado'] == 1): ?>
                                    <span><strong>DCCI</strong> - <?php echo $name; ?></span>
                                <?php endif; ?>
                                <?php if ($value['co_tipo_autorizado'] == 2): ?>
                                    <span><strong>Lacen</strong> - <?php echo $name; ?></span>
                                <?php endif; ?>
                                <?php if ($value['co_tipo_autorizado'] == 3): ?>
                                    <span><strong>Unidade de Referência</strong> - <?php echo $name; ?></span>
                                <?php endif; ?>
                                <?php if ($value['co_tipo_autorizado'] == 4): ?>
                                    <span><strong>Sentinela</strong> - <?php echo $name; ?></span>
                                <?php endif; ?>
                                <?php if ($value['co_tipo_autorizado'] == 5): ?>
                                    <span><strong>Coordenação</strong> - <?php echo $name; ?></span>
                                <?php endif; ?>
                              </option>
                            <?php endforeach ?>
                        </select>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                            <button type="button" id="logar" class="btn btn-primary btn-block btn-flat" style="background-color: #6f5499; border-color: #6f5499">Entrar</button>
                        </div>
                        <hr>
                        <div>
                          <p class="login-box-msg small" style="padding-bottom: 10px">Sistema de Investigação da Resistência - MS/SVS/DCCI
                            
                          </p>
                        </div>
                      </div>
                </form>
          </div>
        </div>
<!-- /.login-box -->

<!-- jQuery 3 -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="../plugins/iCheck/icheck.min.js"></script>

        <script src="../dist/js/bootbox.min.js"></script>
        <script language="JavaScript" type="text/JavaScript" src="../dist/js/jquery.maskedinput.min.js"></script>


        <script>

          $(document).ready(function(){

                $("#logar").on("click", function(e){

                    var unidade = $('#unidade').val();

                    if (unidade=='')
                    {
                    bootbox.alert("Favor informar a unidade de acesso");
                    document.getElementById('unidade').focus();
                    return false;
                    }


                        $.ajax({
                        url: 'validaUnidade.php'
                        , type:'post'
                        , data:{unidade:unidade}
                        , dataType:'json'
                        , success:function(xhr) {
                        $(location).attr('href', xhr.url);
                        },
                        error: function(data){
                        var message = JSON.parse(data.responseText).message;

                            bootbox.dialog({
                            message: message,
                            title: "",
                            buttons: {
                            main: {
                            label: "OK",
                            className: "btn-danger"
                            }
                            }
                            });
                        }

                    });

                });

            });

        </script>

    </body>
</html>
