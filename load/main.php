<?php
	//Para Visualização
	//Definição Global de Variáveis
	$selected_type = 'cadastrar';
	$color = 'is-black';
	$title_message = $name_page;
    $type_button = 'save';

	//Para Paginação
	$vf = 10;
	$pg = isset($_GET['pg']) ? $_GET['pg'] : '';
	$pc = (!$pg) ? 1 : $pg;
	$vi = $pc - 1;
	$vi = $vi * $vf;

	//Alterar valores em caso de Get[id]
	if(isset($_GET['id'])){
		//$script = $script.' AND '.ID_TABLE.' = '.$_GET['id'];
		$selected_type = 'editar';
		$type_button = 'edit';
	}

	//chamar script sql
	$sql = $Tables->LoadFrom($script.' LIMIT '.$vi.','.$vf);
	$query = $PDO->query($sql) or die ($PDO);
	$cont = $Tables->CountViewTable($script.' LIMIT '.$vi.','.$vf);

	while($row = $query->fetch(PDO::FETCH_OBJ)){
		$id = ID_TABLE;
		$edit_link = $name_page.'?id='.$row->$id;
		
		$titulo = $row->$name_table;

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
				$tag = 'is-link';
			break;
			case 2:
				$tag = 'is-primary';
			break;
			case 3:
				$tag = 'is-warning';
			break;
			default:
			break;
		}
	}