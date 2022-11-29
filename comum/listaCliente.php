<?php

require __DIR__ . '/../vendor/autoload.php';

$no_cliente = isset($_POST["no_cliente"]) ? $_POST["no_cliente"] : null;
$ds_email = isset($_POST["ds_email"]) ? $_POST["ds_email"] : null;
$page = isset($_POST['page']) ? $_POST['page'] : 1;

$cliente = new Cliente();

$result = $cliente->find($no_cliente, $ds_email, 1, 'cadastro');

?>

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
