<?php
ob_start();
session_start();
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

<body>
<div id="geral" class="container">
  <header><img src="../img/logo.png" /></header>
  <section>
    <h1>Adminstração</h1>
    <br>
    <form class="form-horizontal" name="form-login" id="form-login" method="post">
      <div class="control-group">
        <label class="control-label"  for="login">Login</label>
        <div class="controls">
          <input type="text" name="login" id="login">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="senha">Senha</label>
        <div class="controls">
          <input type="password" name="senha" id="senha">
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <input type="submit" name="bt-login" value="Login" class="btn" />
        </div>
      </div>
    </form>
    <?php
		if(isset($_POST['bt-login'])){
			include "../classes/login.php";
			$login = "redesifc";
			$senha = "123";
			if($_POST['login'] == $login and $_POST['senha'] == $senha){					
					$login_adm = new login();
					$login_adm->logarAdm($login);
			}else{
					echo '<center><p class="error">Usuário não encontrado</p></center>';
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