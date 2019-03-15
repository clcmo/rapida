<?php
	$script = $name_page = 'courses';
	$sql = $Tables->LoadFrom($script);
	$query = $PDO->query($sql) or die ($PDO);
	while($row = $query->fetch(PDO::FETCH_OBJ)){
		switch ($row->status_cou) {
			case 1:
				# desativar...
				$button_title = '<a href="'.SERVER.'deactivate?id='.$row->id_cou.'" class="button is-danger is-small"><i class="fas fa-minus-circle"></i></a>';
			break;
			
			case 2:
				# ativar...
				$button_title = '<a href="'.SERVER.'activate?id='.$row->id_cou.'" class="button is-success is-small"><i class="fas fa-check-square"></a>';
			break;
		}
		$col_1 = '<a href="'.SERVER.'?id='.$row->id_cou.'" class="button is-link is-small"><i class="fas fa-pencil-alt"></i></a>';

		$checked1 = ($row->type_cou = 1) ? 'checked' : '';
		$checked2 = ($checked1 == true) ? '' : 'checked';
	}
	include('main.php');