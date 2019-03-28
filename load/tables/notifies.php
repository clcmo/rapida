<?php

	$sql = $Tables->LoadFrom('users WHERE id_use = '.$_SESSION['id'].' AND status_use = 1 LIMIT 1');
	$query = $PDO->query($sql) or die ($PDO);
	$name_page = 'notifies';
	$script = $name_page.', users WHERE users.id_use = '.$name_page.'.id_use';

	while($row = $query->fetch(PDO::FETCH_OBJ)){
		switch ($row->type_use){
			case 1:
			case 3:
				$script .=' AND users.id_use = '.$_SESSION['id'];
			break;

			default:
			break;
		}
	}

	
	$name_table = $Tables->Found_Item('name', $name_page);
	$id = $Tables->Found_Item('id', $name_page);
	$type_table = $Tables->Found_Item('type', $name_page);
	$titulo = 'Notificações';
	$icon = '<i class="fas fa-bell"></i>';
	include('main.php');