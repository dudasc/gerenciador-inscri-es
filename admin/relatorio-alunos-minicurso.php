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
</style>
<body>
<div id="geral" class="container">
  <nav>
    <?php
		include "menu.php";
	?>
  </nav>
  <section>
    <h1>Relatório de alunos por mini-curso</h1>
    <br>
    <form class="form-horizontal" method="post" id="form-busca-alunos" action="relatorio-alunos-minicurso.php">
      <div class="control-group">
        <label class="control-label" for="minicurso">Buscar minicurso</label>
        <div class="controls">
          <select name="minicurso">
            <option value="">Selecione um minicurso...</option>
            <?php
            $dao = new minicursoDAO();
            $consulta = $dao->consulta(null);
            while($linha = mysql_fetch_assoc($consulta)){
                echo '<option value="'.$linha['codigo'].'">'.$linha['nome'].'</option>';
            }
        ?>
          </select>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <input type="submit" value="Buscar" name="bt-buscar" class="btn btn-primary" />
        </div>
      </div>
    </form>
    <?php
	if(isset($_POST['bt-buscar'])){
		if(empty($_POST['minicurso'])){
				echo '  <div class="alert alert-info">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Selecione uma opção.</div>';
		}else{
			$codigo = $_POST['minicurso'];
			$consulta = $dao->consultaAlunosMinicurso($codigo);
			$total = mysql_num_rows($consulta);
			if($total == 0){
				$consulta2 = $dao->consulta($codigo);
				$linha = mysql_fetch_array($consulta2);
				echo "<p><strong>Nome: </strong>".$linha["nome"];
				echo "<br><strong>Data: </strong>".implode("/",array_reverse(explode("-",$linha["data"])))." - ".$linha["horario"];
				echo "<br><strong>Local: </strong>".$linha["local"]."</p>";
				echo '<hr><div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>
					Nenhum aluno matriculado neste mini-curso.</div>';
			}else{	
				echo "<p><strong>Nome: </strong>".@mysql_result($consulta,0,"nome_minicurso");
				echo "<br><strong>Data: </strong>".implode("/",array_reverse(explode("-",@mysql_result($consulta,0,"data"))))." - ".@mysql_result($consulta,0,"horario");
				echo "<br><strong>Local: </strong>".@mysql_result($consulta,0,"local");	
				echo '<br><strong>Total de alunos: </strong>'.$total."</p>";	
				echo '    <a class="btn" href="print-minicurso.php?cd='.mysql_result($consulta,0,"codigo").'" target="_blank" "><i class="icon-print"></i> Lista de chamada</a>'; 
				echo ' <a class="btn" href="print-presencas-minicurso.php?cd='.mysql_result($consulta,0,"codigo").'" target="_blank" "><i class="icon-print"></i> Relatório de presenças</a>'; 
				
				
				
	?>

<br><br>
<div id="carregando"></div>
    <table class="table table-hover table-striped table-bordered">
      <thead>
        <tr>
          <th>Matricula/CPF</th>
          <th>Nome do aluno</th>
          <th>E-mail</th>
          <th>Presença</th>
        </tr>
      </thead>
      <tbody>
      <div id="res"></div>
      <form name="form-presencas">
      
      <?php
			  	echo '<input type="hidden" id="codigo-minicurso" value="'.$codigo.'"/>';
				$consulta = $dao->consultaAlunosMinicurso($codigo);		
				while($linha = mysql_fetch_array($consulta)){
					
					($linha['presenca'] == 1) ? $checked = 'checked' : $checked = null;
					
					echo"<tr>";
					echo "<td>";
					echo $linha['matricula'];
					echo"</td>";
					echo "<td>";
					echo $linha['nome_aluno'];
					echo"</td>";
					echo "<td>";
					echo $linha['email'];
					echo"</td>";
					echo "<td>";
					echo '<input class="checkbox-presencas-minicurso" name="presenca" '.$checked.' type="checkbox" value="'.$linha['matricula'].'" /> 
					<img src="../img/loading-mini.gif" class="carregando-presenca"/>';
					echo"</td>";
					echo "</tr>";
					
					
				}
			}
		}
	}
	?>

    </form>
      </tbody>
    </table>
   
  </section>
  <footer>
    <p>&copy; Copyright 2013 - Instituto Federal Catarinense - Campus Sombrio</p>
  </footer>
</div>
</body>
</html>