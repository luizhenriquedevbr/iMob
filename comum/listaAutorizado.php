<?php

require __DIR__ . '/../vendor/autoload.php';

$no_autorizado = isset($_POST["no_autorizado"]) ? $_POST["no_autorizado"] : null;
$ds_email = isset($_POST["ds_email"]) ? $_POST["ds_email"] : null;
$page = isset($_POST['page']) ? $_POST['page'] : 1;

$autorizado = new Autorizado();

$result = $autorizado->find($no_autorizado, $ds_email, 1, 'cadastro');

?>

<table class="table table-hover table-sm">
  <thead>
  <tr>
    <th style="text-align:center; width: 10%">ID</th>
    <th style="text-align:left;">Nome</th>
    <th style="text-align:left;">E-mail</th>
    <th style="text-align:center;">Tipo</th>
    <th style="text-align:center;">Status</th>
    <th style="text-align:left; width: 10%">Ação</th>
  </tr>
  </thead>
  <tbody>
  <?php if (!$result): ?>
    <td colspan='6'>
      <div class="info-box bg-gradient-danger" style="text-align: center">
        <div class="info-box-content" style="text-align: center">
          <h4>Atenção!</h4>
          <p>Nenhum registro encontrado.</p>
        </div>
    </td>
  <?php else: ?>
    <?php foreach ($result['items'] as $key => $value): ?>
      <tr>
        <td style="text-align:center;"><?php echo $value['co_autorizado']; ?></td>
        <td style="text-align:left;"><?php echo $value['no_autorizado']; ?></td>
        <td style="text-align:left;"><?php echo $value['ds_email']; ?></td>
        <td style="text-align: center;">
          <?php if ($value['tp_autorizado'] == '1'): ?>
            <span class="badge badge-primary"><strong>Administrador</strong></span><br>
          <?php endif; ?>
          <?php if ($value['tp_autorizado'] == '2'): ?>
            <span class="badge badge-secondary"><strong>Corretor</strong></span><br>
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
             href='formulario.php?co_autorizado=<?php echo $value['co_autorizado']; ?>'><i
              class="fas fa-pen"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php endif; ?>
  </tbody>
</table>
<?php include __DIR__ . "/../pagination.php"; ?>
