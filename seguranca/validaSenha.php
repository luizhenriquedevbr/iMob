<?php

    require __DIR__ . '/../vendor/autoload.php';

    $autorizado = new Autorizado();

    
    try{
        $autorizado->alterarSenha($_POST);
    }catch (Exception $exception){
        var_dump($exception->getMessage(), $exception->getLine());
    }