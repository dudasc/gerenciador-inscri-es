<?php
ob_start();
session_start();
include "valida_sessao.php";
include "./classes/conexao.php";
include "./classes/alunoDAO.php";
include "./classes/minicursoDAO.php";
include "./classes/palestraDAO.php";

function formataData($strDate)
{
	// Array com os dia da semana em português;
	$arrDaysOfWeek = array('Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado');
	// Array com os meses do ano em português;
	$arrMonthsOfYear = array(1 => 'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
	// Descobre o dia da semana
	$intDayOfWeek = date('w',strtotime($strDate));
	// Descobre o dia do mês
	$intDayOfMonth = date('d',strtotime($strDate));
	// Descobre o mês
	$intMonthOfYear = date('n',strtotime($strDate));
	// Descobre o ano
	$intYear = date('Y',strtotime($strDate));
	// Formato a ser retornado
	return $arrDaysOfWeek[$intDayOfWeek] . ', ' . $intDayOfMonth . ' de ' . $arrMonthsOfYear[$intMonthOfYear] . ' de ' . $intYear;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Semana Acadêmica 2013</title>
<link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
<link href="css/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link rel="stylesheet" href="css/default.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script type="text/javascript" src="css/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/script.js"></script>

<body>
<div id="geral" class="container">
  <header> <img src="img/logo.png" />
    <div id="logout">
      <p>
        <?=$_SESSION['matricula']?>
        | <a href="logout.php">Sair</a></p>
    </div>
  </header>
  <nav>
    <ul class="nav nav-pills row-fluid">
      <li class="active"> <a href="cadastroadm.php">Minha agenda</a> </li>
      <li><a href="aluno-palestras.php">Palestras</a></li>
      <li><a href="aluno-minicursos.php">Minicursos</a></li>
      <li><a href="meucadastro.php">Meu cadastro</a></li>
    </ul>
  </nav>
  <section>
    <h4>Mini-cursos</h4>
    <?php
    	$dao = new alunoDAO();
		$matricula = $_SESSION['matricula'];
		$consulta = $dao->consulta($matricula);
		$daom = new minicursoDAO();
		$consulta = $daom->agendaMinicursosAluno($matricula);
		if(mysql_num_rows($consulta) == 0){
		echo '<div class="alert alert-info">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							Nenhum mini-curso adicionado. 
						  </div>';
	}else{
	?>
    <table class="table table-condensed table-hover table-bordered">
      <thead>
        <tr>
          <th>Data</th>
          <th>Nome do minicurso</th>
          <th>Horário</th>
          <th>Local</th>
        </tr>
      </thead>
      <tbody>
        <?php
		   
		 
			   while($linha = mysql_fetch_assoc($consulta)){
				   echo '<tr>
							<td>'.formataData($linha['data']).'</td>
							<td>'.$linha['minicurso'].'</td>
							<td>'.$linha['horario'].'</td>			
							<td>'.$linha['local'].'</td>
				</tr>';
			   }
		  
	   ?>
      </tbody>
    </table>
    <?php 
	}?>
    <h4>Palestras</h4>
    <?php
	$daop = new palestraDAO();
    $consulta = $daop->agendaPalestrasAluno($matricula);
	if(mysql_num_rows($consulta) == 0){
		echo '<div class="alert alert-info">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							Nenhuma palestra dicionada. 
						  </div>';
	}else{
	?>
    <table class="table table-condensed table-hover table-bordered">
      <thead>
        <tr>
          <th>Data</th>
          <th>Tema</th>
          <th>Palestrante</th>
          <th>Local</th>
        </tr>
      </thead>
      <tbody>
        <?php
		  
		  
			   while($linha = mysql_fetch_assoc($consulta)){
				   echo '<tr>
							<td>'.formataData($linha['data']).' - '.$linha['horario'].'</td>
							<td>'.$linha['tema'].'</td>
							<td>'.$linha['palestrante'].'</td>			
							<td>'.$linha['local'].'</td>
				</tr>';
			   }		   
	   ?>
      </tbody>
    </table>
    <?php
	}
	?>
  </section>
  <footer>
    <p>&copy; Copyright 2013 - Instituto Federal Catarinense - Campus Sombrio</p>
  </footer>
</div>
</body>
</html>