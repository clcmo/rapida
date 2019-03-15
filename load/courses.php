<?php
	$name_page = 'courses';
	$script = $name_page;

	$name_table = $Tables->Found_Item('name', $name_page);
	$type_table = $Tables->Found_Item('type', $name_page);
	include('main.php');
