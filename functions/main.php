<?php
	require_once('classes.php');

	//Defines
	//1 - Conexão com DB
	define('DB_HOST', 'localhost');
	define('DB_USER', 'clc');
	define('DB_PASS', 'yMcgoImF85t6wdTH');
	define('DB_NAME', 'clcmo_sys_rapida');

	//2 - Definição do Usuário logado
    

	//3 - Definição de META
    define('YEAR', date('Y'));
    define('TODAY', date(YEAR.'-m-d'));
    define('DATE', date((YEAR-15).'-m-d'));
    define('TITLE', 'Rápida');
	define('DESC', 'Sistemas Acadêmicos');
	define('AUTHOR', 'Camila L. Oliveira');
    define('AUTHOR_URL', 'http://projetos.camilaloliveira.com/');
    $title = TITLE.' | '.DESC;
    define('FOOTER', 'Copyright &copy; '.YEAR.'&nbsp;<a href="'.AUTHOR_URL.'" class="text-bold" style="text-decoration: none" target="_blank"><img class="bulma" src="'.SERVER.'assets/brand/logo_milla_b.png"></a>. Todos os direitos reservados.');

    //Definição de Conexão
    $PDO = $Load->DataBase();
    define('LINK',  $_SERVER['REQUEST_URI']);
    $main_email = 'someone@somewhere.com';
    $error = array();