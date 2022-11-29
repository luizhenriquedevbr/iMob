<?php
/**
 * Created by PhpStorm.
 * User: felipyamorim
 * Date: 13/08/20
 * Time: 20:42
 */

class Imovel
{

  private $db;

  public function __construct()
  {
    $this->db = Host::getConexao();
  }

  public function find($ds_endereco, $tp_imovel, $st_situacao, $page = 1, $origem = null)
  {
    $where = [];

    if ($ds_endereco != "") {
      $where[] = "(ds_endereco like '%$ds_endereco%')";
    }

    if ($tp_imovel != "") {
      $where[] = "tp_imovel = '$tp_imovel'";
    }

    if ($st_situacao != "") {
      $where[] = "st_situacao = '$st_situacao'";
    }

    $where = count($where) > 0 ? 'WHERE ' . join(' and ', $where) : '';

    $sql = "SELECT
              co_imovel,
              ds_endereco,
              dt_repasse,
              st_situacao,
              tp_imovel,
              status
            FROM
              imob.tb_imovel
            $where
            ";


    $paginator = new Paginator(Host::getConexao());

    return $paginator
      ->setLimit(5)
      ->paginate($sql, $page, 'ds_endereco ASC');

  }

  public function buscarImovel($co_imovel)
  {
    $sql = "SELECT
              co_imovel,
              ds_endereco,
              dt_repasse,
              st_situacao,
              tp_imovel,
              status
            FROM
              imob.tb_imovel
            WHERE
                co_imovel = :co_imovel
                ";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':co_imovel', $co_imovel);
    $stmt->execute();

    return $stmt->fetch();
  }


  public function create(array $data)
  {
    $ds_endereco = $data['ds_endereco'] ? $data['ds_endereco'] : null;
    $dt_repasse = $data['dt_repasse'] ? $data['dt_repasse'] : null;
    $tp_imovel = isset($data['tp_imovel']) ? $data['tp_imovel'] : null;
    $st_situacao = isset($data['st_situacao']) ? $data['st_situacao'] : null;
    $status = isset($data['status']) ? $data['status'] : null;

    $sql = "
                INSERT into tb_imovel(
                    ds_endereco,
                    dt_repasse,
                    st_situacao,
                    tp_imovel,
                    status
                )
                values
                (
                    :ds_endereco,
                    :dt_repasse,
                    :st_situacao,
                    :tp_imovel,
                    :tp_imovel
                )
            ";

    $stmt = $this->db->prepare($sql);

    $params = array(
      ':ds_endereco' => $ds_endereco,
      ':dt_repasse' => $dt_repasse,
      ':tp_imovel' => $tp_imovel,
      ':st_situacao' => $st_situacao,
      ':status' => $status
    );

    $stmt->execute($params);
  }

  public function update(array $data)
  {
    $co_imovel = $data['co_imovel'] ? $data['co_imovel'] : null;
    $ds_endereco = $data['ds_endereco'] ? $data['ds_endereco'] : null;
    $dt_repasse = $data['dt_repasse'] ? $data['dt_repasse'] : null;
    $tp_imovel = isset($data['tp_imovel']) ? $data['tp_imovel'] : null;
    $st_situacao = isset($data['st_situacao']) ? $data['st_situacao'] : null;
    $status = isset($data['status']) ? $data['status'] : null;

    $sql = "
                UPDATE
                    tb_imovel
                SET
                    ds_endereco = :ds_endereco,
                    dt_repasse = :dt_repasse,
                    tp_imovel = :tp_imovel,
                    st_situacao = :st_situacao,
                    status = :status
                WHERE
                    co_imovel = :co_imovel
            ";

    $stmt = $this->db->prepare($sql);

    $params = array(
      ':co_imovel' => $co_imovel,
      ':ds_endereco' => $ds_endereco,
      ':dt_repasse' => $dt_repasse,
      ':tp_imovel' => $tp_imovel,
      ':st_situacao' => $st_situacao,
      ':status' => $status
    );

    $stmt->execute($params);
  }

}
