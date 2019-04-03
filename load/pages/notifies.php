<?php
	include('load/profile.php');

	$name_page = 'notifies';
	$sql = $Tables->LoadFrom('users WHERE id_use = '.$_SESSION['id'].' AND status_use = 1 LIMIT 1');
	$query = $PDO->query($sql) or die ($PDO);

	while($row = $query->fetch(PDO::FETCH_OBJ)){
		switch ($row->type_use){
			case 1:
			case 3:
				$script = $name_page.', users WHERE users.id_use = '.$name_page.'.id_use AND users.id_use = '.$_SESSION['id'];
				//$col_4 = $button_title = '';
				/*$profile_link = SERVER.'profile';*/
			break;

			default:
				$script = $name_page.', users WHERE users.id_use = '.$name_page.'.id_use';
				$button_title = 'Gerar Documento';
				/*$profile_link = SERVER.'profile?id='.$row->id_usu;*/
			break;
		}
	}
	$name_table = $Tables->Found_Item('name', $name_page);
	$type_table = $Tables->Found_Item('type', $name_page);
	include('main.php');