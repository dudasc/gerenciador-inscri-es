<?php
ob_start();
session_start();
include "./classes/login.php";
$login = new login();
$login->logout();
?>
