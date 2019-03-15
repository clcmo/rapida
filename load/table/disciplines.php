<?php
	$name_page = 'disciplines';
	$script = $name_page.', `courses`, `teachers`, `users` WHERE disciplines.id_cur = courses.id_cur AND disciplines.id_pro = teachers.id_pro AND teachers.id_usu = users.id_usu';
	$sql = $Tables->LoadFrom($script);
	//include('load/main.php');

	$button = '<a href="" class="button is-link is-inverted is-small"><i class="fas fa-chalkboard-teacher"></i></a>';
	
	$query = $PDO->query($sql) or die ($PDO);
	while($row = $query->fetch(PDO::FETCH_OBJ)){
	echo '
        <tr>
            <td width="5%"><p class="button is-link is-small"><i class="fas fa-chalkboard"></i></p></td>
            <td>'.$row->nome_dis.'</td>
            <td width="5%">'.$button.'</td>
        </tr>';
	}