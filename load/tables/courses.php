<?php
	$script = $name_page = 'courses';
	$titulo = 'Cursos';
	$icon = '<i class="fas fa-pencil-alt"></i>';

	//$col_1 = $col_2 = $col_3 = $col_4 = $col_5 = '';

	$name_table = $Tables->Found_Item('name', $name_page);
	$id = $Tables->Found_Item('id', $name_page);

	include('main.php');