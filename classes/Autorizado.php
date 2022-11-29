<?php

class Autorizado
{

  private $db;

  public function __construct()
  {
    $this->db = Host::getConexao();
  }

  public function find($no_autorizado, $ds_email, $page = 1, $origem = null)
  {
    $where = [];

    if ($no_autorizado != "") {
      $where[] = "(no_autorizado like '%$no_autorizado%')";
    }

    if ($ds_email != "") {
      $where[] = "(ds_email like '%$ds_email%')";
    }

    $where = count($where) > 0 ? 'WHERE ' . join(' and ', $where) : '';

    $sql = "SELECT
                    co_autorizado,
                    no_autorizado,
                    ds_email,
                    senha,
                    status,
                    dt_inclusao,
                    dt_atualizacao,
                    dt_desabilitado,
                    tp_autorizado
                  FROM
                    tb_autorizado
                  $where
                  ";


    $paginator = new Paginator(Host::getConexao());

    return $paginator
      ->setLimit(5)
      ->paginate($sql, $page, 'no_autorizado ASC');

  }

  public function buscarAutorizadoCod($co_autorizado)
  {
    $sql = "SELECT
                  co_autorizado,
                  no_autorizado,
                  ds_email,
                  status,
                  dt_atualizacao,
                  dt_desabilitado,
                  tp_autorizado
                FROM
                  tb_autorizado
                WHERE
                    co_autorizado = :co_autorizado
                ";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':co_autorizado', $co_autorizado);
    $stmt->execute();

    return $stmt->fetch();
  }

  public function pesquisarAutorizadoPorEmail($ds_email)
  {
    $sql = "SELECT
                    co_autorizado,
                    no_autorizado,
                    ds_email,
                    senha,
                    status,
                    dt_inclusao,
                    dt_atualizacao,
                    dt_desabilitado,
                    tp_autorizado
                  FROM
                    tb_autorizado
                  WHERE
                      ds_email = :ds_email
                  ";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':ds_email', $ds_email);
    $stmt->execute();

    return $stmt->fetch();
  }

  public function create(array $data)
  {
    $no_autorizado = $data['no_autorizado'] ? $data['no_autorizado'] : null;
    $status = isset($data['status']) ? $data['status'] : null;
    $tp_autorizado = isset($data['tp_autorizado']) ? $data['tp_autorizado'] : null;
    $senha = hash("SHA512", '123456');
    $ds_email = $data['ds_email'] ? $data['ds_email'] : null;
    $dt_inclusao = date("Y-m-d H:i:s");

    $sql = "
                INSERT into tb_autorizado(
                    no_autorizado,
                    status,
                    senha,
                    ds_email,
                    tp_autorizado,
                    dt_inclusao
                )
                values
                (
                    :no_autorizado,
                    :status,
                    :senha,
                    :ds_email,
                    :tp_autorizado,
                    :dt_inclusao
                )
            ";

    $stmt = $this->db->prepare($sql);

    $params = array(
      ':no_autorizado' => $no_autorizado,
      ':status' => $status,
      ':senha' => $senha,
      ':ds_email' => $ds_email,
      ':tp_autorizado' => $tp_autorizado,
      ':dt_inclusao' => $dt_inclusao
    );

    $stmt->execute($params);
  }

  public function update(array $data)
  {
    $co_autorizado = $data['autorizado'] ? $data['autorizado'] : null;
    $no_autorizado = $data['no_autorizado'] ? $data['no_autorizado'] : null;
    $status = isset($data['status']) ? $data['status'] : null;
    $tp_autorizado = isset($data['tp_autorizado']) ? $data['tp_autorizado'] : null;
    $ds_email = $data['ds_email'] ? $data['ds_email'] : null;
    $dt_atualizacao = date("Y-m-d H:i:s");

    $sql = "
                UPDATE
                    tb_autorizado
                SET
                    no_autorizado = :no_autorizado,
                    status = :status,
                    tp_autorizado = :tp_autorizado,
                    ds_email = :ds_email,
                    dt_atualizacao = :dt_atualizacao
                WHERE
                    co_autorizado = :co_autorizado
            ";

    $stmt = $this->db->prepare($sql);

    $params = array(
      ':co_autorizado' => $co_autorizado,
      ':no_autorizado' => $no_autorizado,
      ':status' => $status,
      ':tp_autorizado' => $tp_autorizado,
      ':ds_email' => $ds_email,
      ':dt_atualizacao' => $dt_atualizacao,
    );

    $stmt->execute($params);
  }

  public function setSession(array $data)
  {
    $_SESSION['autenticado'] = 'validado';
    $_SESSION['co_autorizado'] = $data['co_autorizado'];
    $_SESSION['no_autorizado'] = $data['no_autorizado'];
    $_SESSION['senha'] = $data['senha'];
    $_SESSION['tp_autorizado'] = $data['tp_autorizado'];
  }

  public function verificarSenhaAtual($ds_email, string $senha)
  {
    $autorizado = $this->buscarUsuarioCod($ds_email);
    return $autorizado['senha'] === hash("SHA512", $senha);
  }

  public function alterarSenha(array $data)
  {

    $co_autorizado = $data['co_autorizado'] ? $data['co_autorizado'] : null;
    $senha = hash("SHA512", $data['novaSenha']);
    $dt_atualizacao = date("Y-m-d H:i:s");

    $sql = "
                UPDATE tb_autorizado
                   SET senha = :senha,
                       dt_atualizacao = :dt_atualizacao
                 WHERE co_autorizado = :co_autorizado
                ";

    $stmt = $this->db->prepare($sql);

    $params = array(
      ':co_autorizado' => $co_autorizado,
      ':senha' => $senha,
      ':dt_atualizacao' => $dt_atualizacao
    );

    $stmt->execute($params);
  }


}
