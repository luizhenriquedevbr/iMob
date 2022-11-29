<?php

require __DIR__ . '/../vendor/autoload.php';

$imovel = new Imovel();

try {
  if (isset($_POST['co_imovel']) && $_POST['co_imovel'] != "") {
    $imovel->update($_POST);
  } else {
    $imovel->create($_POST);
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


