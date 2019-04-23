<?php
	$id = (isset($_GET['id'])) ? $_GET['id'] : (isset($_SESSION['id'])) ? $_SESSION['id'] : '';
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
	switch ($name_page) {
		case 'courses':
		case 'users':
			$script .= ' WHERE ';
		break;
				
		case 'disciplines':
			$script .= ', courses WHERE '.$name_page.'.id_cou = courses.id_cou AND ';
		break;

		case 'login':
			$script = 'users WHERE ';
		break;

		case 'notifies':
			$con = $PDO->query($Tables->SelectFrom('type_use','users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1', 1)) or die ($PDO);
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
						$script .= ', users WHERusers.id_use = '.$name_page.'.id_use AND users.id_use = '.$_SESSION['id'].' AND ';
						/*$profile_link = SERVER.'profile';*/
					break;
				}
			}
		break;
	}

	switch($id){
		case false:
			switch ($name_page) {
				case 'courses':
					$name_cou = 'Informe o nome';
				break;
				
				case 'disciplines':
					$name_dis = 'Informe o nome';
				break;

				case 'login':
					$email = $row->email;
				break;

				case 'notifies':
					$name_not = 'Informe o nome';
				break;

				case 'users':
					$name_use = 'Informe o nome';
					$tipo = 'usuário';
				break;
			}
			$checked2 = '';
			$checked1 = '';
		break;

		case true:
			$script.= $id_table.' = '.$id;
			$PDO = $Load->DataBase();
			$con = $PDO->query($Tables->SelectFrom(null, $script)) or die ($PDO);
			$cont = $Tables->CountViewTable('default', $script);
			while($row = $con->fetch(PDO::FETCH_OBJ)){
				switch ($name_page) {
					case 'courses':
						$name_cou = $row->$name_table;
					break;
				
					case 'disciplines':
						$name_cou = $row->$name_table;
					break;

					case 'login':
						$email = $row->email;
					break;

					case 'notifies':
						$name_not = $row->$name_table;
					break;

					case 'users':
						$name_use = $row->$name_table;
						$tipo = 'usuário';
						$email = $row->email;
						$birthday_date = ($row->birthday_date) ? date('d/m/Y', strtotime($row->birthday_date)) : '';
						$rg = ($row->rg) ? $row->rg : '';
						$cpf = ($row->cpf) ? $row->cpf : '';
						$phone = ($row->phone) ? $row->phone : '';

						$cep = ($row->cep) ? $row->cep : '';
						$address = ($row->address) ? $row->address : '';
						$number = ($row->number) ? $row->number : '';
						$neighborhood = ($row->neighborhood) ? $row->neighborhood : '';
						$city = ($row->city) ? $row->city : '';
						$state = ($row->state) ? $row->state : '';
						$photo = $Load->Gravatar();

						$input = '';
					break;
				}
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
	}
	$picture = $Load->Gravatar();
	$placeholder = $email = isset($_GET['email']) ? $_GET['email'] : '';