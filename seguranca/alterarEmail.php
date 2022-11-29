<?php

require __DIR__ . '/../vendor/autoload.php';


    $now = new DateTime();
    $autorizado = new Autorizado();

    $co_autorizado = Security::getUser()['co_autorizado'];

    $form  = $autorizado->buscarEmail($co_autorizado);

    $emailAtual = $form["ds_email"];
        
?>

<style>

.required:after {
            content: " *";
            color: red;
        }

        legend {
            text-align: center;
            background-color: rgba(128, 128, 128, 0.5098039215686274);
        }

        label:not(.checkbox-inline):not(.radio-inline):not(.no-bold):not(.no-highlight){
            background-color: rgba(128, 128, 128, 0.25098039215686274);
            width: 100%;
        }

        /* Alinhamento do checkbox a esquerda, não remover. https://stackoverflow.com/questions/15975968/twitter-bootstrap-inline-checkbox-alignment-issue */
        .checkbox-inline,
        .checkbox-inline+.checkbox-inline {
          margin-left: 0;
          margin-right: 10px;
        }
        .checkbox-inline:last-child {
          margin-right: 0;
        }

        .radio-inline,
        .radio-inline+.radio-inline {
          margin-left: 0;
          margin-right: 10px;
        }
        .radio-inline:last-child {
          margin-right: 0;
        }
        .swal2-container {
          zoom: 1.5;
        }
</style>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="../bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/skin-blue.css">
    <link rel="stylesheet" href="../bower_components/morris.js/morris.css">
    <link rel="stylesheet" href="../bower_components/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="../bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
    <section class="content-header">
        <h1>
            Alterar E-mail
        </h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard.php" data-ajax="false"><i class="fa fa-home"></i>Página Principal</a></li>
            <li class="active">Alterar e-mail</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <form name="frm_alterarEmail" id="frm_alterarEmail" method="post">
                    <input type="hidden" name="co_autorizado" id="co_autorizado" value="<?php echo Security::getUser()['co_autorizado'];?>">
                    <div class="panel-group">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="email control-label" class="required">E-mail atual</label>
                                        <input type="text" class="form-control" id="emailAtual" name="emailAtual" value="<?=$emailAtual?>" readonly>
                                    </div>
                                </div>
                             </div>
                            <div class="row">
                                <div class="col-xs-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="novoEmail control-label" class="required">Novo e-mail</label>
                                        <input type="text" class="form-control" id="novoEmail" name="novoEmail">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="confirmaEmail control-label" class="required">Confirmar e-mail</label>
                                        <input type="text" class="form-control" id="confirmaEmail" name="confirmaEmail">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="col-xs-12 col-lg-4" style="text-align: right;">
                            <button type="button" class="btn btn-danger" onclick="Cancelar();">Limpar</button>
                            <button name="alterar" id="alterar" class="btn btn-success" type="button">Alterar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>

        $('#alterar').click(function () {

            emailAtual      = $('#emailAtual').val();
            novoEmail       = $('#novoEmail').val();
            confirmaEmail   = $('#confirmaEmail').val();

            if (novoEmail == '' || confirmaEmail == ''){
                Swal.fire({
                  title: 'Atenção!',
                  html: 'Preencha todos os campos para alterar o e-mail.',
                  icon: 'warning',
                  confirmButtonColor: '#337ab7'
                });
                return false;
            }

            if (novoEmail != confirmaEmail){

                Swal.fire({
                  title: 'Atenção!',
                  html: '<small>Os campos <b>Novo e-mail</b> e <b>Confirmar e-mail</b> devem ser iguais.</small>',
                  icon: 'warning',
                  confirmButtonColor: '#337ab7'
                });
                return false;
            }

            $.ajax({
                url: 'seguranca/validaEmail.php'
                , type:'post'
                , data: $('#frm_alterarEmail').serialize()
                , success:function(xhr) {
                    $(location).attr('href', xhr.url);
                    Swal.fire({
                        title: 'E-mail alterado com sucesso.',
                        html: 'A alteração será visualizada após novo acesso ao sistema.',
                        icon: 'success',
                        confirmButtonColor: '#337ab7'
                    }).then(okay => {
                        if (okay) {
                            redirectTo("seguranca/alterarEmail.php");
                        }
                    });
                },
                error: function(xhr){
                    alert(JSON.parse(xhr.responseText).message);
                }
            });
        });

        function Cancelar()
        {
              redirectTo("seguranca/alterarEmail.php");
        }

    </script>
</html>