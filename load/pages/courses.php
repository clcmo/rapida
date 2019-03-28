<?php
	$name_page = 'courses';

	$name_table = $Tables->Found_Item('name', $name_page);
	$type_table = $Tables->Found_Item('type', $name_page);
	$id_table = $Tables->Found_Item('id', $name_page);

	switch (isset($_GET['id'])) {
		case true:
		$script = $name_page.' WHERE '; 
		include('load/main.php');
		while($row = $query->fetch(PDO::FETCH_OBJ)){
			$name_cou = $row->$name_table;
			switch ($row->$type_table) {
				case 1: 
					$button_title_2 = 'Ensino Médio';
					$checked1 = 'checked';
					$checked2 = '';
				break;
				case 2: 
					$button_title_2 = 'Ensino Modular';
					$checked2 = 'checked';
					$checked1 = '';
				break;
			}
		}
		break;
		
		case false:
			$name_cou = 'Informe o nome do curso';
			$checked2 = '';
			$checked1 = 'checked';
			$selected_type = 'cadastrar';
			$type_button = 'save';
		break;
	}
	
	
	