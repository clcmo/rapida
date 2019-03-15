<?php
	$sql = $Tables->LoadFrom('courses');
	$query = $PDO->query($sql) or die ($PDO);
	while($row = $query->fetch(PDO::FETCH_OBJ)){
		echo '
			<label class="checkbox">
                <input type="checkbox">'.$row->nome_cur.'
            </label><br/>';
	}