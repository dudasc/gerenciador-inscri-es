<?php
ob_start();
@session_start();
if(!isset($_SESSION["adm"])){
	echo "<p>Página restrita, faça seu login.</p>";
	header("location: ./login.php");
}
?>