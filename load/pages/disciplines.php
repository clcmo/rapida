<?php
	$name_page = 'disciplines';

	$name_table = $Tables->Found_Item('name', $name_page);
	$status_table = $Tables->Found_Item('status', $name_page);
	$id_table = $Tables->Found_Item('id', $name_page);

	$script = $name_page.', courses WHERE '.$name_page.'.id_cou = courses.id_cou AND ';
	include('main.php');