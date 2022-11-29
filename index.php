<?php

    session_start();

    require __DIR__ . "/seguranca/verificaLogin.php";

    include __DIR__ . "/classes/host.php";

    $conexao = new Host();
    $conexao->criarConexao();