<?php
	$name_page = 'courses';
	$name_translated = 'Cursos';
	$script = $name_page.' WHERE status_cou = 1';
	$name_table = $Tables->Found_Item('name', $name_page);
	$id_table = $Tables->Found_Item('id', $name_page);

	$icon = '<i class="fas fa-chalkboard"></i>';
	
	include('main.php');