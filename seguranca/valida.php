<?php

require __DIR__ . '/../vendor/autoload.php';

$ds_email = $_REQUEST['ds_email'];
$senha = $_REQUEST['senha'];
$autorizado = new Autorizado();
$dados = $autorizado->pesquisarAutorizadoPorEmail($ds_email);

$security = new Security();

try {
  $security->authorize([
    'ds_email' => $ds_email,
    'senha' => $senha
  ]);

  echo json_response([
    'message' => 'Login efetuado com sucesso!',
    'url' => '/principal.php',
    'data' => [
      'ds_email' => Security::getUser()
    ]
  ]);
} catch (Exception $exception) {
  echo json_response([
    'message' => $exception->getMessage(),
    'data' => []
  ], 500);
}

?>
