<?php
include "valida_sessao.php";

if(isset($_GET['cd']) and isset($_GET['op'])){

	include "../classes/conexao.php";
	include "../classes/palestraDAO.php";
	$codigo = (int)$_GET['cd'];
	$op = $_GET['op'];
	$dao = new palestraDAO();
	if($op == 'encerrar'){
		if($dao->encerrarPalestra($codigo)){
			header("location: listar-palestras.php");
		}
	}else if($op == 'abrir'){
		if($dao->abrirPalestra($codigo)){
			header("location: listar-palestras.php");
		}
	}else{
		header("location: listar-palestras.php");
	}
}
header("location: listar-palestras.php");
?>