<?php
class minicurso{
	var $codigo;
	var $nome;
	var $data;
	var $local;
	var $horario;
	var $responsavel;
	var $vagas;
	var $cargaHoraria;
	
	public function setCodigo($codigo){
		$this->codigo = $codigo;
	}
	public function setNome($nome){
		$this->nome = $nome;
	}
	public function setData($data){
		$this->data = $data;
	}
	public function setHorario($horario){
		$this->horario = $horario;
	}
	public function setLocal($local){
		$this->local = $local;
	}
	public function setResponsavel($responsavel){
		$this->responsavel = $responsavel;
	}
	public function setVagas($vagas){
		$this->vagas = $vagas;
	}
	public function setCargaHoraria($cargaHoraria){
		$this->cargaHoraria = $cargaHoraria;
	}
	
	public function getCodigo(){
		return $this->codigo;
	}
	public function getNome(){
		return $this->nome;
	}
	
	public function getData(){
		return $this->data;
	}
	public function getHorario(){
		return $this->horario;
	}
	public function getLocal(){
		return $this->local;
	}
	public function getResponsavel(){
		return $this->responsavel;
	}
	public function getVagas(){
		return $this->vagas;
	}
	public function getCargaHoraria(){
		return $this->cargaHoraria;
	}
}
?>