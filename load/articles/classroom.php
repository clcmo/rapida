<?php
	$name_page = 'classroom';
	$script = $name_page.', courses WHERE '.$name_page.'.id_cou = courses.id_cou';
	$img = '<i class="fas fa-users" style="font-size: 3rem;"></i>';

	$id = $Tables->Found_Item('id', $name_page);
	$name_table = $Tables->Found_Item('name', 'courses');
	$type_table = $Tables->Found_Item('type', 'courses');

	include('main.php');