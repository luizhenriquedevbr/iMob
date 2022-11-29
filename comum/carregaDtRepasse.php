<?php

require __DIR__ . '/../vendor/autoload.php';

$service = new Service();

$co_imovel = $_POST["co_imovel"];

$imovel = $service->carregaDtRepasse($co_imovel);

echo $imovel['dt_repasse'];

?>
