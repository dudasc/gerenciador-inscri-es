<?php
session_start();
ob_start();
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
  <header><img src="img/logo.png" /></header>
  <section>
    <h1>Login</h1>
    <br>
    <?php
		if(isset($_POST['bt-login'])){
			include "classes/conexao.php";
			include "classes/alunoDAO.php";
			include "classes/login.php";
			$matricula = $_POST['mat'];
			//$senha = md5($_POST['senha']);
			$senha = $_POST['senha'];
			$dao = new alunoDAO();
			$consulta = $dao->consulta($matricula);
			$total = @mysql_num_rows($consulta);
		
			if($total>0){
				if($linha = mysql_fetch_assoc($consulta)){
					if ($senha == $linha["senha"]) {
							$login = new login();
							$login->logar($linha['matricula']);
					}else{
						echo '<center><p class="error">Usuário não encontrado.</p></center>';
					}
				}
			}else{
					echo '<center><p class="error">Usuário não encontrado.</p></center>';
				}
			
		}
	?>
    <form class="form-horizontal" name="form-login" id="form-login" method="post">
      <div class="control-group">
        <label class="control-label"  for="matricula">Nº da matrícula</label>
        <div class="controls">
          <input type="text" name="mat" id="mat">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="senha">Senha</label>
        <div class="controls">
          <input type="password" name="senha" id="senha">
          <span class="help-block"><a href="#modal-recovery" data-toggle="modal">Esqueci minha senha</a></span> </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <input type="submit" name="bt-login" value="Login" class="btn" />
        </div>
      </div>
    </form>
    
    <!-- Janeça modal recuperar senha -->
    
    <div id="modal-recovery" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Recuperar senha</h3>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" name="form-login-recovery" id="form-login-recovery" method="post" action="javascript:;">
          <div class="control-group">
            <label class="control-label"  for="matricula">Informe seu e-mail</label>
            <div class="controls">
              <input type="email" name="email" id="email" class="input-xlarge">
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <input type="submit" name="bt-login-recovery" value="Enviar" class="btn" />
            </div>
          </div>
        </form>
        <div id="msg"></div>
      </div>
      
      <div class="modal-footer"> </div>
    </div>
  </section>
  <footer>
    <p>&copy; Copyright 2013 - Instituto Federal Catarinense - Campus Sombrio</p>
  </footer>
</div>
</body>
</html>