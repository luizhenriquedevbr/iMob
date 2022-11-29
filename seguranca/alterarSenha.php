<?php

require __DIR__ . '/../vendor/autoload.php';

include '../header.php';

?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-lg-6">
                    <h1>Alterar senha</h1>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item active">Alterar senha</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Alterar</h3>
                        </div>
                        <form name="frm_alterarSenha" id="frm_alterarSenha" method="post">
                            <input type="hidden" name="co_cadastro_webinar" id="co_cadastro_webinar" value="<?php echo Security::getUser()['co_cadastro_webinar'];?>">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="senha control-label" class="required">Senha atual</label>
                                            <input type="password" class="form-control" id="senhaAtual" name="senhaAtual">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="novaSenha control-label" class="required">Nova senha</label>
                                            <input type="password" class="form-control" id="novaSenha" name="novaSenha">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="confirmaSenha control-label" class="required">Confirmar senha</label>
                                            <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button name="alterar" id="alterar" class="btn btn-info" type="button">Alterar</button>
                                <button type="button" class="btn btn-danger" onclick="Cancelar();">Limpar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../footer.php'; ?>

<script>

    $('#alterar').click(function () {

        senhaAtual      = $('#senhaAtual').val();
        novaSenha       = $('#novaSenha').val();
        confirmaSenha   = $('#confirmaSenha').val();

        if(senhaAtual.length === 0)
        {
            Swal.fire({
              title: 'Atenção!',
              html: 'Preencha a <strong>senha atual</strong>.',
              icon: 'warning',
              confirmButtonColor: '#337ab7'
          });
            return false;

        }else{
            var response = $.ajax({
                url: 'verificaSenhaAtual.php',
                data: {'senha' : senhaAtual},
                type: 'post',
                async: false
            }).responseJSON;

            if( ! response.data['is_valid']){
                Swal.fire({
                  title: 'Atenção!',
                  html: 'A senha atual não confere.',
                  icon: 'warning',
                  confirmButtonColor: '#337ab7'
              });
                return false;
            }
        }

        if (novaSenha == '' || confirmaSenha == ''){
            Swal.fire({
              title: 'Atenção!',
              html: 'Preencha todos os campos para alterar a senha.',
              icon: 'warning',
              confirmButtonColor: '#337ab7'
          });
            return false;
        }

        if (novaSenha != confirmaSenha){
            Swal.fire({
              title: 'Atenção!',
              html: '<small>Os campos <b>Nova senha</b> e <b>Confirmar senha</b> devem ser iguais.</small>',
              icon: 'warning',
              confirmButtonColor: '#337ab7'
          });
            return false;
        }

        $.ajax({
            url: 'validaSenha.php'
            , type:'post'
            , data: $('#frm_alterarSenha').serialize()
            , success:function(xhr) {
                $(location).attr('href', xhr.url);
                Swal.fire({
                  title: 'Feito!',
                  html: 'Senha alterada com sucesso',
                  icon: 'success',
                  confirmButtonColor: '#337ab7'
              }).then(okay => {
                if (okay) {
                    location.href = 'alterarSenha.php';
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
      location.href = 'alterarSenha.php';
    }

</script>
</html>