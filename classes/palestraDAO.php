<?php
//include 'conexao.php';
include 'palestra.php';

class palestraDAO {
	private $bd;

	function __construct() {
		$this -> bd = new conexao();
	}

	function __destruct() {
	$this -> bd = new conexao();
		$this -> bd -> fechar();
	}

	public function consulta($codigo) {
		if ($codigo == null) {
			$sql = "SELECT * FROM palestra";
		} else {
			$sql = "SELECT * FROM palestra WHERE codigo = " . $codigo;
		}
		$res = mysql_query($sql);
		return $res;
	}

	public function inserir(palestra $palestra) {
		$tema = $palestra -> getTema();
		$palestrante = $palestra -> getPalestrante();
		$data = $palestra -> getData();
		$horario = $palestra -> getHorario();
		$local = $palestra -> getLocal();
		$empresa = $palestra -> getEmpresa();
		$vagas = $palestra -> getVagas();
		$ch = $palestra -> getCargaHoraria();
		$sql = "INSERT INTO palestra (tema, palestrante, data, horario, local, empresa, vagas, carga_horaria) 
						VALUES ('$tema', '$palestrante', '$data', '$horario', '$local', '$empresa', '$vagas', '$ch')";
		$res = mysql_query($sql);
		// or mysql_error();
		if ($res)
			return true;
		else
			return false;

	}

	public function alterar(palestra $palestra) {
		$codigo = $palestra -> getCodigo();
		$tema = $palestra -> getTema();
		$palestrante = $palestra -> getPalestrante();
		$data = $palestra -> getData();
		$local = $palestra -> getLocal();
		$horario = $palestra -> getHorario();
		$empresa = $palestra -> getEmpresa();
		$vagas = $palestra -> getVagas();
		$ch = $palestra -> getCargaHoraria();
		$sql = "UPDATE palestra set tema = '$tema', palestrante = '$palestrante', data = '$data', horario = '$horario', local = '$local', empresa = '$empresa', vagas = $vagas, carga_horaria = $ch WHERE codigo = $codigo";
		$res = mysql_query($sql);
		// or die(mysql_error());
		if ($res)
			return true;
		else
			return false;

	}

	public function delete(palestra $palestra) {
		$codigo = (int)$palestra -> getCodigo();
		$sql = "DELETE FROM palestra WHERE codigo = " . $codigo;
		$res = mysql_query($sql);
		//or die(mysql_error());
		if ($res)
			return true;
		else
			return false;
	}

	public function consultaAlunoPalestras() {
		$sql = "SELECT * FROM palestra ORDER BY vagas DESC";
		$res = mysql_query($sql);
		return $res;
	}

	public function verificaInscricaoAlunoPalestra($matricula, $codigo) {
		$sql = "SELECT * FROM aluno_palestra WHERE aluno_matricula = '$matricula' AND palestra_codigo = '$codigo'";
		$res = mysql_query($sql);
		$total = mysql_num_rows($res);
		if ($total > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function incricaoAlunoPalestra($matricula, $codigo) {
		$sql = "INSERT INTO aluno_palestra (aluno_matricula, palestra_codigo) VALUES ('$matricula', '$codigo')";
		$res = mysql_query($sql) or die(mysql_error());
		if ($res) {
			$this -> diminuiVagas($codigo);
			return true;
		} else
			return false;

	}

	public function diminuiVagas($codigo) {
		$sql = "UPDATE palestra set vagas = vagas - 1 WHERE codigo = '$codigo'";
		$res = mysql_query($sql) or die(mysql_error());
	}

	public function aumentaVagas($codigo) {
		$sql = "UPDATE palestra set vagas = vagas + 1 WHERE codigo = '$codigo'";
		$res = mysql_query($sql) or die(mysql_error());
	}

	public function cancelaInscricaoPalestra($matricula, $codigo) {
		$sql = "DELETE FROM aluno_palestra WHERE aluno_matricula = '$matricula' AND palestra_codigo = $codigo";
		$res = mysql_query($sql) or die(mysql_error());
		if ($res) {
			$this -> aumentaVagas($codigo);
			return true;
		} else
			return false;

	}
	
	public function agendaPalestrasAluno($matricula){
		$sql = "SELECT DISTINCT p.data, p.horario, p.local, p.palestrante, p.tema as 'tema' from aluno_palestra ap INNER JOIN aluno a 
					INNER JOIN palestra p ON p.codigo = ap.palestra_codigo AND a.matricula = ap.aluno_matricula 
						where a.matricula = '$matricula' ORDER BY p.data, p.horario";
		$res = mysql_query($sql) or die(mysql_error());
		return $res;		
	}

	public function consultaDataHoraAlunoPalestra($matricula, $data, $horario) {
		$sql = "SELECT p.data, p.horario, p.local, p.tema as 'palestra' from aluno_palestra ap INNER JOIN aluno a 
					INNER JOIN palestra p ON p.codigo = ap.palestra_codigo AND a.matricula = ap.aluno_matricula 
						where a.matricula = '$matricula' AND p.data = '$data' AND p.horario = '$horario'";
		$res = mysql_query($sql) or die(mysql_error());
		$total = mysql_num_rows($res);
		if ($total > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function consultaAlunosPalestra($codigo){
		
		$sql = "SELECT p.codigo, p.tema as 'tema', p.palestrante, p.empresa, p.data, p.horario, p.local, a.nome as 'nome_aluno', a.matricula, a.email, ap.presenca FROM aluno a INNER JOIN aluno_palestra ap on a.matricula = ap.aluno_matricula INNER JOIN palestra p on p.codigo = ap.palestra_codigo where p.codigo = $codigo ORDER BY a.nome";
		
		$res = mysql_query($sql) or die(mysql_error());
		return $res;		
	}
	
	public function consultaAlunosPresencasPalestra($codigo){
		
		$sql = "SELECT p.codigo, p.tema as 'tema', p.palestrante, p.empresa, p.data, p.horario, p.local, a.nome as 'nome_aluno', a.matricula, a.email, ap.presenca FROM aluno a INNER JOIN aluno_palestra ap on a.matricula = ap.aluno_matricula INNER JOIN palestra p on p.codigo = ap.palestra_codigo where p.codigo = $codigo AND ap.presenca = 1 ORDER BY a.nome";
		
		$res = mysql_query($sql) or die(mysql_error());
		return $res;		
	}

	/*
	 public function consultaAlunoPalestras($codigo){
	 $sql = "SELECT p.tema as 'tema_palestra', p.data, p.horario, p.local, a.nome as 'nome_aluno', a.matricula FROM aluno a INNER JOIN aluno_palestra ap on a.matricula = ap.aluno_palestra INNER JOIN palestra p on p.codigo = ap.palestra_codigo where p.codigo = $codigo";

	 $res = mysql_query($sql) or die(mysql_error());
	 return $res;
	 }*/
	 
	 
	 public function encerrarPalestra($codigo){
		$sql = "UPDATE palestra set situacao = 0 WHERE codigo = $codigo";
		$res = mysql_query($sql) or die(mysql_error());
		if($res)
			return true;
		else 
			return false;
	}
	public function abrirPalestra($codigo){
		$sql = "UPDATE palestra set situacao = 1 WHERE codigo = $codigo";
		$res = mysql_query($sql) or die(mysql_error());
		if($res)
			return true;
		else 
			return false;
	}
	
	
	
	public function alteraPresenca($matricula, $codigo){
		$sql = "select * from aluno_palestra WHERE aluno_matricula = $matricula AND palestra_codigo = $codigo";
		$res = mysql_query($sql) or die(mysql_error());
		$linha = mysql_fetch_array($res);
		if($linha['presenca'] == 1)
			$valor = 0;
		else
			$valor = 1;
			
		$sql2 = "UPDATE aluno_palestra set presenca = $valor WHERE aluno_matricula = $matricula AND palestra_codigo = $codigo ";
		$res2 = mysql_query($sql2) or die(mysql_error());
		if($res2){
		echo $sql2;
			return true;
		}else 
			return false;
	}
	
	
	public function consultaPalestrasAlunoPresenca($matricula){
		$sql = "select palestra.tema as 'palestra', palestra.carga_horaria from aluno INNER JOIN aluno_palestra INNER JOIN palestra on aluno.matricula = aluno_palestra.aluno_matricula and palestra.codigo = aluno_palestra.palestra_codigo where aluno_palestra.presenca = 1 and aluno.matricula = $matricula";
	
		$res = mysql_query($sql) or die(mysql_error());
		return $res;
	
	}
}
?>