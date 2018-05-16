<?php
ob_start();
//session_start();
include "valida_sessao.php";
include "./classes/conexao.php";
include "./classes/alunoDAO.php";
include "./classes/login.php";
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
      <li> <a href="cadastroadm.php">Minha agenda</a> </li>
      <li> <a href="aluno-palestras.php">Palestras</a></li>
      <li><a href="aluno-minicursos.php">Minicursos</a></li>
      <li class="active"><a href="meucadastro.php">Meu cadastro</a></li>
      <li class=" pull-right cancela"><form class="form-horizontal" name="form-cadastro" method="post" action="<?php $_SERVER['PHP_SELF'] ?>" >
      <input type="submit" name="excluir" value="Cancelar minha inscrição" class="btn btn-danger" onClick="return confirm('ATENÇÃO: Sua inscrição será cancelada e todos os seus dados serão perdidos. Deseja continuar?')" />
    </form>
    </ul>
    
  </nav>
  <section>
    <?php
  	$matricula = $_SESSION['matricula'];
  	$dao = new alunoDAO();
	$consulta = $dao->consulta($matricula);
	$linha = mysql_fetch_array($consulta);
	?>
    
    <form class="form-horizontal" name="form-cadastro" id="form-cadastro" method="post" >
      <div class="control-group">
        <label class="control-label" for="mat">Nº da matrícula </label>
        <div class="controls">
          <input type="text" name="mat" id="mat" class="input-medium" value="<?= $linha['matricula']?>" disabled>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="curso">Curso</label>
        <div class="controls">
          <select name="curso">
            <option value="<?=$linha['curso']?>">
            <?=$linha['curso']?>
            </option>
          </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="nome">Nome completo </label>
        <div class="controls">
          <input type="text" name="nome" id="nome" class="input-xlarge" value="<?= $linha['nome']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="email">E-mail</label>
        <div class="controls">
          <input type="email" name="email" id="email" value="<?= $linha['email']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="senha">Nova senha </label>
        <div class="controls">
          <input type="password" name="senha" id="senha" class="input-medium" >
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="senha2">Confirmar senha</label>
        <div class="controls">
          <input type="password" name="senha2" id="senha2" class="input-medium">
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <input type="submit" name="alterar" value="Alterar dados" class="btn" />
        </div>
      </div>
    </form>
    <?php
	if(isset($_POST['excluir'])){
		//$dao3 = new alunoDAO();			
		$matricula = $_SESSION['matricula'];
		if($dao->excluir($matricula)){
			$login = new login();
			$login->logout();
			//header("Location: index.php");
		}			
				
		
	}
	if(isset($_POST['alterar'])){
		if(empty($_POST['nome']) or empty($_POST['senha']) or empty($_POST['senha2']) or empty($_POST['curso']) or empty($_POST['email'])){
				echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							Erro. ssss
						  </div>';
						  die();
		}else if($_POST['senha'] != $_POST['senha2']){
			echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							Senhas não coincidem.  
						  </div>';
						  die();
		}else{
				$aluno = new aluno();
				$daoa = new alunoDAO();			
				$aluno->setMatricula($_SESSION['matricula']);
				$aluno->setNome(ucwords(strtolower($_POST['nome'])));
				//$aluno->setSenha(md5($_POST['senha']));
				$aluno->setSenha($_POST['senha']);
				$aluno->setEmail($_POST['email']);
				
				if($daoa->alterar($aluno) == true){
					echo '<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								Cadastro alterado com sucesso. 
							  </div>';
				}else{
					//echo (mysql_errno());
					echo '<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								Erro. '.mysql_error().' 
							  </div>';
				}
			}
		
	}
	?>
  </section>
  <footer>
    <p>&copy; Copyright 2013 - Instituto Federal Catarinense - Campus Sombrio</p>
  </footer>
</div>
</body>
</html>