<?php

require __DIR__ . '/../vendor/autoload.php';

$ds_endereco = isset($_POST["ds_endereco"]) ? $_POST["ds_endereco"] : null;
$tp_imovel = isset($_POST["tp_imovel"]) ? $_POST["tp_imovel"] : null;
$st_situacao = isset($_POST["st_situacao"]) ? $_POST["st_situacao"] : null;
$page = isset($_POST['page']) ? $_POST['page'] : 1;

$imovel = new Imovel();

$result = $imovel->find($ds_endereco, $tp_imovel, $st_situacao, 1, 'cadastro');

?>

<table class="table table-hover table-sm">
  <thead>
  <tr>
    <th style="text-align:center; width: 10%">ID</th>
    <th style="text-align:left;">Endereço</th>
    <th style="text-align:center; width: 10%">Tipo</th>
    <th style="text-align:center; width: 10%">Situação</th>
    <th style="text-align:center; width: 10%">Repasse (dia)</th>
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
        <td style="text-align:center;"><?php echo $value['co_imovel']; ?></td>
        <td style="text-align:left;"><?php echo $value['ds_endereco']; ?></td>
        <td style="text-align: center;">
          <?php if ($value['tp_imovel'] == '1'): ?>
            <span class="badge badge-primary"><strong>Apartamento</strong></span><br>
          <?php endif; ?>
          <?php if ($value['tp_imovel'] == '2'): ?>
            <span class="badge badge-secondary"><strong>Casa</strong></span><br>
          <?php endif; ?>
        </td>
        <td style="text-align: center;">
          <?php if ($value['st_situacao'] == '1'): ?>
            <span class="badge badge-success"><strong>Disponível</strong></span><br>
          <?php endif; ?>
          <?php if ($value['st_situacao'] == '2'): ?>
            <span class="badge badge-danger"><strong>Ocupado</strong></span><br>
          <?php endif; ?>
        </td>
        <td style="text-align:center;"><?php echo $value['dt_repasse']; ?></td>
        <td style="text-align:center">
          <?php if ($value['status'] == 1): ?>
            <p class="badge badge-success"><strong>Ativo</strong></p>
          <?php else: ?>
            <p class="badge badge-danger"><strong>Inativo</strong></p>
          <?php endif; ?>
        </td>
        <td style="text-align:left; width: 10%">
          <a id="editar" class="btn btn-outline-primary" title="Editar"
             href='formulario.php?co_imovel=<?php echo $value['co_imovel']; ?>'><i
              class="fas fa-pen"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php endif; ?>
  </tbody>
</table>
<?php include __DIR__ . "/../pagination.php"; ?>
