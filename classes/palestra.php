<?php
class palestra{
	var $codigo;
	var $tema;
	var $palestrante;
	var $data;
	var $local;
	var $horario;
	var $empresa;
	var $vagas;
	var $cargaHoraria;
	
	public function setCodigo($codigo){
		$this->codigo = $codigo;
	}
	public function setTema($tema){
		$this->tema = $tema;
	}
	public function setPalestrante($palestrante){
		$this->palestrante = $palestrante;
	}
	public function setData($data){
		$this->data = $data;
	}
	public function setLocal($local){
		$this->local = $local;
	}
	public function setHorario($horario){
		$this->horario = $horario;
	}
	public function setEmpresa($empresa){
		$this->empresa = $empresa;
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
	public function getTema(){
		return $this->tema;
	}
	public function getPalestrante(){
		return $this->palestrante;
	}
	public function getData(){
		return $this->data;
	}
	public function getLocal(){
		return $this->local;
	}
	public function getHorario(){
		return $this->horario;
	}
	public function getEmpresa(){
		return $this->empresa;
	}
	public function getVagas(){
		return $this->vagas;
	}
	public function getCargaHoraria(){
		return $this->cargaHoraria;
	}
}
?>