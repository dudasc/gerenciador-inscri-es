<?php
include "valida_sessao.php";
include "../classes/conexao.php";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Semana Acadêmica 2013</title>
<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.css">
<link href="../css/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link rel="stylesheet" href="../css/default.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script type="text/javascript" src="../css/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="../js/script.js"></script>
<style>
#geral {
	margin-top: 41px !important;
	border-radius: 0 0 5px 5px;
}
</style>
<body>
<div id="geral" class="container"> 
  <!--
  <header> <img src="../img/logo.png" />
   
  </header>
  -->
  <nav>
    <?php
		include "menu.php";
	?>
  </nav>
  <section>
    <h1>Alunos</h1>
    <br>
    <?php
		include "../classes/alunoDAO.php";
	   	$dao = new alunoDAO();
	   	$consulta = $dao->consulta(null);
	   	$total =  mysql_num_rows($consulta);
		
		
		echo "<p><strong>Total de alunos cadastrados: </strong>".$total."</p>";
	?>
    <table class="table table-hover table-striped table-bordered">
      <thead>
        <tr>
          <th>Matrícula</th>
          <th>nome</th>
          <th>E-mail</th>
          <th>Curso</th>
          <th>Relatório de aluno</th>
        </tr>
      </thead>
      <tbody>
        <?php
  
   if($total > 0){
	while($linha = mysql_fetch_assoc($consulta)){
		   echo '<tr>
					<td>'.$linha['matricula'].'</td>
					<td>'.$linha['nome'].'</td>
					<td>'.$linha['email'].'</td>
					<td>'.$linha['curso'].'</td>
					<td><a href="print-relatorio-aluno.php?mat='.$linha['matricula'].'">Imprimir relatório</a></td>
					
		</tr>';
	   }
   }else{
	   ?>
      <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Nenhum há alunos cadastrados.</div>
      <?php
	   
   }
  ?>
        </tbody>
      
    </table>
  </section>
  <footer>
    <p>&copy; Copyright 2013 - Instituto Federal Catarinense - Campus Sombrio</p>
  </footer>
</div>
</body>
</html>