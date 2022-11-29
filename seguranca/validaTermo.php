<?php

    require __DIR__ . '/../vendor/autoload.php';

    $autorizado = new Autorizado();
    
    try{
        $autorizado->aceitarTermo($_POST);
    }catch (Exception $exception){
        var_dump($exception->getMessage(), $exception->getLine());
    }

?>