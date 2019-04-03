<?php
	$id = (isset($_GET['id'])) ? $_GET['id'] : '';
	switch ($id) {
		case true:
			$script.= $id_table.' = '.$id;
			//chamar script sql
			$sql = $Tables->LoadFrom($script);
			$query = $PDO->query($sql) or die ($PDO);
			$cont = $Tables->CountViewTable($script);
			while($row = $query->fetch(PDO::FETCH_OBJ)){
				$name_cou = $name_dis = $row->$name_table;
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
			$name_cou = $name_dis = 'Informe o nome';
			$checked2 = '';
			$checked1 = '';
			$selected_type = 'cadastrar';
			$type_button = 'save';
		break;
	}