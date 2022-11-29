<?php

header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/../vendor/autoload.php';

$autorizado = new Autorizado();

$co_autorizado = isset($_GET["co_autorizado"]) ? $_GET["co_autorizado"] : null;

$no_autorizado = "";
$ds_email = "";
$tp_autorizado = "";
$status = "";

if ($co_autorizado != "") {

  $form = $autorizado->buscarAutorizadoCod($co_autorizado);
  $no_autorizado = $form["no_autorizado"];
  $ds_email = $form["ds_email"];
  $status = $form["status"];
  $dt_atualizacao = convert_date($form["dt_atualizacao"]);
  $dt_desabilitado = convert_date($form["dt_desabilitado"]);
  $tp_autorizado = $form["tp_autorizado"];
}

include '../header.php';

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-lg-6">
          <h1 class="m-0">Autorizado</h1>
        </div><!-- /.col -->
        <div class="col-lg-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../principal.php">Início</a></li>
            <li class="breadcrumb-item"><a href="/autorizado/index.php">Autorizado</a></li>
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
              <?php if (empty($co_autorizado)): ?>
                <h3 class="card-title">Cadastrar</h3>
              <?php else: ?>
                <h3 class="card-title">Alterar</h3>
              <?php endif; ?>
            </div>
            <form id="formAutorizado" name="formAutorizado" method="post">
              <input type="hidden" name="autorizado" id="autorizado" value="<?php echo $co_autorizado ?>">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="required">Nome</label>
                      <input type="text" class="form-control" name="no_autorizado" id="no_autorizado"
                             value="<?php echo $no_autorizado ?>">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="required">E-mail</label>
                      <input type="text" class="form-control" name="ds_email" id="ds_email"
                             value="<?php echo $ds_email ?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="required">Tipo</label>
                      <div class="form-group">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" id="tp_autorizado" name="tp_autorizado"
                                 value="1" <? if ($tp_autorizado == '1') echo 'checked' ?>>
                          <label class="form-check-label">Administrador</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" id="tp_autorizado" name="tp_autorizado"
                                 value="2" <? if ($tp_autorizado == '2') echo 'checked' ?>>
                          <label class="form-check-label">Corretor</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="required">Status</label>
                      <div class="form-group">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" id="status" name="status" value="1"
                                 <?php if ($status && $co_autorizado): ?>checked<?php endif; ?>>
                          <label class="form-check-label">Ativo</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" id="status" name="status" value="0"
                                 <?php if (!$status && $co_autorizado): ?>checked<?php endif; ?>>
                          <label class="form-check-label">Inativo</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <?php if (empty($co_autorizado)): ?>
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

    if ($('#no_autorizado').val() == '') {
      errors.push({input: $('#no_autorizado'), message: ['Campo de preenchimento obrigatório.']});
    }

    if ($('#ds_email').val() == '') {
      errors.push({input: $('#ds_email'), message: ['Campo de preenchimento obrigatório.']});
    }

    if($("[name='tp_autorizado']").filter(':checked').length === 0){
      errors.push({input: $("[name='tp_autorizado']").first().parent(), message: ['Campo de preenchimento obrigatório.']});
    }

    if($("[name='status']").filter(':checked').length === 0){
      errors.push({input: $("[name='status']").first().parent(), message: ['Campo de preenchimento obrigatório.']});
    }

    Validator.clearFormErrors($("#formAutorizado"));

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
    var $form = $("#formAutorizado");
    let formData = $form.serializeArray();

    $.ajax({
      url: 'gravaAutorizado.php',
      type: 'POST',
      data: $.param(formData),
      beforeSend: function () {
        toggleSubmitButton($form, true);
      },
      success: function (data) {

        Swal.fire({
          title: 'Feito!',
          html: 'Autorizado gravado com sucesso!',
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
