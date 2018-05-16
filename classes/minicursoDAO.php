<?php
//include 'conexao.php';
include 'minicurso.php';

class minicursoDAO{
	private $bd;
	
	function __construct(){
		$this->bd = new conexao();	
	}
	function __destruct(){
		$this->bd = new conexao();
		$this->bd->fechar();	
	}
	
	public function consulta($codigo){
		if($codigo == null){
			$sql = "SELECT * FROM minicurso";
		}else{
			$sql = "SELECT * FROM minicurso WHERE codigo = ".$codigo;
		}
		$res = mysql_query($sql);
		return $res;
	}
	
	public function consultaAlunoMinicursos(){
		$sql = "SELECT * FROM minicurso ORDER BY vagas DESC";
		$res = mysql_query($sql);
		return $res;
	}
	
	//Verifica se o aluno ja está cadastrado no minicurso
	public function verificaInscricaoAlunoMinicurso($matricula, $codigo){
		$sql = "SELECT * FROM aluno_minicurso WHERE aluno_matricula = '$matricula' AND minicurso_codigo = '$codigo'";
		$res = mysql_query($sql);
		$total = mysql_num_rows($res);
		if($total > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	public function inserir(minicurso $minicurso){
		$nome = $minicurso->getNome();
		$responsavel = $minicurso->getResponsavel();
		$data = $minicurso->getData();
		$horario = $minicurso->getHorario();
		$local = $minicurso->getLocal();
		$vagas = $minicurso->getVagas();
		$ch = $minicurso->getCargaHoraria();
		$sql = "INSERT INTO minicurso (nome, responsavel, data, horario, local, vagas, carga_horaria) 
						VALUES ('$nome', '$responsavel', '$data', '$horario', '$local', '$vagas', $ch)";
		$res = mysql_query($sql);// or mysql_error();
		if($res)
			return true;
		else
			return false;
		
	}
	public function alterar(minicurso $minicurso){
		$codigo = $minicurso->getCodigo();
		$nome = $minicurso->getNome();
		$responsavel = $minicurso->getResponsavel();
		$data = $minicurso->getData();
		$horario = $minicurso->getHorario();
		$local = $minicurso->getLocal();
		$vagas = $minicurso->getVagas();
		$ch = $minicurso->getCargaHoraria();
		$sql = "UPDATE minicurso set nome = '$nome', responsavel = '$responsavel', data = '$data', horario = '$horario', 
					local = '$local', vagas = $vagas, carga_horaria = $ch WHERE codigo = $codigo";
		$res = mysql_query($sql);// or die(mysql_error());
		if($res)
			return true;
		else
			return false;
		
	}
	
	public function delete(minicurso $minicurso){
		$codigo = (int)$minicurso->getCodigo();
		$sql = "DELETE FROM minicurso WHERE codigo = ".$codigo;
		$res = mysql_query($sql); //or die(mysql_error());
		if($res)
			return true;
		else
			return false;
	}
	
	//Realiza a inscrição do alumo em um minicurso
	public function incricaoAlunoMinicurso($matricula, $codigo){
		$sql = "INSERT INTO aluno_minicurso (aluno_matricula, minicurso_codigo) VALUES ('$matricula', '$codigo')";
		$res = mysql_query($sql) or die(mysql_error());
		if($res){
			$this->diminuiVagas($codigo);
			return true;
		}
		else
			return false;
		
	}
	
	//busca od dados dos minicursos que o aluno esta cadastrado
	public function agendaMinicursosAluno($matricula){
		$sql = "SELECT DISTINCT m.data, m.horario, m.local, m.nome as 'minicurso' from aluno_minicurso am INNER JOIN aluno a 
					INNER JOIN minicurso m ON m.codigo = am.minicurso_codigo AND a.matricula = am.aluno_matricula 
						where a.matricula = '$matricula' ORDER BY m.data, m.horario";
		$res = mysql_query($sql) or die(mysql_error());
		return $res;		
	}

//busca od dados dos minicursos que o aluno esta cadastrado
	public function consultaAlunosMinicurso($codigo){
		
		$sql = "SELECT m.codigo, m.nome as 'nome_minicurso', m.responsavel, m.data, m.horario, m.local, am.presenca, a.nome as 'nome_aluno', a.matricula, a.email FROM aluno a INNER JOIN aluno_minicurso am on a.matricula = am.aluno_matricula INNER JOIN minicurso m on m.codigo = am.minicurso_codigo where m.codigo = $codigo ORDER BY a.nome";
		
		$res = mysql_query($sql) or die(mysql_error());
		return $res;		
	}
	//Consulta os alunos com presencas
	public function consultaAlunosPresencasMinicurso($codigo){
		
		$sql = "SELECT m.codigo, m.nome as 'nome_minicurso', m.responsavel, m.data, m.horario, m.local, am.presenca, a.nome as 'nome_aluno', a.matricula, a.email, am.presenca FROM aluno a INNER JOIN aluno_minicurso am on a.matricula = am.aluno_matricula INNER JOIN minicurso m on m.codigo = am.minicurso_codigo where m.codigo = $codigo AND am.presenca = 1 ORDER BY a.nome";
		
		$res = mysql_query($sql) or die(mysql_error());
		return $res;		
	}


	public function diminuiVagas($codigo){		
		$sql = "UPDATE minicurso set vagas = vagas - 1 WHERE codigo = '$codigo'";
		$res = mysql_query($sql) or die(mysql_error());
	}
	public function aumentaVagas($codigo){		
		$sql = "UPDATE minicurso set vagas = vagas + 1 WHERE codigo = '$codigo'";
		$res = mysql_query($sql) or die(mysql_error());
	}
	
	public function cancelaInscricaoMinicurso($matricula, $codigo){
		$sql = "DELETE FROM aluno_minicurso WHERE aluno_matricula = '$matricula' AND minicurso_codigo = $codigo";
		$res = mysql_query($sql) or die(mysql_error());
		if($res){
			$this->aumentaVagas($codigo);
			return true;
		}
		else
			return false;
		
	}
	
	public function encerrarMinicurso($codigo){
		$sql = "UPDATE minicurso set situacao = 0 WHERE codigo = $codigo";
		$res = mysql_query($sql) or die(mysql_error());
		if($res)
			return true;
		else 
			return false;
	}
	public function abrirMinicurso($codigo){
		$sql = "UPDATE minicurso set situacao = 1 WHERE codigo = $codigo";
		$res = mysql_query($sql) or die(mysql_error());
		if($res)
			return true;
		else 
			return false;
	}
	
	
	public function consultaDataHoraAlunoMinicurso($matricula, $data, $horario){
		$sql = "SELECT m.data, m.horario, m.local, m.nome as 'minicurso' from aluno_minicurso am INNER JOIN aluno a 
					INNER JOIN minicurso m ON m.codigo = am.minicurso_codigo AND a.matricula = am.aluno_matricula 
						where a.matricula = '$matricula' AND m.data = '$data' AND m.horario = '$horario'";
		$res = mysql_query($sql) or die(mysql_error());
		$total = mysql_num_rows($res);	
		if($total > 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function alteraPresenca($matricula, $codigo){
		$sql = "select * from aluno_minicurso WHERE aluno_matricula = $matricula AND minicurso_codigo = $codigo";
		$res = mysql_query($sql) or die(mysql_error());
		$linha = mysql_fetch_array($res);
		if($linha['presenca'] == 1)
			$valor = 0;
		else
			$valor = 1;
			
		$sql2 = "UPDATE aluno_minicurso set presenca = $valor WHERE aluno_matricula = $matricula AND minicurso_codigo = $codigo ";
		$res2 = mysql_query($sql2) or die(mysql_error());
		if($res2){
		echo $sql2;
			return true;
		}else 
			return false;
	}
	public function consultaMinicursosAlunoPresenca($matricula){
		$sql = "select minicurso.nome as 'minicurso', minicurso.carga_horaria, aluno.nome, minicurso.nome from aluno Inner Join aluno_minicurso INNER join minicurso on aluno.matricula = aluno_minicurso.aluno_matricula and minicurso.codigo = aluno_minicurso.minicurso_codigo where aluno_minicurso.presenca = 1 and aluno.matricula = $matricula";
	
		$res = mysql_query($sql) or die(mysql_error());
		return $res;
	
	}
}
?>