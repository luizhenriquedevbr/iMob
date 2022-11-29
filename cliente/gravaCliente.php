<?php

require __DIR__ . '/../vendor/autoload.php';

$cliente = new Cliente();

try {
  if (isset($_POST['co_cliente']) && $_POST['co_cliente'] != "") {
    $cliente->update($_POST);
  } else {
    $cliente->create($_POST);
  }
  echo json_response([
    'message' => 'Dados gravados com sucesso.',
    'data' => []
  ]);
} catch (Exception $exception) {
  echo json_response([
    'message' => 'ERRO: ' . $exception->getMessage(),
    'data' => []
  ], 500);
}

?>

