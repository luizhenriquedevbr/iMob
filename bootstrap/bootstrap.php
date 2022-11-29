<?php

$config = require __DIR__ . '/../config.php';

define('BASE_URL', $config['base_url']);

if($config['debug']){
  // show all errors
  error_reporting(E_ALL);

  // system settings
  ini_set('display_errors', 1);
  ini_set('display_startup_errors',1);
  ini_set('log_errors', 1);
}

date_default_timezone_set('America/Sao_Paulo');

session_start();
