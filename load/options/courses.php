<?php
	$sql = $Tables->LoadFrom('cursos WHERE status_cur = 1');
	$query = $PDO->query($sql) or die ($PDO);
	while($row = $query->fetch(PDO::FETCH_OBJ)){
		echo '<option>'.$row->nome_cur.'</option>';
	}