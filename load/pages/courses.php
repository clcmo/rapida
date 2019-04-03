<?php
	$script = $name_page = 'courses';

	$name_table = $Tables->Found_Item('name', $name_page);
	$type_table = $Tables->Found_Item('type', $name_page);
	$id_table = $Tables->Found_Item('id', $name_page);

	$script .= ' WHERE '; 
	include('main.php');