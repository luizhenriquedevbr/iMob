<?php

require __DIR__ . '/../vendor/autoload.php';

$contrato = new Contrato();

try {
  if (isset($_POST['co_contrato']) && $_POST['co_contrato'] != "") {
    $contrato->update($_POST);
  } else {
    $contrato->create($_POST);
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


