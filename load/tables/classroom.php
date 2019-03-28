<?php
	$name_page = 'classroom';
	$script = $name_page.', courses WHERE '.$name_page.'.id_cou = courses.id_cou';
	$titulo = 'Turmas';
	$icon = '<i class="fas fa-users"></i>';

	$id = $Tables->Found_Item('id', $name_page);
	$type_table = $Tables->Found_Item('type', 'courses');

	include('main.php');

/*
    $button_title = 'Ver Alunos';

    $sql = $Tables->LoadFrom($script);
    $query = $PDO->query($sql) or die ($PDO);
    while($row = $query->fetch(PDO::FETCH_OBJ)){
		//$type_table = $Tables->Found_Item('type', $name_page);
		switch ($row->type_cou) {
			case 1: 
				$button_title_2 = 'Ensino Médio'; 
			break;
			case 2: 
				$button_title_2 = 'Ensino Modular'; 
			break;
		}
	}*/