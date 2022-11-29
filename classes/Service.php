<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');

include __DIR__ . "/../classes/Paginator.php";

class Service
{

  private $db;

  public function __construct()
  {
    $this->db = Host::getConexao();
  }

  public function listarLocador()
  {
    $sql = "SELECT
              tc.co_cliente,
              tc.no_cliente
            FROM
              tb_cliente tc
            INNER JOIN
              rl_cliente_tipo_cliente rctc on
              rctc.co_cliente = tc.co_cliente
            WHERE
              rctc.co_tipo_cliente = 1
              AND tc.status = 1
            ORDER BY tc.no_cliente ASC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
  }

  public function listarLocatario()
  {
    $sql = "SELECT
              tc.co_cliente,
              tc.no_cliente
            FROM
              tb_cliente tc
            INNER JOIN
              rl_cliente_tipo_cliente rctc on
              rctc.co_cliente = tc.co_cliente
            WHERE
              rctc.co_tipo_cliente = 2
              AND tc.status = 1
            ORDER BY tc.no_cliente ASC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
  }

  public function listarImovel()
  {
    $sql = "SELECT
              co_imovel,
              ds_endereco
            FROM
              tb_imovel ti
            ORDER BY ds_endereco ASC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
  }

  public function carregaDtRepasse($co_imovel){

    $sql =  "SELECT
              dt_repasse
            FROM
              tb_imovel ti
            WHERE
              co_imovel = '$co_imovel'
                        ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch();
  }




}
