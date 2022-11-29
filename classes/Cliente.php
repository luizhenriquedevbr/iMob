<?php

class Cliente
{

  private $db;

  public function __construct()
  {
    $this->db = Host::getConexao();
  }

  public function find($no_cliente, $ds_email, $page = 1, $origem = null)
  {
    $where = [];

    if ($no_cliente != "") {
      $where[] = "(tc.no_cliente like '%$no_cliente%')";
    }

    if ($ds_email != "") {
      $where[] = "(tc.ds_email like '%$ds_email%')";
    }

    $where = count($where) > 0 ? 'WHERE ' . join(' and ', $where) : '';

    $sql = "SELECT
              tc.co_cliente,
              tc.no_cliente,
              tc.ds_email,
              tc.nu_telefone,
              tc.status,
              rlc.co_tipo_cliente,
              ttc.ds_tipo_cliente
            FROM
              tb_cliente tc
            INNER JOIN
              rl_cliente_tipo_cliente rlc on
              rlc.co_cliente = tc.co_cliente
            INNER JOIN
              tb_tipo_cliente ttc on
              ttc.co_tipo_cliente = rlc.co_tipo_cliente
            $where
            ";


    $paginator = new Paginator(Host::getConexao());

    return $paginator
      ->setLimit(5)
      ->paginate($sql, $page, 'no_cliente ASC');

  }

  public function buscarClienteCod($co_cliente)
  {

    $sql = "SELECT
                tc.co_cliente,
                tc.no_cliente,
                tc.ds_email,
                tc.nu_telefone,
                tc.status,
                rlc.co_tipo_cliente
            FROM
                tb_cliente tc
            INNER JOIN
                rl_cliente_tipo_cliente rlc on
                rlc.co_cliente = tc.co_cliente
            WHERE
                tc.co_cliente = :co_cliente
                ";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':co_cliente', $co_cliente);
    $stmt->execute();

    return $stmt->fetch();
  }


  public function create(array $data)
  {

    $no_cliente = $data['no_cliente'] ? $data['no_cliente'] : null;
    $ds_email = $data['ds_email'] ? $data['ds_email'] : null;
    $nu_telefone = !empty($data['nu_telefone']) ? preg_replace("/[^0-9]/", "", $data['nu_telefone']) : null;
    $status = isset($data['status']) ? $data['status'] : null;

    $tipoCliente = isset($data['tipoCliente']) ? $data['tipoCliente'] : array();

    try {

      $sql = "
                INSERT into tb_cliente(
                    no_cliente,
                    ds_email,
                    nu_telefone,
                    status
                )
                values
                (
                    :no_cliente,
                    :ds_email,
                    :nu_telefone,
                    :status
                );
            ";

      $stmt = $this->db->prepare($sql);
      $stmt->execute([
        ':no_cliente' => $no_cliente,
        ':ds_email' => $ds_email,
        ':nu_telefone' => $nu_telefone,
        ':status' => $status
      ]);

      $co_cliente = $this->db->lastInsertId();

      $this->gravartipoCliente($co_cliente, $tipoCliente);

    } catch (Exception $e) {
      echo json_response([
        'message' => 'ERRO: ' . $e->getMessage(),
        'data' => []
      ], 500);
    }
  }

  public function update(array $data)
  {
    $co_cliente = isset($data['co_cliente']) ? $data['co_cliente'] : null;
    $no_cliente = isset($data['no_cliente']) ? $data['no_cliente'] : null;
    $ds_email = isset($data['ds_email']) ? $data['ds_email'] : null;
    $nu_telefone = !empty($data['nu_telefone']) ? preg_replace("/[^0-9]/", "", $data['nu_telefone']) : null;
    $status = isset($data['status']) ? $data['status'] : null;

    $tipoCliente = isset($data['tipoCliente']) ? $data['tipoCliente'] : array();

    Try{

    $sql = "
                UPDATE
                    tb_cliente
                SET
                    no_cliente = :no_cliente,
                    ds_email = :ds_email,
                    nu_telefone = :nu_telefone,
                    status = :status
                WHERE
                    co_cliente = :co_cliente
            ";

    $stmt = $this->db->prepare($sql);
      $stmt->execute([
        ':co_cliente' => $co_cliente,
        ':no_cliente' => $no_cliente,
        ':ds_email' => $ds_email,
        ':nu_telefone' => $nu_telefone,
        ':status' => $status
      ]);

      $this->gravartipoCliente($co_cliente, $tipoCliente);

    } catch (Exception $e) {
      echo json_response([
        'message' => 'ERRO: ' . $e->getMessage(),
        'data' => []
      ], 500);
    }
  }

  public function gravartipoCliente($co_cliente, array $tipoCliente)
  {
    $sql = "delete from rl_cliente_tipo_cliente where co_cliente = :co_cliente";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':co_cliente' => $co_cliente
    ]);

    foreach ($tipoCliente as $value) {
      $sql = "
                    INSERT into rl_cliente_tipo_cliente
                    (
                        co_cliente,
                        co_tipo_cliente
                    )
                    values
                    (
                        :co_cliente,
                        :co_tipo_cliente
                    )
                ";
      $stmt = $this->db->prepare($sql);
      $stmt->execute([
        ':co_cliente' => $co_cliente,
        ':co_tipo_cliente' => $value
      ]);
    }
  }

  public function tipoCliente($co_tipo_cliente)
  {
    $sql = "
					SELECT
            ttc.co_tipo_cliente,
            ttc.ds_tipo_cliente,
            (select
                rlc.co_cliente
              FROM
                rl_cliente_tipo_cliente rlc
              where
                rlc.co_tipo_cliente = :co_tipo_cliente
              AND
                rlc.co_tipo_cliente = ttc.co_tipo_cliente) as resposta
          from
            tb_tipo_cliente ttc
				";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':co_tipo_cliente' => $co_tipo_cliente
    ]);

    return $stmt->fetchAll();
  }

}
