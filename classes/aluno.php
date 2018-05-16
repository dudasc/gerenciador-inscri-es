<?php
class aluno{
	var $matricula;
	var $nome;
	var $senha;
	var $curso;
	var $email;
	
	public function setMatricula($matricula){
		$this->matricula = $matricula;		
	}
	public function setNome($nome){
		$this->nome = $nome;		
	}
	public function setSenha($senha){
		$this->senha = $senha;		
	}
	public function setCurso($curso){
		$this->curso = $curso;		
	}
	public function setEmail($email){
		$this->email = $email;		
	}
	
	public function getMatricula(){
		return $this->matricula;
	}
	public function getNome(){
		return $this->nome;
	}
	public function getSenha(){
		return $this->senha;
	}
	public function getCurso(){
		return $this->curso;
	}
	public function getEmail(){
		return $this->email;
	}
	
	
	
	
}
?>