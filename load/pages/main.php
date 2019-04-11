<?php
	switch ($name_page) {
		default:
			#$id = (isset($_GET['id'])) ? $_GET['id'] : (isset($_SESSION['id'])) ? $_SESSION['id'] : '';
			#puxa a id informada

			#com o nome da página estaremos puxando:
			$script = $name_page;
			#script sql
			$type_table = $Tables->Found_Item('type', $name_page);
			#o tipo na tabela informada
			$status_table = $Tables->Found_Item('status', $name_page);
			#o status na tabela informada
			$name_table = $Tables->Found_Item('name', $name_page);
			#o titulo/nome na tabela informada 
			$id_table = $Tables->Found_Item('id', $name_page);
			#o id na tabela informada
		break;

		case 'courses':
			$script .= ' WHERE ';
		break;
		
		case 'disciplines':
			$script .= ', courses WHERE '.$name_page.'.id_cou = courses.id_cou AND ';
		break;

		case 'login':
		case 'login?email='.$_GET['email']:
			$script = 'users WHERE ';
		break;

		case 'notifies':
			$con = $PDO->query('SELECT type_use FROM users WHERE id_use = '.$_SESSION['id'].'AND status_use = 1 LIMIT 1') or die ($PDO);
			while($row = $con->fetch(PDO::FETCH_OBJ)){
				$name_use = $row->name_use;
				switch ($row->type_use){
					case 1:
						#diretor
					break;

					case 2:
						#coordenador
					break;

					case 3:
						#funcionário
						$script .= ', users WHERE users.id_use = '.$name_page.'.id_use AND ';
						$button_title = 'Gerar Documento';
					break;
					
					case 4:
						#professor
					break;

					case 5:
						$script .= ', users WHERE users.id_use = '.$name_page.'.id_use AND users.id_use = '.$_SESSION['id'].' AND ';
						/*$profile_link = SERVER.'profile';*/
					break;
				}
			}
		break;

		case 'users':
			#preparar codigo
		break;
	}

	switch ($id) {
		case true:
			$script.= $id_table.' = '.$id;
			$con = $PDO->query($Tables->LoadFrom($script)) or die ($PDO);
			$cont = $Tables->CountViewTable($script);
			while($row = $con->fetch(PDO::FETCH_OBJ)){
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
				$placeholder = $email = $row->email;
			}
		break;
		
		case false:
			$name_cou = $name_dis = $name_not = 'Informe o nome';
			$checked2 = '';
			$checked1 = '';
		break;
	}
	$picture = $Load->Gravatar();
	$placeholder = $email;