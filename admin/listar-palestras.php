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
    <h1>Palestras cadastradas</h1>
    <br>
    <table class="table table-hover table-striped table-bordered">
      <thead>
        <tr>
          <th>Tema</th>
          <th>Palestrante</th>
          <th>Empresa</th>
          <th>Data</th>
          <th>Horário</th>
          <th>Local</th>
          <th>Nº de vagas</th>
          <th>CH</th>
          <th class="inline">Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php
  	include "../classes/palestraDAO.php";
   	$dao = new palestraDAO();
	$consulta = $dao->consulta(null);
	$total =  mysql_num_rows($consulta);
	if($total > 0){
		while($linha = mysql_fetch_assoc($consulta)){
			if($linha['situacao'] == 0){
				echo '<tr class="warning">';
				echo '<td>'.$linha['tema'].'</td>';
				echo '<td>'.$linha['palestrante'].'</td>';
				echo '<td>'.$linha['empresa'].'</td>';
				echo '<td>'.implode("/",array_reverse(explode("-",$linha['data']))).'</td>';
				echo '<td>'.$linha['horario'].'</td>';
				echo '<td>'.$linha['local'].'</td>';
				echo '<td>'.$linha['vagas'].' - <strong>[Inscrições encerradas]</strong></td>';
				echo '<td>'.$linha['carga_horaria'].'</td>';
				echo '<td>';
				echo '<a href="cad-palestra.php?cd='.$linha['codigo'].'" title="Editar" 
					class="btn-link" alt="Editar"><i class="icon-edit"></i></a>';
					echo ' <a href="situacao-palestra.php?op=abrir&cd='.$linha['codigo'].'" 
						title="Abrir inscrições" class="btn-link" alt="Abrir Inscrições">';
				echo '<i class="icon-ok-circle"></i></a>';
				echo '</td></tr>';
			}else{
				echo '<tr><td>'.$linha['tema'].'</td>';
				echo '<td>'.$linha['palestrante'].'</td>';
				echo '<td>'.$linha['empresa'].'</td>';
				echo '<td>'.implode("/",array_reverse(explode("-",$linha['data']))).'</td>';
				echo '<td>'.$linha['horario'].'</td>';
				echo '<td>'.$linha['local'].'</td>';
				echo '<td>'.$linha['vagas'].'</td>';
				echo '<td>'.$linha['carga_horaria'].'</td>';
				echo '<td>';
				echo '<a href="cad-palestra.php?cd='.$linha['codigo'].'" title="Editar" 
					class="btn-link" alt="Editar"><i class="icon-edit"></i></a>';
				echo ' <a href="situacao-palestra.php?op=encerrar&cd='.$linha['codigo'].'" 
							title="Encerrar inscrições" class="btn-link" alt="Encerrar inscrições">';
				echo '<i class="icon-ban-circle"></i></a>';
				echo '</td></tr>';
			}
		}
	}else{
	?>
      <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Não há palestras cadastradas. </div>
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