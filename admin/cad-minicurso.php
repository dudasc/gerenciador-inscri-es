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
    <h1>Cadastro de mini-curso</h1>
    <br>
    <?php
		if(isset($_GET['cd'])){
			$codigo = (int)@$_GET['cd'];
			$dao = new minicursoDAO();
			$consulta = $dao->consulta($codigo);
			$linha = mysql_fetch_assoc($consulta);
		?>
    <form class="form-horizontal" name="form-cadastro-minicurso" id="form-cadastro-minicurso" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
      <fieldset>
      <input type="hidden" name="codigo" id="codigo" class="input-xlarge" value="<?=$linha['codigo']?>" >
      <div class="control-group">
        <label class="control-label" for="nome">Nome</label>
        <div class="controls">
          <input type="text" name="nome" id="nome" class="input-xlarge" value="<?=$linha['nome']?>" >
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="res">Nome do responsável</label>
        <div class="controls">
          <input type="text" name="res" id="res" class="input-xlarge" value="<?=$linha['responsavel']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="data">Data</label>
        <div class="controls">
          <input type="date" name="data" id="data" class="input-medium" value="<?=$linha['data']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="hora">Horário</label>
        <div class="controls">
          <input type="time" name="hora" id="hora" class="input-medium" value="<?=$linha['horario']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="local">Local</label>
        <div class="controls">
          <input type="text" name="local" id="local" class="input-xlarge" value="<?=$linha['local']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="vagas">Nº de vagas</label>
        <div class="controls">
          <input type="text" name="vagas" class="input-mini" id="vagas" value="<?=$linha['vagas']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="vagas">Carga horária</label>
        <div class="controls">
          <input type="text" name="carga_horaria" id="carga_horaria" class="input-mini" value="<?=$linha['carga_horaria']?>">
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <input type="submit" name="excluir" value="Excluir" class="btn btn-danger" onClick="return confirm('Confirmar exclusão?')" />
          <input type="submit" name="atualizar" value="Atualizar dados" class="btn btn-primary" />
        </div>
      </div>
    </form>
    <?php 
			if(isset($_POST['excluir'])){
				$minicurso = new minicurso();
				$minicurso->setCodigo($linha['codigo']);				
				if($dao->delete($minicurso) == true){
					header("location: listar-minicursos.php");
				}
			}
			
			if(isset($_POST['atualizar'])){
			$minicurso = new minicurso();
			//$dao = new minicursoDAO();
			$minicurso->setCodigo($_POST['codigo']);
			$minicurso->setNome($_POST['nome']);
			$minicurso->setResponsavel($_POST['res']);
			$minicurso->setLocal($_POST['local']);
			$minicurso->setData(implode("-",array_reverse(explode("/",$_POST['data']))));
			$minicurso->setHorario($_POST['hora']);
			$minicurso->setVagas($_POST['vagas']);
			$minicurso->setCargaHoraria($_POST['carga_horaria']);
			if($dao->alterar($minicurso) == true){
					header("location: listar-minicursos.php");
				}else{
					echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							Erro. '.mysql_error().' 
						  </div>';
				}
			}
		}else{
	?>
    <form class="form-horizontal" name="form-cadastro-minicurso" id="form-cadastro-minicurso" method="post">
      <fieldset>
      <div class="control-group">
        <label class="control-label" for="nome">Nome</label>
        <div class="controls">
          <input type="text" name="nome" id="nome" class="input-xlarge" >
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="res">Nome do responsável</label>
        <div class="controls">
          <input type="text" name="res" id="res" class="input-xlarge">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="data">Data</label>
        <div class="controls">
          <input type="date" name="data" id="data" class="input-medium">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="hora">Horário</label>
        <div class="controls">
          <input type="time" name="hora" id="hora" class="input-medium">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="local">Local</label>
        <div class="controls">
          <input type="text" name="local" id="local" class="input-xlarge">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="vagas">Nº de vagas</label>
        <div class="controls">
          <input type="text" name="vagas" class="input-mini" id="vagas">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"  for="vagas">Carga horária</label>
        <div class="controls">
          <input type="text" name="carga_horaria" id="carga_horaria" class="input-mini">
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-primary" />
        </div>
      </div>
    </form>
    <?php
		if(isset($_POST['cadastrar'])){			
			$minicurso = new minicurso();
			$dao = new minicursoDAO();
			$minicurso->setNome($_POST['nome']);
			$minicurso->setResponsavel($_POST['res']);
			$minicurso->setLocal($_POST['local']);
			$minicurso->setData(implode("-",array_reverse(explode("/",$_POST['data']))));
			$minicurso->setHorario($_POST['hora']);
			$minicurso->setVagas($_POST['vagas']);
			$minicurso->setCargaHoraria($_POST['carga_horaria']);
			if($dao->inserir($minicurso) == true){
				echo '<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				Cadastro realizado com sucesso
				</div>';
			}else{
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