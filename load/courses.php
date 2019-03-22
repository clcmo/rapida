<?php
	$name_page = 'courses';
	$script = $name_page;

	$sql = $Tables->LoadFrom($script);
	$query = $PDO->query($sql) or die ($PDO);
	$name_table = $Tables->Found_Item('name', $name_page);
	$type_table = $Tables->Found_Item('type', $name_page);
	/*while($row = $query->fetch(PDO::FETCH_OBJ)){
		$name_table = $Tables->Found_Item('name', $name_page);
		$name_cou = $row->$name_table;

		$type_table = $Tables->Found_Item('type', $name_page);
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
	}*/

	include('main.php');
