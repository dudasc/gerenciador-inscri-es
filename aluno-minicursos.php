<?php
ob_start();
session_start();
include "valida_sessao.php";
include "./classes/conexao.php";
include "./classes/alunoDAO.php";
include "./classes/minicursoDAO.php";
include "./classes/palestraDAO.php";
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
        <?=$_SESSION['matricula'] ?>
        | <a href="logout.php">Sair</a> </p>
    </div>
  </header>
  <nav>
    <ul class="nav nav-pills ">
      <li> <a href="cadastroadm.php">Minha agenda</a> </li>
      <li> <a href="aluno-palestras.php">Palestras</a> </li>
      <li class="active"> <a href="aluno-minicursos.php">Minicursos</a> </li>
      <li> <a href="meucadastro.php">Meu cadastro</a> </li>
    </ul>
  </nav>
  <section>
    <?php
		if (isset($_POST['bt-inscricao'])) {
			$codigo = (int)$_POST['codigo'];
			$vagas = (int)$_POST['vagas'];
			$data = $_POST['data'];
			$horario = $_POST['horario'];
			$dao = new minicursoDAO();
			$consulta = $dao -> consulta($codigo);
			$linha = mysql_fetch_assoc($consulta);
			if ($vagas == 0) {
				echo '<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Não há vagas nesse curso. </div>';
			} else if ($dao -> consultaDataHoraAlunoMinicurso($_SESSION['matricula'], $data, $horario) == true) {
				echo '<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Você ja está inscrito em um minicurso no mesmo horário. 
				  </div>';
			} else if ($dao -> incricaoAlunoMinicurso($_SESSION['matricula'], $linha['codigo']) == true) {
				echo '<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Inscrição realizada com sucesso.</div>';
			}
		}
		if (isset($_POST['bt-cancela'])) {
			$codigo = (int)$_POST['codigo'];
			$vagas = (int)$_POST['vagas'];
			$data = $_POST['data'];
			$horario = $_POST['horario'];
			$dao = new minicursoDAO();
			$consulta = $dao -> consulta($codigo);
			$linha = mysql_fetch_assoc($consulta);
			if ($dao -> verificaInscricaoAlunoMinicurso($_SESSION['matricula'], $linha['codigo']) == true) {
				if ($dao -> cancelaInscricaoMinicurso($_SESSION['matricula'], $linha['codigo']) == true) {
					echo '<div class="alert alert-info">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Inscrição cancelada com sucesso.</div>';
				}
			} else {
				echo '<div class="alert alert-sucess">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Erro ao cancelar inscrição.</div>';
			}
		}
		?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Data/horário</th>
          <th>Local</th>
          <th>Vagas restantes</th>
          <th>Inscrição</th>
        </tr>
      </thead>
      <tbody>
        <?php
	$daom = new minicursoDAO();
	$consulta = $daom -> consultaAlunoMinicursos();
	$total = mysql_num_rows($consulta);
	if ($total > 0) {
		while ($linha = mysql_fetch_assoc($consulta)) {
			//se tiver vagas, se o curso estiver aberto e o aluno ainda nao estiver inscrito
			if ($linha['vagas'] > 0 and 
				$daom->verificaInscricaoAlunoMinicurso($_SESSION['matricula'], $linha['codigo']) == 0 
				and $linha['situacao'] == 1) {				   					
				echo '<tr><td>' . $linha['nome'] . '</td>';
				echo '<td>';
				echo implode("/", array_reverse(explode("-", $linha['data']))).' - '.$linha['horario'];
				echo '</td>';
				echo '<td>' . $linha['local'] . '</td>';
				echo '<td>' . $linha['vagas'] . '</td>';
				echo '<form name="form-cadastro-minicurso" method="post">';
				echo '<input type="hidden" name="codigo" value="' . $linha['codigo'] . '" />';
				echo '<input type="hidden" name="vagas" value="' . $linha['vagas'] . '" />';
				echo '<input type="hidden" name="data" value="' . $linha['data'] . '" />';
				echo '<input type="hidden" name="horario" value="' . $linha['horario'] . '" />';
				echo '<td><input type="submit" name="bt-inscricao" value="Inscrever-se" class="btn-link"/>';
				echo '</form></td></tr>';
			} else if ($daom -> verificaInscricaoAlunoMinicurso($_SESSION['matricula'], 
				$linha['codigo']) > 0 and $linha['situacao'] == 1) {
				echo '<tr class="success">';
				echo '<td>' . $linha['nome'] . '</td>';
				echo '<td>';
				echo implode("/", array_reverse(explode("-", $linha['data']))).' - '.$linha['horario'];
				echo '</td>';
				echo '<td>'.$linha['local'].'</td>';
				echo '<td>'.$linha['vagas'].'</td>';
				echo '<form name="form-cadastro-minicurso" method="post">';
				echo '<input type="hidden" name="codigo" value="' . $linha['codigo'] . '" />';
				echo '<input type="hidden" name="vagas" value="' . $linha['vagas'] . '" />';
				echo '<input type="hidden" name="data" value="' . $linha['data'] . '" />';
				echo '<input type="hidden" name="horario" value="' . $linha['horario'] . '" />';
				echo '<td><input type="submit" name="bt-cancela" value="Cancelar inscrição" class="btn-link"
				onClick="return confirm(\'Deseja cancelar a inscrição nesse curso?\')"/></form></td>';
			}else if($linha['situacao'] == 0){
				echo '<tr class="error">';
				echo '<td>' . $linha['nome'] . '</td>';
				echo '<td>';
				echo implode("/", array_reverse(explode("-", $linha['data']))).' - '.$linha['horario'];
				echo '</td>';
				echo '<td>' . $linha['local'] . '</td>';
				echo '<td>' . $linha['vagas'] . '</td>';
				echo '<td>Encerrado</td></tr>';
			}else if ($linha['vagas'] <= 0){
				echo '<tr class="error">';
				echo '<td>' . $linha['nome'] . '</td>';
				echo '<td>';
				echo implode("/", array_reverse(explode("-", $linha['data']))).' - '.$linha['horario'];
				echo '</td>';
				echo '<td>' . $linha['local'] . '</td>';
				echo '<td>' . $linha['vagas'] . '</td>';
				echo '<td>Não há vagas</td></tr>';
			}
		}
	}
	?>
      </tbody>
    </table>
  </section>
  <footer>
    <p> &copy; Copyright 2013 - Instituto Federal Catarinense - Campus Sombrio </p>
  </footer>
</div>
</body>
</html>
