<?php
	$name_page = 'disciplines';

	$name_table = $Tables->Found_Item('name', $name_page);
	$status_table = $Tables->Found_Item('status', $name_page);
	$id_table = $Tables->Found_Item('id', $name_page);

	switch (isset($_GET['id'])) {
		case true:
			$script = $name_page.', courses WHERE '.$name_page.'.id_cou = courses.id_cou AND ';
			include('load/main.php');

			while($row = $query->fetch(PDO::FETCH_OBJ)){
				$name_dis = $row->$name_table;
			}
		break;
		
		case false:
			$name_dis = 'Informe o nome da disciplina';
			$selected_type = 'cadastrar';
			$type_button = 'save';
		break;
	}