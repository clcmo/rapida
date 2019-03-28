<?php
	$name_page = 'teachers';
	$name_translated = 'Professor';
	$script = $name_page.', users WHERE '.$name_page.'.id_use = users.id_use AND status_use = 1';
	$icon = '<i class="fas fa-user"></i>';
	$name_table = $Tables->Found_Item('name', 'users');
	include('main.php');