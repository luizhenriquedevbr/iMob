<?php

require __DIR__ . '/../vendor/autoload.php';

try{
    $dadosAutorizado = Security::getUser();

    $autorizado = new Autorizado();

    $isValid = $autorizado->verificarSenhaAtual($dadosAutorizado['co_autorizado'], $_POST['senha']);

    echo json_response([
        'data' => [
            'is_valid' => $isValid
        ]
    ]);

}catch (Exception $exception){
    echo json_response([
        'message' => 'ERRO: ' . $exception->getMessage(),
        'data' => []
    ], 500);
}

?>