<?php
	$name_page = 'users';
	$script = $name_page.' WHERE type_use = 2';
	$name_table = $Tables->Found_Item('name', $name_page);

	$message = 'Login: ';

	include('main.php');
	$link = $edit_link;