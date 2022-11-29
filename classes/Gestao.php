<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

class Gestao
{
  private $db;

  public function __construct()
  {
    $this->db = Host::getConexao();
  }

  public function find($co_cliente_locador, $co_cliente_locatario, $co_imovel, $page = 1, $origem = null)
  {

    $where = [];

    if ($co_cliente_locador != "") {
      $where[] = "tc.co_cliente_locador = '$co_cliente_locador'";
    }

    if ($co_cliente_locatario != "") {
      $where[] = "tc.co_cliente_locatario = '$co_cliente_locatario'";
    }

    if ($co_imovel != "") {
      $where[] = "tc.co_imovel = '$co_imovel'";
    }

    $where = count($where) > 0 ? 'WHERE ' . join(' and ', $where) : '';

    $sql = "SELECT
              tp.co_gestao,
              tc.co_contrato,
              tc.dt_inicio,
              tc.dt_fim,
              tc.co_cliente_locador,
              tc.co_cliente_locatario,
              tc.co_imovel,
              tc.status,
              tcl1.no_cliente as locador,
              tcl2.no_cliente as locatario,
              ti.ds_endereco,
              tp.st_mensalidade,
              tp.st_repasse,
              tp.dt_mensalidade,
              tp.dt_repasse
            FROM
              tb_contrato tc
            INNER JOIN
              tb_cliente tcl1 on
              tcl1.co_cliente = tc.co_cliente_locador
            INNER JOIN
              tb_cliente tcl2 on
              tcl2.co_cliente = tc.co_cliente_locatario
            INNER JOIN
              tb_imovel ti on
              ti.co_imovel = tc.co_imovel
              INNER JOIN
              tb_gestao tp on
              tp.co_contrato = tc.co_contrato
            $where
            ";


    $paginator = new Paginator(Host::getConexao());

    return $paginator
      ->setLimit(5)
      ->paginate($sql, $page, 'tc.co_contrato ASC');

  }

  public function buscarGestaoCod($co_gestao)
  {

    $sql = "SELECT
                tg.co_gestao,
                tc.co_contrato,
                tc.dt_inicio,
                tc.dt_fim,
                tc.co_cliente_locador,
                tc.co_cliente_locatario,
                tc.co_imovel,
                ti.ds_endereco,
                tc.status,
                tcl1.no_cliente as locador,
                tcl2.no_cliente as locatario,
                ti.ds_endereco,
                tg.st_mensalidade,
                tg.st_repasse,
                tg.dt_mensalidade,
                tg.dt_repasse,
                tc.vl_taxa,
                tc.vl_condominio,
                tc.vl_iptu,
                tc.vl_aluguel,
                tc.vl_repasse,
                ti.dt_repasse
            FROM
              tb_contrato tc
            INNER JOIN
              tb_cliente tcl1 on
              tcl1.co_cliente = tc.co_cliente_locador
            INNER JOIN
              tb_cliente tcl2 on
              tcl2.co_cliente = tc.co_cliente_locatario
            INNER JOIN
              tb_imovel ti on
              ti.co_imovel = tc.co_imovel
              INNER JOIN
              tb_gestao tg on
              tg.co_contrato = tc.co_contrato
            WHERE
                tg.co_gestao = :co_gestao
                ";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':co_gestao', $co_gestao);
    $stmt->execute();

    return $stmt->fetch();
  }


  public function create(array $data)
  {
    $dt_inicio = !empty($data['dt_inicio']) ? convert_date_from_format($data['dt_inicio']) : null;
    $dt_fim = !empty($data['dt_fim']) ? convert_date_from_format($data['dt_fim']) : null;
    $vl_taxa = str_replace("R$ ", "", str_replace(",", ".", str_replace(".", "", $data["vl_taxa"])));
    $vl_aluguel = str_replace("R$ ", "", str_replace(",", ".", str_replace(".", "", $data["vl_aluguel"])));
    $vl_condominio = str_replace("R$ ", "", str_replace(",", ".", str_replace(".", "", $data["vl_condominio"])));
    $vl_iptu = str_replace("R$ ", "", str_replace(",", ".", str_replace(".", "", $data["vl_iptu"])));
    $vl_repasse = str_replace("R$ ", "", str_replace(",", ".", str_replace(".", "", $data["vl_repasse"])));
    $co_cliente_locador = isset($data['co_cliente_locador']) ? $data['co_cliente_locador'] : null;
    $co_cliente_locatario = isset($data['co_cliente_locatario']) ? $data['co_cliente_locatario'] : null;
    $co_imovel = isset($data['co_imovel']) ? $data['co_imovel'] : null;
    $status = isset($data['status']) ? $data['status'] : null;
    $st_mensalidade = isset($data['st_mensalidade']) ? $data['st_mensalidade'] : null;
    $st_repasse = isset($data['st_repass']) ? $data['st_repass'] : null;

    try {

      $sql = "
                INSERT INTO tb_contrato
                (
                dt_inicio,
                dt_fim,
                vl_taxa,
                vl_aluguel,
                vl_condominio,
                vl_iptu,
                vl_repasse,
                co_cliente_locador,
                co_cliente_locatario,
                co_imovel,
                status
                )
                VALUES
                (
                :dt_inicio,
                :dt_fim,
                :vl_taxa,
                :vl_aluguel,
                :vl_condominio,
                :vl_iptu,
                :vl_repasse,
                :co_cliente_locador,
                :co_cliente_locatario,
                :co_imovel,
                1
                );
            ";

      $stmt = $this->db->prepare($sql);
      $stmt->execute([
        ':dt_inicio' => $dt_inicio,
        ':dt_fim' => $dt_fim,
        ':vl_taxa' => $vl_taxa,
        ':vl_aluguel' => $vl_aluguel,
        ':vl_condominio' => $vl_condominio,
        ':vl_iptu' => $vl_iptu,
        ':vl_repasse' => $vl_repasse,
        ':co_cliente_locador' => $co_cliente_locador,
        ':co_cliente_locatario' => $co_cliente_locatario,
        ':co_imovel' => $co_imovel
      ]);

      $co_contrato = $this->db->lastInsertId();

      $sql = "
                INSERT INTO tb_gestao
                (
                  co_contrato,
                  st_mensalidade,
                  st_repasse
                )
                VALUES
                (
                :co_contrato,
                1,
                1
                );
            ";

      $stmt = $this->db->prepare($sql);
      $stmt->execute([
        ':co_contrato' => $co_contrato
      ]);

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

    try {

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


    } catch (Exception $e) {
      echo json_response([
        'message' => 'ERRO: ' . $e->getMessage(),
        'data' => []
      ], 500);
    }
  }

}

