<?php
include "valida_sessao.php";
if(isset($_GET['mat']) and isset($_GET['codigo'])){
	include "../classes/conexao.php";
	include "../classes/palestraDAO.php";
	$codigo = (int)$_GET['codigo'];
	$matricula = $_GET['mat'];
	$dao = new palestraDAO();
	echo $matricula. " - ". $codigo;
	$dao->alteraPresenca($matricula, $codigo);
}else{
	header("location: relatorio-alunos-palestra.php");
}
?>