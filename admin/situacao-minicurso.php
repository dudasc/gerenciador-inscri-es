<?php
include "valida_sessao.php";

if(isset($_GET['cd']) and isset($_GET['op'])){

	include "../classes/conexao.php";
	include "../classes/minicursoDAO.php";
	$codigo = (int)$_GET['cd'];
	$op = $_GET['op'];
	$dao = new minicursoDAO();
	if($op == 'encerrar'){
		if($dao->encerrarMinicurso($codigo)){
			header("location: listar-minicursos.php");
		}
	}else if($op == 'abrir'){
		if($dao->abrirMinicurso($codigo)){
			header("location: listar-minicursos.php");
		}
	}else{
		header("location: listar-minicursos.php");
	}
}
header("location: listar-minicursos.php");
?>