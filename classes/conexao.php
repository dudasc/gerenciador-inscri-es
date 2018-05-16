<?php

class conexao{
	var $con;
	var $host = "localhost";
	var $usuario = "root";
	var $senha = "";
	
	function conexao(){
		$this->con = mysql_connect($this->host, $this->usuario, $this->senha) or die(mysql_error());		
		mysql_select_db("semana_academica2013", $this->con);
	}
	
	function fechar(){		
		mysql_close($this->con);
	}	
}
?>