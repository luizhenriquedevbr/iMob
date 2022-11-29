<?php 

require __DIR__ . '/../vendor/autoload.php';

try {

	$sql = "
			ORDER BY no_unidade
			";

	$stmt = $db->prepare($sql);
	$stmt->bindValue(':co_unidade', $_GET['co_unidade']);
	$stmt->execute();

	$result = $stmt->fetch();

	$_SESSION['dados_login']['co_unidade'] = $result['co_unidade'];
	$_SESSION['dados_login']['co_autorizado'] = $result['co_autorizado'];

	$sql = 'select cd_funcao from autorizado_inst_lab_acesso where cd_aut = :cpf and co_unidade = :instituicao';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':cpf', $_SESSION['dados_login']['cd_aut']);
	$stmt->bindValue(':instituicao', $result['co_unidade']);
	$stmt->execute();

	$result = $stmt->fetchAll();

	foreach ($result as $key => $value) {
		$_SESSION['dados_login']['permissao'][] = $value['cd_funcao'];
	}


} catch (PDOException $e) {
	die($e->getMessage());
}

header("location: ../dashboard.php");
?>