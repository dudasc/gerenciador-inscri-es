<?php
include "valida_sessao.php";
include "../classes/conexao.php";
include "../classes/minicursoDAO.php";
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
a:hover, img:hover{
	border: none;
	text-decoration: none;
}
</style>
<body>
<div id="geral" class="container">
  <nav>
    <?php include "menu.php";?>
  </nav>
  <section>
    <h1>Mini-cursos cadastrados</h1>
    <br>
    <table class="table table-hover table-striped table-bordered">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Responsável</th>
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
		   $dao = new minicursoDAO();
		   $consulta = $dao->consulta(null);
		   $total =  mysql_num_rows($consulta);
		   	if($total > 0){
			while($linha = mysql_fetch_assoc($consulta)){
				if($linha['situacao'] == 0){
					echo '<tr class="warning">';
					echo '<td>'.$linha['nome'].'</td>';
					echo '<td>'.$linha['responsavel'].'</td>';
					echo '<td>'.implode("/",array_reverse(explode("-",$linha['data']))).'</td>';
					echo '<td>'.$linha['horario'].'</td>';
					echo '<td>'.$linha['local'].'</td>';
					echo '<td>'.$linha['vagas'].' - <strong>[Inscrições encerradas]</strong></td>';
					echo '<td>'.$linha['carga_horaria'].'</td>';
					echo '<td><a href="cad-minicurso.php?cd='.$linha['codigo'].'"									
							title="Editar" class="btn-link" alt="Editar">';
					echo '<i class="icon-edit"></i></a>';
					echo ' <a href="situacao-minicurso.php?op=abrir&cd='.$linha['codigo'].'" 
							title="Abrir inscrições" class="btn-link" alt="Abrir inscrições">';
					echo '<i class="icon-ok-circle"></i></a>';
					echo '</td></tr>';
				}else{
					echo '<tr>';
					echo'<td>'.$linha['nome'].'</td>';
					echo '<td>'.$linha['responsavel'].'</td>';
					echo '<td>'.implode("/",array_reverse(explode("-",$linha['data']))).'</td>';
					echo '<td>'.$linha['horario'].'</td>';
					echo '<td>'.$linha['local'].'</td>';
					echo '<td>'.$linha['vagas'].'</td>';
					echo '<td>'.$linha['carga_horaria'].'</td>';
					echo '<td><a href="cad-minicurso.php?cd='.$linha['codigo'].'"
							title="Editar" class="btn-link" alt="Editar">';
					echo '<i class="icon-edit"></i></a>';
					echo ' <a href="situacao-minicurso.php?op=encerrar&cd='.$linha['codigo'].'" 
							title="Encerrar inscrições" class="btn-link" alt="Encerrar inscrições">';
					echo '<i class="icon-ban-circle"></i></a>';
					echo '</td></tr>';
				}
			}
		}else{
		?>
      <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Não há palestras cadastradas.</div>
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