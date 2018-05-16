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
  <header><img src="img/logo.png" /></header>
  <section>
    <h1>Inscrição</h1>
    <br>
    <?php
		if(!isset($_POST['cadastrar'])){
	?>
    <form class="form-horizontal" name="form-cadastro" id="form-cadastro" method="post" action="<?php $_SERVER['PHP_SELF'] ?>" >
      <div class="control-group">
        <label class="control-label"  for="curso">Selecione seu curso</label>
        <div class="controls">
          <select name="curso">
            <option value="">Selecione...</option>
            <option value="redes">CST Redes de Computadores</option>
            <option value="informatica">Técnico em Informática</option>
            <option value="comunidade">Comunidade</option>
          </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="mat">CPF </label>
        <div class="controls">
          <input type="text" name="mat" id="mat" class="input-medium">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="nome">Nome completo </label>
        <div class="controls">
          <input type="text" name="nome" id="nome" class="input-xlarge">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="email">E-mail</label>
        <div class="controls">
          <input type="email" name="email" id="email">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="senha">Senha </label>
        <div class="controls">
          <input type="password" name="senha" id="senha" class="input-medium">
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
          <input type="submit" name="cadastrar" value="Cadastrar" class="btn" />
        </div>
      </div>
    </form>
    <?php
		}else{
			include "classes/conexao.php";
			include "classes/alunoDAO.php";
			$aluno = new aluno();
			$dao = new alunoDAO();
			
			if(empty($_POST['mat']) or empty($_POST['nome']) or empty($_POST['senha']) or empty($_POST['curso']) or empty($_POST['email'])){
				echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							Erro.  
						  </div>';
						  die();
			}else if($_POST['senha'] != $_POST['senha2']){
				echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							Senhas não coincidem.  
						  </div>';
						  die();
			}else{
				$aluno->setMatricula($_POST['mat']);
				$aluno->setNome(ucwords(strtolower($_POST['nome'])));
				//$aluno->setSenha(md5($_POST['senha']));
				$aluno->setSenha($_POST['senha']);
				$aluno->setCurso($_POST['curso']);
				$aluno->setEmail($_POST['email']);			
				
				if($dao->inserir($aluno) == true){
					echo '<p class="success">Cadastro efetuado com Sucesso! <a href="login.php">Clique aqui</a> para acessar a sua página</p>';
				}else{
					//echo (mysql_errno());
					echo '<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								Erro. '.mysql_error().' 
							  </div>';
				}
		}}
	?>
  </section>
  <footer>
    <p>&copy; Copyright 2013 - Instituto Federal Catarinense - Campus Sombrio</p>
  </footer>
</div>
</body>
</html>