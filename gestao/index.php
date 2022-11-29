<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

$gestao = new Gestao();
$service = new Service();

$co_imovel = "";
$co_cliente_locador = "";
$co_cliente_locatario = "";

$result = $gestao->find(null, null, null, 1, 'cadastro');

$listarLocador = $service->listarLocador();
$listarLocatario = $service->listarLocatario();
$listarImovel = $service->listarImovel();

include '../header.php';

?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-lg-6">
          <h1 class="m-0">Gestão</h1>
        </div>
        <div class="col-lg-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../principal.php">Início</a></li>
            <li class="breadcrumb-item active">Gestão</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-orange card-outline">
            <div class="card-header">
              <h3 class="card-title">Filtro</h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                  </li>
                </ul>
              </div>
            </div>
            <form name="formContrato" id="formContrato" method="post">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label>Imóvel</label>
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
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label>Locador</label>
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
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label>Locatário</label>
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
              </div>
              <div class="card-footer">
                <button type="button" class="btn btn-sm btn-info" name="pesquisar" id="pesquisar">Pesquisar</button>
                <button type="button" class="btn btn-sm btn-danger" onclick="Cancelar();">Limpar</button>
              </div>
              <input type="hidden" name="page" value="1">
            </form>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Listagem</h3>
            </div>
            <div class="card-body table-responsive">
              <input type="hidden" name="page" value="1">
              <div id="resposta">
                <table class="table table-hover table-sm">
                  <thead>
                  <tr>
                    <th style="text-align:center; width: 10%">Contrato</th>
                    <th style="text-align:left;">Imóvel</th>
                    <th style="text-align:left;">Locador</th>
                    <th style="text-align:left;">Locatário</th>
                    <th style="text-align:center; width: 10%">Aluguel</th>
                    <th style="text-align:center; width: 10%">Repasse</th>
                    <th style="text-align:center; width: 10%">Status</th>
                    <th style="text-align:left; width: 10%">Ação</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php if (!$result): ?>
                    <td colspan='8'>
                      <div class="info-box bg-gradient-danger" style="text-align: center">
                        <div class="info-box-content" style="text-align: center">
                          <h4>Atenção!</h4>
                          <p>Nenhum registro encontrado.</p>
                        </div>
                    </td>
                  <?php else: ?>
                    <?php foreach ($result['items'] as $key => $value):
                      $dt_inicio = new Datetime($value['dt_inicio']);
                      $dt_fim = new Datetime($value['dt_fim']); ?>
                      <tr>
                        <td style="text-align:center;"><?php echo $value['co_contrato']; ?></td>
                        <td style="text-align:left;"><?php echo $value['ds_endereco']; ?></td>
                        <td style="text-align:left;"><?php echo $value['locador']; ?></td>
                        <td style="text-align:left;"><?php echo $value['locatario']; ?></td>
                        <td style="text-align: center;">
                        <?php if ($value['st_mensalidade'] == '1'): ?>
                          <span class="badge badge-danger"><strong>Em aberto</strong></span><br>
                        <?php endif; ?>
                        <?php if ($value['st_mensalidade'] == '2'): ?>
                          <span class="badge badge-success"><strong>Pago</strong></span><br>
                        <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                        <?php if ($value['st_repasse'] == '1'): ?>
                          <span class="badge badge-danger"><strong>Em aberto</strong></span><br>
                        <?php endif; ?>
                        <?php if ($value['st_repasse'] == '2'): ?>
                          <span class="badge badge-success"><strong>Pago</strong></span><br>
                        <?php endif; ?>
                        </td>
                        <td style="text-align:center">
                          <?php if ($value['status'] == 1): ?>
                            <p class="badge badge-success"><strong>Ativo</strong></p>
                          <?php else: ?>
                            <p class="badge badge-danger"><strong>Inativo</strong></p>
                          <?php endif; ?>
                        </td>
                        <td style="text-align:left; width: 10%">
                          <a id="editar" class="btn btn-outline-primary" title="Editar"
                             href='formulario.php?co_gestao=<?php echo $value['co_gestao']; ?>'><i
                              class="fas fa-pen"></i></a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                  </tbody>
                </table>
                <?php include __DIR__ . "/../pagination.php"; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include '../footer.php'; ?>

<script>

  $("body").on('click', 'ul.pagination li a', function () {
    if ($(this).attr('disabled') || $(this).parent().hasClass('disabled')) {
      return false;
    }
    $('[name=page]').val($(this).data('page'));
    $('#pesquisar').click();
  });

  $(document).ready(function () {

    $('.mask-date').datepicker({
      showMonthsShort: true,
      format: 'dd/mm/yyyy',
      language: 'pt-BR',
      todayBtn: 'linked',
      clearBtn: true,
      todayHighlight: true,
      showButtonPanel:true
    });

    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
      },
      spOptions = {
        onKeyPress: function (val, e, field, options) {
          field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
      };
    $("#nu_telefone").mask(SPMaskBehavior, spOptions);

  });

  $('#pesquisar').click(function () {

    $.ajax({
      url: '/comum/listaContrato.php'
      , type: 'post'
      , data: $('#formContrato').serialize()
      , success: function (xhr) {
        $('#resposta').html(xhr);
        $('[name=page]').val(1);
      }
      , error: function (xhr) {
        alert(JSON.parse(xhr.responseText).message);
      }
    });
  });

  $(document).ready(function () {

  });

  function Cancelar() {
    location.href = 'index.php';
  }

  function novo() {
    location.href = 'formulario.php';
  }

</script>
