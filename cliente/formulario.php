<?php

header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/../vendor/autoload.php';

$cliente = new Cliente();
$co_cliente = isset($_GET["co_cliente"]) ? $_GET["co_cliente"] : null;
$no_cliente = "";
$ds_email = "";
$nu_telefone = "";
$status = "";
$co_tipo_cliente = "";

if ($co_cliente != "") {

  $form = $cliente->buscarClienteCod($co_cliente);
  $no_cliente = $form["no_cliente"];
  $ds_email = $form["ds_email"];
  $nu_telefone = $form["nu_telefone"];
  $status = $form["status"];
  $co_tipo_cliente = $form["co_tipo_cliente"];
}

$tipoCliente = $cliente->tipoCliente($co_tipo_cliente);

include '../header.php';

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-lg-6">
          <h1 class="m-0">Cliente</h1>
        </div><!-- /.col -->
        <div class="col-lg-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../principal.php">Início</a></li>
            <li class="breadcrumb-item"><a href="/cliente/index.php">Cliente</a></li>
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
              <?php if (empty($co_cliente)): ?>
                <h3 class="card-title">Cadastrar</h3>
              <?php else: ?>
                <h3 class="card-title">Alterar</h3>
              <?php endif; ?>
            </div>
            <form id="formCliente" name="formCliente" method="post">
              <input type="hidden" name="co_cliente" id="co_cliente" value="<?php echo $co_cliente ?>">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="required">Nome</label>
                      <input type="text" class="form-control" name="no_cliente" id="no_cliente"
                             value="<?php echo $no_cliente ?>">
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
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="required">Telefone</label>
                      <input class="form-control" type="text" name="nu_telefone"
                             id="nu_telefone" maxlength="15" value="<?php echo $nu_telefone; ?>"/>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="required">Tipo</label>
                      <div class="form-group">
                        <?php foreach ($tipoCliente as $key => $value): ?>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="tipoCliente[]"
                                   id="rotina_<?php echo $value['co_tipo_cliente']; ?>"
                                   value="<?php echo $value['co_tipo_cliente']; ?>"
                              <?php if (isset($value['resposta']) && $value['resposta']) echo 'checked'; ?>>
                            <label class="form-check-label">
                              <?php echo $value['ds_tipo_cliente']; ?>
                            </label>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="required">Status</label>
                      <div class="form-group">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" id="status" name="status" value="1"
                                 <?php if ($status && $co_cliente): ?>checked<?php endif; ?>>
                          <label class="form-check-label">Ativo</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" id="status" name="status" value="0"
                                 <?php if (!$status && $co_cliente): ?>checked<?php endif; ?>>
                          <label class="form-check-label">Inativo</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <?php if (empty($co_cliente)): ?>
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

  $(document).ready(function () {

    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
      },
      spOptions = {
        onKeyPress: function (val, e, field, options) {
          field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
      };

    $('#nu_telefone').mask(SPMaskBehavior, spOptions);

  });

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

    if ($('#no_cliente').val() == '') {
      errors.push({input: $('#no_cliente'), message: ['Campo de preenchimento obrigatório.']});
    }

    if ($('#ds_email').val() == '') {
      errors.push({input: $('#ds_email'), message: ['Campo de preenchimento obrigatório.']});
    }

    if ($('#nu_telefone').val() == '') {
      errors.push({input: $('#nu_telefone'), message: ['Campo de preenchimento obrigatório.']});
    }

    if ($("[name='tipoCliente[]']").filter(':checked').length === 0) {
      errors.push({
        input: $("[name='tipoCliente[]']").first().parent(),
        message: ['Campo de preenchimento obrigatório.']
      });
    }

    if ($("[name='status']").filter(':checked').length === 0) {
      errors.push({input: $("[name='status']").first().parent(), message: ['Campo de preenchimento obrigatório.']});
    }


    Validator.clearFormErrors($("#formCliente"));

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
    var $form = $("#formCliente");
    let formData = $form.serializeArray();

    $.ajax({
      url: 'gravaCliente.php',
      type: 'POST',
      data: $.param(formData),
      beforeSend: function () {
        toggleSubmitButton($form, true);
      },
      success: function (data) {

        Swal.fire({
          title: 'Feito!',
          html: 'Cliente gravado com sucesso!',
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

