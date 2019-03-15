<?php
	$email = isset($_GET['email']) ? $_GET['email']: '';
	$placeholder = isset($_GET['email']) ? $_GET['email']: 'Seu Email';
	$picture = isset($_GET['email']) ? $Load->Gravatar($_GET['email']) : $Load->Gravatar($main_email);