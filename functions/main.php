<?php
	require_once('classes.php');

	# Definições
    # 1 - Conexão com DB
	define('DB_HOST', 'localhost');
	define('DB_USER', 'clc');
	define('DB_PASS', 'yMcgoImF85t6wdTH');
	define('DB_NAME', 'clcmo_sys_rapida');

	# 2 - Definição do Usuário logado
    

	# 3 - Definição de META
    define('YEAR',       date('Y'));
    define('TODAY',      date(YEAR.'-m-d'));
    define('DATE',       date((YEAR-15).'-m-d'));
    define('TITLE',      'Rápida');
	define('DESC',       'Sistemas Acadêmicos');
    define('TITLE_HEAD',  TITLE.' | '.DESC);
	define('AUTHOR',     'Camila L. Oliveira');
    define('AUTHOR_URL', 'http://projetos.camilaloliveira.com/');
    $home = (!$Login->IsLogged()) ? 'index' : 'admin';
    define('FOOTER',     'Copyright &copy; '.YEAR.'&nbsp;<a href="'.AUTHOR_URL.'" class="text-bold" style="text-decoration: none" target="_blank"><img class="bulma" src="'.SERVER.'assets/brand/logo_milla_b.png"></a>. Todos os direitos reservados.');

    # 4 - Definição de Conexão
    $PDO = $Load->DataBase();
    define('LINK',       $_SERVER['REQUEST_URI']);
    define('MAIN_EMAIL', 'someone@somewhere.com');
    $error = array();

    # 5 - Definições de Paginação
    $vf = 10;
    $pg = isset($_GET['pg']) ? $_GET['pg'] : '';
    $pc = (!$pg) ? 1 : $pg;
    $vi = $pc - 1;
    $vi = $vi * $vf;
    define('MAX', count(LINK));

    # 6 - Definições de Inserção/Edição
    $id = (isset($_SESSION['id'])) ? $_SESSION['id'] : (isset($_GET['id'])) ? $_GET['id'] : '';
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    $placeholder = isset($_GET['email']) ? $_GET['email'] : 'Informe seu email';
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