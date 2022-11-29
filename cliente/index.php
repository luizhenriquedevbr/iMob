<?php

require __DIR__ . '/../vendor/autoload.php';

$cliente = new Cliente();

$result = $cliente->find(null, null, 1, 'cadastro');

include '../header.php';

?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-lg-6">
          <h1 class="m-0">Cliente</h1>
        </div>
        <div class="col-lg-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../principal.php">Início</a></li>
            <li class="breadcrumb-item active">Cliente</li>
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
                    <a id="editar" class='btn btn-sm btn-primary' href='formulario.php'>Novo</a>
                  </li>
                </ul>
              </div>
            </div>
            <form name="formCliente" id="formCliente" method="post">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>Nome</label>
                      <input type="text" class="form-control" id="no_cliente" name="no_cliente">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>E-mail</label>
                      <input type="text" class="form-control" id="ds_email" name="ds_email">
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
                    <th style="text-align:center; width: 10%">ID</th>
                    <th style="text-align:left;">Nome</th>
                    <th style="text-align:left;">E-mail</th>
                    <th style="text-align:center;">Telefone</th>
                    <th style="text-align:center; width: 10%">Tipo</th>
                    <th style="text-align:center; width: 10%">Status</th>
                    <th style="text-align:left; width: 10%">Ação</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php if (!$result): ?>
                    <td colspan='7'>
                      <div class="info-box bg-gradient-danger" style="text-align: center">
                        <div class="info-box-content" style="text-align: center">
                          <h4>Atenção!</h4>
                          <p>Nenhum registro encontrado.</p>
                        </div>
                    </td>
                  <?php else: ?>
                    <?php foreach ($result['items'] as $key => $value): ?>
                      <tr>
                        <td style="text-align:center;"><?php echo $value['co_cliente']; ?></td>
                        <td style="text-align:left;"><?php echo $value['no_cliente']; ?></td>
                        <td style="text-align:left;"><?php echo $value['ds_email']; ?></td>
                        <td style="text-align:center;"><?php echo mask($value['nu_telefone'], '(##)#####-####');  ?></td>
                        <td style="text-align: center;">
                          <?php if ($value['co_tipo_cliente'] == '1'): ?>
                            <span class="badge badge-primary"><strong>Locador</strong></span><br>
                          <?php endif; ?>
                          <?php if ($value['co_tipo_cliente'] == '2'): ?>
                            <span class="badge badge-secondary"><strong>Locatário</strong></span><br>
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
                             href='formulario.php?co_cliente=<?php echo $value['co_cliente']; ?>'><i
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
      url: '/comum/listaCliente.php'
      , type: 'post'
      , data: $('#formCliente').serialize()
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
