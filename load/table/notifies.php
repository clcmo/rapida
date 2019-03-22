<?php
	$name_page = 'notifies';
	$sql = $Tables->LoadFrom('users WHERE id_use = '.$_SESSION['id'].' AND status_use = 1 LIMIT 1');
	$query = $PDO->query($sql) or die ($PDO);

	while($row = $query->fetch(PDO::FETCH_OBJ)){
		switch ($row->type_use){
			case 1:
			case 3:
				$script = $name_page.', users WHERE users.id_use = '.$name_page.'.id_use AND users.id_use = '.$_SESSION['id'];
				$col_4 = $button_title = '';
				/*$profile_link = SERVER.'profile';*/
			break;

			default:
				$script = $name_page.', users WHERE users.id_use = '.$name_page.'.id_use';
				$button_title = 'Gerar Documento';
				/*$profile_link = SERVER.'profile?id='.$row->id_usu;*/
			break;
		}
	}

	$sql = $Tables->LoadFrom($script);
    $query = $PDO->query($sql) or die ($PDO);

	while($row = $query->fetch(PDO::FETCH_OBJ)){
		$type_table = $Tables->Found_Item('type', $name_page);
		switch ($row->$type_table) {
			case 1: 
				$button_title_2 = 'Solicitação'; 
			break;
			case 2: 
				$button_title_2 = 'Revisão'; 
			break;
			case 3: 
				$button_title_2 = 'Matrícula'; 
			break;
			case 4: 
				$button_title_2 = 'Ocorrência'; 
			break;
			case 5: 
				$button_title_2 = 'Trancamento'; 
			break;
			case 6: 
				$button_title_2 = 'Histórico'; 
			break;
			case 7: 
				$button_title_2 = 'Outros'; 
			break;
		}
	}
	$titulo = 'Notificações';
	include('main.php');