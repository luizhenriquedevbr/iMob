<?php

require __DIR__ . '/../vendor/autoload.php';

$unidade  = $_REQUEST['unidade'];

$security = new Security();

try {
    $security->setUnidade($unidade);

    echo json_response([
        'message' => 'Acesso efetuado com sucesso!',
        'url' => '/dashboard.php',
        'data' => [
            'unidade' => Security::getUser()
        ]
    ]);
}catch(Exception $exception){
    echo json_response([
        'message' => 'ERRO: ' . $exception->getMessage(),
        'data' => []
    ], 500);
}