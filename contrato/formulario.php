<?php

header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/../vendor/autoload.php';

$contrato = new Contrato();
$service = new Service();

$co_contrato = isset($_GET["co_contrato"]) ? $_GET["co_contrato"] : null;

$dt_inicio = "";
$dt_fim = "";
$co_imovel = "";
$co_cliente_locador = "";
$co_cliente_locatario = "";
$vl_taxa = "";
$vl_aluguel = "";
$vl_condominio = "";
$vl_iptu = "";
$status = "";
$vl_repasse = "";
$dt_repasse = "";

if ($co_contrato != "") {

  $form = $contrato->buscarContratoCod($co_contrato);
  $dt_inicio = date("d/m/Y", strtotime($form["dt_inicio"]));
  $dt_fim = date("d/m/Y", strtotime($form["dt_fim"]));
  $co_imovel = $form["co_imovel"];
  $co_cliente_locador = $form["co_cliente_locador"];
  $co_cliente_locatario = $form["co_cliente_locatario"];
  $vl_taxa = number_format($form["vl_taxa"], 2, ",", ".");
  $vl_aluguel = number_format($form["vl_aluguel"], 2, ",", ".");
  $vl_condominio = number_format($form["vl_condominio"], 2, ",", ".");
  $vl_iptu = number_format($form["vl_iptu"], 2, ",", ".");
  $status = $form["status"];

}

$listarLocador = $service->listarLocador();
$listarLocatario = $service->listarLocatario();
$listarImovel = $service->listarImovel();

include '../header.php';

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-lg-6">
          <h1 class="m-0">Contrato</h1>
        </div><!-- /.col -->
        <div class="col-lg-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../principal.php">Início</a></li>
            <li class="breadcrumb-item"><a href="/contrato/index.php">Contrato</a></li>
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
              <?php if (empty($co_contrato)): ?>
                <h3 class="card-title">Cadastrar</h3>
              <?php else: ?>
                <h3 class="card-title">Alterar</h3>
              <?php endif; ?>
            </div>
            <form id="formContrato" name="formContrato" method="post">
              <input type="hidden" name="co_contrato" id="co_contrato" value="<?php echo $co_contrato ?>">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label class="required">Data Início</label>
                      <input type="text" class="form-control mask-date" id="dt_inicio" name="dt_inicio"
                             onkeypress="$(this).mask('00/00/0000')" maxLength="10" size="10" value="<?php echo $dt_inicio ?>">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label class="required">Data Final</label>
                      <input type="text" class="form-control mask-date" id="dt_fim" name="dt_fim"
                             onkeypress="$(this).mask('00/00/0000')" maxLength="10" size="10" value="<?php echo $dt_fim ?>">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="required">Imóvel</label>
                      <select class="form-control" name="co_imovel" id="co_imovel">
                        <option value="">Selecione...</option>
                        <?php foreach ($listarImovel as $item) { ?>
                          <option
                            value="<?php echo $item["co_imovel"]; ?>" <?php if ($co_imovel == $item["co_imovel"]) {
                            echo "SELECTED";
                          } ?> > <?php echo $item["ds_endereco"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="required">Locador</label>
                      <select class="form-control" name="co_cliente_locador" id="co_cliente_locador">
                        <option value="">Selecione...</option>
                        <?php foreach ($listarLocador as $item) { ?>
                          <option
                            value="<?php echo $item["co_cliente"]; ?>" <?php if ($co_cliente_locador == $item["co_cliente"]) {
                            echo "SELECTED";
                          } ?> > <?php echo $item["no_cliente"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="required">Locatário</label>
                      <select class="form-control" name="co_cliente_locatario" id="co_cliente_locatario">
                        <option value="">Selecione...</option>
                        <?php foreach ($listarLocatario as $item) { ?>
                          <option
                            value="<?php echo $item["co_cliente"]; ?>" <?php if ($co_cliente_locatario == $item["co_cliente"]) {
                            echo "SELECTED";
                          } ?> > <?php echo $item["no_cliente"]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label class="required">Valor Aluguel</label>
                      <input type="text" data-prefix="R$ " data-thousands="." data-decimal="," style='text-align: right' class="form-control renda" id="vl_aluguel"
                             name="vl_aluguel" placeholder="00.000,00" value="<?php echo $vl_aluguel ?>">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label class="required">Valor Taxa</label>
                      <input type="text" data-prefix="R$ " data-thousands="." data-decimal="," style='text-align: right' class="form-control renda" id="vl_taxa" name="vl_taxa"
                             placeholder="00.000,00" value="<?php echo $vl_taxa ?>">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label class="required">Valor Condomínio</label>
                      <input type="text" data-prefix="R$ " data-thousands="." data-decimal="," style='text-align: right' class="form-control renda" id="vl_condominio"
                             name="vl_condominio" placeholder="00.000,00" value="<?php echo $vl_condominio ?>">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label class="required">Valor IPTU</label>
                      <input type="text" data-prefix="R$ " data-thousands="." data-decimal="," style='text-align: right' class="form-control renda" id="vl_iptu" name="vl_iptu"
                             placeholder="00.000,00" value="<?php echo $vl_iptu ?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>Valor Repasse</label>
                      <input type="text" style='text-align: right' class="form-control renda" id="vl_repasse"
                             name="vl_repasse" readonly>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>Dia do Repasse</label>
                      <input type="text" style='text-align: right' class="form-control" id="dt_repasse"
                             name="dt_repasse" readonly>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <?php if (empty($co_contrato)): ?>
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

    $('.mask-date').datepicker({
      showMonthsShort: true,
      format: 'dd/mm/yyyy',
      language: 'pt-BR',
      todayBtn: 'linked',
      clearBtn: true,
      todayHighlight: true,
      showButtonPanel: true
    });

  });

  $(document).ready(function() {

    $(".renda").maskMoney();
    $(".renda").keyup(function() {
      renda();
    });

    function renda() {
      var iptu = $("#vl_iptu").maskMoney('unmasked')[0],
        taxa = $("#vl_taxa").maskMoney('unmasked')[0],
        condominio = $("#vl_condominio").maskMoney('unmasked')[0],
      aluguel = $("#vl_aluguel").maskMoney('unmasked')[0];

      var despesa = taxa + condominio + iptu
      var total = aluguel - despesa;

      $("#vl_repasse").maskMoney('mask', total);
    }
  });

  $('#dt_fim').blur(function(){

    //PEGA OS VALORES DIGITADOS NO FORMULÁRIO
    var strData1 = $('#dt_inicio').val();
    var strData2 = $('#dt_fim').val();

    //VERIFICA SE AS DUAS DATAS ESTÃO DIGITADAS
    if(strData1!='' && strData2!=''){

      //DIVIDE EM PARTES (ANO,MES E DIA)
      var partesData1 = strData1.split("/");
      var partesData2 = strData2.split("/");

      //ATRIBUE O VALOR PARA COMPARAÇÃO  - DEIXANDO COM ANO MES DIA(AAAAMMDD) PARA COMPARAR CERTO MATEMATICAMENTE
      var strData1 = new Date(partesData1[2], partesData1[1], partesData1[0]);
      var strData2 = new Date(partesData2[2], partesData2[1], partesData2[0]);

      //COMPARA AS DATAS
      if(strData1 > strData2){
        Swal.fire({
          title: 'Atenção!',
          html: 'A data final não pode ser menor que a data inicial.',
          icon: 'warning',
          confirmButtonColor: '#008d4c'
        });
        $('#dt_fim').val('');
      }

    }
  });


    $('#co_imovel').change(function () {

      co_imovel = $('#co_imovel').val();

      $.ajax({
        url: '../comum/carregaDtRepasse.php',
        type: 'POST',
        data: {co_imovel: co_imovel},
        success: function (retorno) {
          //alert(xhr);
          $('#dt_repasse').val(retorno);
        },
        error: function (data) {
          bootbox.alert('Erro ao carregar a Data de Repasse');
        }
      })
    })

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

      if ($('#dt_inicio').val() == '') {
        errors.push({input: $('#dt_inicio'), message: ['Campo de preenchimento obrigatório.']});
      }

      if ($('#dt_fim').val() == '') {
        errors.push({input: $('#dt_fim'), message: ['Campo de preenchimento obrigatório.']});
      }

      if($("[name='co_imovel']").val().length === 0){
        errors.push({input: $("[name='co_imovel']"), message: ['Campo de preenchimento obrigatório.']});
      }

      if($("[name='co_cliente_locador']").val().length === 0){
        errors.push({input: $("[name='co_cliente_locador']"), message: ['Campo de preenchimento obrigatório.']});
      }

      if($("[name='co_cliente_locatario']").val().length === 0){
        errors.push({input: $("[name='co_cliente_locatario']"), message: ['Campo de preenchimento obrigatório.']});
      }

      if ($('#vl_aluguel').val() == '') {
        errors.push({input: $('#vl_aluguel'), message: ['Campo de preenchimento obrigatório.']});
      }

      if ($('#vl_taxa').val() == '') {
        errors.push({input: $('#vl_taxa'), message: ['Campo de preenchimento obrigatório.']});
      }

      if ($('#vl_condominio').val() == '') {
        errors.push({input: $('#vl_condominio'), message: ['Campo de preenchimento obrigatório.']});
      }

      if ($('#vl_iptu').val() == '') {
        errors.push({input: $('#vl_iptu'), message: ['Campo de preenchimento obrigatório.']});
      }

      Validator.clearFormErrors($("#formContrato"));

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
      var $form = $("#formContrato");
      let formData = $form.serializeArray();

      $.ajax({
        url: 'gravaContrato.php',
        type: 'POST',
        data: $.param(formData),
        beforeSend: function () {
          toggleSubmitButton($form, true);
        },
        success: function (data) {

          Swal.fire({
            title: 'Feito!',
            html: 'Contrato gravado com sucesso!',
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

