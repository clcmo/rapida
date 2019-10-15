<?php
	include('header.php');
	$cnpj = "12345678910";
	$email = 'camila.leite.oliveira@gmail.com';
	$name_use = strtoupper(strstr($email, '.'));
	$sth = $PDO->prepare("INSERT INTO users (name_use, cpf) VALUES (:name_use, :cpf)"); 
	$sth->bindParam(':name_use', $name_use, PDO::PARAM_STR);
	$sth->bindParam(':cpf', $cnpj, PDO::PARAM_STR);
	$sth->execute();
	if($sth->execute() === false){
   		print_r($sth->errorInfo());
	}
