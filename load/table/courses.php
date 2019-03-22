<?php
	$script = $name_page = 'courses';
	$sql = $Tables->LoadFrom($script);
	$query = $PDO->query($sql) or die ($PDO);
	while($row = $query->fetch(PDO::FETCH_OBJ)){
		$col_1 = '<a href="'.SERVER.'?id='.$row->id_cou.'" class="button is-link is-small"><i class="fas fa-pencil-alt"></i></a>';

		//$type_table = $Tables->Found_Item('type', $name_page);
		switch ($row->type_cou) {
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

		$link = ($row->status_cou) ? 'deactivate' : 'activate';
		$color = ($row->status_cou) ? 'danger' : 'success' ;
		$icon = ($row->status_cou) ? '<i class="fas fa-minus-circle"></i>' : '<i class="fas fa-check-square">';
		$col_4 = '<a href="'.SERVER.''.$link.'?t='.$name_page.'?id='.$row->id_cou.'" class="button is-small is-'.$color.'">'.$icon.'</a>';
		$button_title = 'Editar';
	}
	$titulo = 'Cursos';
	include('main.php');