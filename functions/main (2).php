<?php
	//Para Visualização
	//Definição Global de Variáveis
	$color = 'is-black';
	$title_message = $name_page;

	//Para Paginação
	//Mover para a pagina main de Tabelas e Artigos
	/*$vf = 10;
	$pg = isset($_GET['pg']) ? $_GET['pg'] : '';
	$pc = (!$pg) ? 1 : $pg;
	$vi = $pc - 1;
	$vi = $vi * $vf;*/

	//Alterar valores em caso de Get[id]
	switch (isset($_GET['id'])) {
		case true:
			$script .= $id_table.' = '.$_GET['id'];
			$selected_type = 'editar';
			$type_button = 'edit';

			//chamar script sql
			$sql = $Tables->LoadFrom($script);
			$query = $PDO->query($sql) or die ($PDO);
			$cont = $Tables->CountViewTable($script);
		break;
		
		case false:
			//$script .=' LIMIT '.$vi.','.$vf;
			$selected_type = 'cadastrar';
			$type_button = 'save';
			$script = $sql = $query = '';
		break;
	}
	
	

	/*while($row = $query->fetch(PDO::FETCH_OBJ)){
		$id = ID_TABLE;
		$edit_link = $name_page.'?id='.$row->$id;
		
		$titulo = $row->$name_table;
		$name_cou = $row->$name_table;

		$foto = isset($row->foto) ? SERVER.'uploads/'.$row->foto : $Load->Gravatar($main_email);
		$img = isset($foto) ? $foto : $img;

		$status_table = $Tables->Found_Item('status', $name_page);
		switch ($row->$status_table) {
			case 1:
				$action_color = 'danger';
				$action_button = '<i class="fas fa-minus-circle"></i>';
			break;
			
			case 2:
				$action_color = 'success';
				$action_button = '<i class="fas fa-check-square"></i>';
			break;
		}

		switch ($row->$type_table) {
			case 1: 
				$button_title_2 = 'Ensino Médio';
				$checked1 = 'checked';
				$checked2 = '';
				$tag = 'is-link';
			break;
			case 2: 
				$button_title_2 = 'Ensino Modular';
				$checked2 = 'checked';
				$checked1 = '';
				$tag = 'is-primary';
			break;
			case 3:
				$tag = 'is-warning';
			break;
			default:
			break;
		}
	}*/