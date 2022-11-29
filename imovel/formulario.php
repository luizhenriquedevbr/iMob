<?php

header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/../vendor/autoload.php';

$imovel = new Imovel();

$co_imovel = isset($_GET["co_imovel"]) ? $_GET["co_imovel"] : null;

$no_imovel = "";
$ds_endereco = "";
$tp_imovel = "";
$st_situacao = "";
$dt_repasse = "";
$status = "";

if ($co_imovel != "") {

  $form = $imovel->buscarImovel($co_imovel);
  $ds_endereco = $form["ds_endereco"];
  $dt_repasse = $form["dt_repasse"];
  $tp_imovel = $form["tp_imovel"];
  $st_situacao = $form["st_situacao"];
  $status = $form["status"];

}

include '../header.php';

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-lg-6">
          <h1 class="m-0">Imovel</h1>
        </div><!-- /.col -->
        <div class="col-lg-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../principal.php">Início</a></li>
            <li class="breadcrumb-item"><a href="/imovel/index.php">Imovel</a></li>
            <li class="breadcrumb-item active">Formulário</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-orange card-outline">
            <div class="card-header">
              <?php if (empty($co_imovel)): ?>
                <h3 class="card-title">Cadastrar</h3>
              <?php else: ?>
                <h3 class="card-title">Alterar</h3>
              <?php endif; ?>
            </div>
            <form id="formImovel" name="formImovel" method="post">
              <input type="hidden" name="co_imovel" id="co_imovel" value="<?php echo $co_imovel ?>">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-10">
                    <div class="form-group">
                      <label class="required">Endereço</label>
                      <input type="text" class="form-control" name="ds_endereco" id="ds_endereco"
                             value="<?php echo $ds_endereco ?>">
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="form-group">
                      <label class="required">Dia do Repasse</label>
                      <input type="text" class="form-control" name="dt_repasse" id="dt_repasse"
                             value="<?php echo $dt_repasse ?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="required">Tipo</label>
                      <div class="form-group">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" id="tp_imovel" name="tp_imovel"
                                 value="1" <? if ($tp_imovel == '1') echo 'checked' ?>>
                          <label class="form-check-label">Apartamento</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" id="tp_imovel" name="tp_imovel"
                                 value="2" <? if ($tp_imovel == '2') echo 'checked' ?>>
                          <label class="form-check-label">Casa</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="required">Situação</label>
                      <div class="form-group">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" id="st_situacao" name="st_situacao"
                                 value="1" <? if ($st_situacao == '1') echo 'checked' ?>>
                          <label class="form-check-label">Disponível</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" id="st_situacao" name="st_situacao"
                                 value="2" <? if ($st_situacao == '2') echo 'checked' ?>>
                          <label class="form-check-label">Ocupado</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="required">Status</label>
                      <div class="form-group">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" id="status" name="status" value="1"
                                 <?php if ($status && $co_imovel): ?>checked<?php endif; ?>>
                          <label class="form-check-label">Ativo</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" id="status" name="status" value="0"
                                 <?php if (!$status && $co_imovel): ?>checked<?php endif; ?>>
                          <label class="form-check-label">Inativo</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <?php if (empty($co_imovel)): ?>
                  <button type="button" class="btn btn-sm btn-success" onclick="validar();" data-save-type="salvar">
                    Salvar
                  </button>
                <?php else: ?>
                  <button type="button" class="btn btn-sm btn-success" onclick="validar();" data-save-type="salvar">
                    Alterar
                  </button>
                <?php endif; ?>
                <button type="button" class="btn btn-sm btn-danger" onclick="Cancelar();">Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
</section>
</div>

<?php include __DIR__ . '/../footer.php'; ?>

<script>

  function Cancelar() {
    location.href = 'index.php';
  }

  var Validator = {
    setError: function (element, message) {
      var $divInput = $(element).parent();
      $divInput.addClass('has-error');
      $divInput.find('.form-control-feedback').remove();

      $divInput.append('<div class="form-control-feedback text-danger">' + message + '<br></div>');
    },
    clearFormErrors: function (form) {
      $(form)
        .find('.has-error')
        .removeClass('has-error')
        .find('.form-control-feedback')
        .remove()
      ;
    },
    setFormError: function (errors) {
      errors.forEach(function (element) {
        Validator.setError(element.input, element.message);
      });
    }
  };

  var toggleSubmitButton = function (form, disabled) {
    $(form).find('button').attr('disabled', disabled);
  };

  function validar($form) {

    var errors = [];

    if ($('#no_imovel').val() == '') {
      errors.push({input: $('#no_imovel'), message: ['Campo de preenchimento obrigatório.']});
    }

    if ($('#ds_endereco').val() == '') {
      errors.push({input: $('#ds_endereco'), message: ['Campo de preenchimento obrigatório.']});
    }

    if($("[name='tp_imovel']").filter(':checked').length === 0){
      errors.push({input: $("[name='tp_imovel']").first().parent(), message: ['Campo de preenchimento obrigatório.']});
    }

    if($("[name='st_situacao']").filter(':checked').length === 0){
      errors.push({input: $("[name='st_situacao']").first().parent(), message: ['Campo de preenchimento obrigatório.']});
    }

    if($("[name='status']").filter(':checked').length === 0){
      errors.push({input: $("[name='status']").first().parent(), message: ['Campo de preenchimento obrigatório.']});
    }

    Validator.clearFormErrors($("#formImovel"));

    if (errors.length > 0) {

      console.log(errors);

      Swal.fire({
        title: 'Atenção!',
        html: 'Existem campos obrigatórios não preenchidos.',
        icon: 'warning',
        confirmButtonColor: '#337ab7'
      });

      Validator.setFormError(errors);
      getFormErrors();
      return false;
    }

    salvar();
    //return true;
  }

  function salvar() {
    var $form = $("#formImovel");
    let formData = $form.serializeArray();

    $.ajax({
      url: 'gravaImovel.php',
      type: 'POST',
      data: $.param(formData),
      beforeSend: function () {
        toggleSubmitButton($form, true);
      },
      success: function (data) {

        Swal.fire({
          title: 'Feito!',
          html: 'Imovel gravado com sucesso!',
          icon: 'success',
          confirmButtonColor: '#337ab7'
        }).then(okay => {
          if (okay) {
            location.href = 'index.php';
          }
        });

      },

      error: function (data) {
        if (data.responseJSON) {
          Swal.fire({
            title: 'Erro ao gravar os dados.',
            html: 'Por favor tente novamente.',
            icon: 'error',
            confirmButtonColor: '#337ab7'
          }).then(okay => {
            if (okay) {
              location.href = 'index.php';
            }
          });
        }
      }
    })
  }

</script>

