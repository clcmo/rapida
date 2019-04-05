<?php
	$id = (isset($_GET['id'])) ? $_GET['id'] : '';

	switch ($name_page) {
		case 'courses':
			$type_table = $Tables->Found_Item('type', $name_page);
			$script .= ' WHERE ';
		break;
		
		case 'disciplines':
			$status_table = $Tables->Found_Item('status', $name_page);
			$script .= ', courses WHERE '.$name_page.'.id_cou = courses.id_cou AND ';
		break;

		case 'login':
		break;

		case 'notifies':
			$type_table = $Tables->Found_Item('type', $name_page);
			$sql = $Tables->LoadFrom('users WHERE id_use = '.$_SESSION['id'].' AND status_use = 1 LIMIT 1');
			$query = $PDO->query($sql) or die ($PDO);

			while($row = $query->fetch(PDO::FETCH_OBJ)){
				$name_use = $row->name_use;
				switch ($row->type_use){
					case 1:
					case 3:
						$script .= ', users WHERE users.id_use = '.$name_page.'.id_use AND users.id_use = '.$_SESSION['id'].' AND ';
						/*$profile_link = SERVER.'profile';*/
					break;

					default:
						$script .= ', users WHERE users.id_use = '.$name_page.'.id_use AND ';
						$button_title = 'Gerar Documento';
						/*$profile_link = SERVER.'profile?id='.$row->id_usu;*/
					break;
				}
			}
		break;

		case 'users':
		break;
	}

	$name_table = $Tables->Found_Item('name', $name_page);
	$id_table = $Tables->Found_Item('id', $name_page);

	switch ($id) {
		case true:
			$script.= $id_table.' = '.$id;
			//chamar script sql
			$sql = $Tables->LoadFrom($script);
			$query = $PDO->query($sql) or die ($PDO);
			$cont = $Tables->CountViewTable($script);
			while($row = $query->fetch(PDO::FETCH_OBJ)){
				$name_cou = $name_dis = $name_not = $row->$name_table;
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

			$selected_type = 'editar';
			$type_button = 'edit';
		break;
		
		case false:
			$name_cou = $name_dis = $name_not = 'Informe o nome';
			$checked2 = '';
			$checked1 = '';
			$selected_type = 'cadastrar';
			$type_button = 'save';
		break;
	}