<?php
	require_once('classes.php');

	# Definições
    # 1 - Conexão com DB
	define('DB_HOST', 'localhost');
	define('DB_USER', 'etec');
	define('DB_PASS', 'EtecWeb245');
	define('DB_NAME', 'clcmo_sys_rapida');

	# 2 - Definição do Usuário logado
    

	# 3 - Definição de META
    define('YEAR',       date('Y'));
    define('TODAY',      date(YEAR.'-m-d'));
    define('DATE',       date((YEAR-15).'-m-d'));

    # 4 - Definição de Conexão
    $PDO = $Load->DataBase();
    define('LINK', substr($_SERVER['REQUEST_URI'], 1));
    define('MAIN_EMAIL','someone@somewhere.com');
    $error = array();

    # 5 - Definições de Inserção/Edição
    #$id = (isset($_GET['id'])) ? $_GET['id'] : (isset($_SESSION['id'])) ? $_SESSION['id'] : '';
    $id = (isset($_GET['id'])) ? $_GET['id'] : '';
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    $placeholder = isset($_GET['email']) ? $_GET['email'] : 'Informe seu email';
    $picture = isset($_GET['email']) ? $Load->Gravatar($_GET['email']) : $Load->Gravatar();
    $password = 'Informe sua senha';
    $password_conf = 'Repita corretamente';

    switch ($id) {
        case true: 
            $selected_type = 'editar'; 
            $type_button = 'edit'; 
        break;
        case false: 
            $selected_type = 'cadastrar'; 
            $type_button = 'save'; 
        break;
    }

    # 6 - Definições de Paginação
    $vf = 10;
    $pg = isset($_GET['pg']) ? $_GET['pg'] : '';
    $pc = (!$pg) ? 1 : $pg;
    $vi = $pc - 1;
    $vi = $vi * $vf;
    define('MAX', strlen(LINK));
    $sizeof = array();
    $sizeof[1] = MAX;
    $sizeof[2] = strlen(strstr(LINK, '?id='.$id));
    $link = (isset($_GET['id'])) ? $Load->DiscoverLink(LINK, ($sizeof[1] - $sizeof[2])) : $Load->DiscoverLink();

    define('TITLE',      'Rápida');
	define('DESC',       $Load->WhatLink($link));
    define('TITLE_HEAD',  TITLE.' | '.DESC);
	define('AUTHOR',     'Camila L. Oliveira');
    define('AUTHOR_URL', 'http://projetos.camilaloliveira.com/');
    $footer = (!$Login->IsLogged()) ? '' : '<p/>';
    define('FOOTER',     'Copyright &copy; '.YEAR.'&nbsp;<a href="https://etecdebarueri.com.br" class="text-bold" target="_blank">Etec de Barueri</a>.'.$footer.'&nbsp;Design de&nbsp;<a href="'.AUTHOR_URL.'" class="text-bold" target="_blank">Camila L. Oliveira</a>.'.$footer.'&nbsp;Todos os direitos reservados.');

    