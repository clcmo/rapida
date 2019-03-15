<?php
	//$sql = $Tables->LoadFrom('`teachers`, `users` WHERE teachers.id_usu = users.id_usu AND status_pro = 1 AND status_usu = 1');
	$sql = $Tables->LoadFrom('`teachers`, `users` WHERE teachers.id_usu = users.id_usu');
	$query = $PDO->query($sql) or die ($PDO);
	while($row = $query->fetch(PDO::FETCH_OBJ)){
		echo '<option>'.$row->nome_usu.'</option>';
	}