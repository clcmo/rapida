<?php
	$script = $name_page = 'courses';
	$titulo = 'Cursos';
	$icon = '<i class="fas fa-pencil-alt"></i>';

	$name_table = $Tables->Found_Item('name', $name_page);
	$id = $Tables->Found_Item('id', $name_page);

	include('main.php');