<?php
	$name_page = 'disciplines';
	$script = $name_page.', `courses`, `teachers`, `users` WHERE disciplines.id_cou = courses.id_cou AND disciplines.id_tea = teachers.id_tea AND teachers.id_use = users.id_use';
	$titulo = 'Disciplinas';

	$icon = '<i class="fas fa-chalkboard"></i>';
	$name_table = $Tables->Found_Item('name', $name_page);
	$type_table = $Tables->Found_Item('type', 'courses');
	$id = $Tables->Found_Item('id', $name_page);
	include('main.php');