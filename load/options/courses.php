<?php
	$name_page = 'courses';
	$name_translated = 'Cursos';
	$script = $name_page.' WHERE status_cou = 1';
	$name_table = $Tables->Found_Item('name', $name_page);
	
	include('main.php');