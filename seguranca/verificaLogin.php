<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['co_usuario'])){
    header("location: /seguranca/login.php");
}