<?php
	include('functions/main.php');
	session_start();
	session_destroy();
	$Load->Link();
	exit;
?>