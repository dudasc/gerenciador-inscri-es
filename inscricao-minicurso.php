<?php
ob_start();
session_start();
include "valida_sessao.php";
include "classes/conexao.php";
include "classes/minicursoDAO.php";


if(isset($_GET['cd'])){
	$codigo = $_GET['cd'];
	$dao = new minicursoDAO();
	$consulta = $dao->consulta($codigo);
	$linha = mysql_fetch_assoc($consulta);
	
	
	if(isset($_GET['op'])){
		if($_GET['op'] == 'cancela'){
			$codigo = $_GET['cd'];
			//$dao = new minicursoDAO();
			if($dao->verificaInscricaoAlunoMinicurso($_SESSION['matricula'], $linha['codigo']) == true){
				if($dao->cancelaInscricaoMinicurso($_SESSION['matricula'], $linha['codigo']) == true){
					//echo mysql_error();
					header("location: aluno-minicursos.php");
				}
			}else{
				header("location: aluno-minicursos.php");
			}
		}
	}else{
		$vagas = $linha['vagas'];
		$data = $linha['data'];
		$horario = $linha['horario'];
		if($vagas == 0){
			header("location: aluno-minicursos.php");
			//verifica se não existe um minicurso no mesmo horario
		}else if($dao->consultaDataHoraAlunoMinicurso($_SESSION['matricula'], $data, $horario) == true){ 
			echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							Erro. Você ja está inscrito em um minicurso no mesmo horário 
						  </div>';
			//header("location: aluno-minicursos.php");
		
		}else if($dao->incricaoAlunoMinicurso($_SESSION['matricula'], $linha['codigo']) == true){
				header("location: aluno-minicursos.php");
		}
		
	}
}else{
	header("location: aluno-minicursos.php");
}
?>