<?php

class login{
	
	public function logar($matricula){
			$_SESSION["matricula"] = $matricula;
			setcookie('matricula', $matricula);		
 			header("location: ./cadastroadm.php");
	}
	
	public function logarAdm($login){
			$_SESSION["adm"] = $login;
			setcookie('matricula', $matricula);		
 			header("location: index.php");
	}
	
	public function logout(){
			session_unset();
			session_destroy();
			header("location: ./index.php");
	}
}
?>