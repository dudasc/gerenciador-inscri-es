<?php
//include 'conexao.php';
include 'aluno.php';

class alunoDAO{
	private $bd;
	
	function __construct(){
		$this->bd = new conexao();	
	}
	function __destruct(){
		$this->bd = new conexao();
		$this->bd->fechar();	
	}
	
	public function consulta($matricula){
		if($matricula == null){
			$sql = "SELECT * FROM aluno ORDER BY nome";
		}else{
			$sql = "SELECT * FROM aluno WHERE matricula = ".$matricula;
		}
		$res = mysql_query($sql);
		return $res;
	}
	//verifica se a matricula ja existe 
	public function verificaUsuario($matricula){
		$sql = "SELECT matricula FROM aluno WHERE matricula = $matricula";
		$res = mysql_query($sql);
		return mysql_num_rows($res); 
	}
	public function buscaEmail($email){
		$sql = "SELECT * FROM aluno WHERE email = '$email'";
		$res = mysql_query($sql);
		return $res; 
	}
	
	public function verificaUsuarioEmail($email){
		$sql = "SELECT * FROM aluno WHERE email = $email";
		$res = mysql_query($sql);
		return mysql_num_rows($res); 
	}
	public function inserir(aluno $aluno){
		$matricula = $aluno->getMatricula();
		$nome = $aluno->getNome();
		$curso = $aluno->getCurso();
		$senha = $aluno->getSenha();
		$email = $aluno->getEmail();
		
		if($this->verificaUsuario($matricula) > 0){
			echo '<p class="error">Essa matricula de usuário ja foi cadastrada.</p>';
			exit;
			//return false;
		}else{
			$sql = "INSERT INTO aluno (matricula, nome, curso, senha, email)
								VALUES ('$matricula', '$nome', '$curso', '$senha', '$email')";
			$res = mysql_query($sql);// or die(mysql_error());
			if($res)
				return true;
			else
				return false;
		}
	}
	
	public function alterar(aluno $aluno){
		$sql = "UPDATE aluno SET nome = '".$aluno->getNome()."', 
									  email = '".$aluno->getEmail()."',
									  senha = '".$aluno->getSenha()."'
									  WHERE matricula = ".$aluno->getMatricula();
		$res = mysql_query($sql);// or die(mysql_error());
		if($res)
			return true;
		else
			return false;
	}
	
	public function excluir($matricula){
		$sql = "DELETE FROM aluno WHERE matricula = ".$matricula;
		$res = mysql_query($sql) or die(mysql_error());
		if($res)
			return true;
		else
			return false;		
	}
}
?>