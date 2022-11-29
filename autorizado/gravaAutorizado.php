<?php

require __DIR__ . '/../vendor/autoload.php';

$autorizado = new Autorizado();

try {
  if (isset($_POST['autorizado']) && $_POST['autorizado'] != "") {
    $autorizado->update($_POST);
  } else {
    $autorizado->create($_POST);
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
