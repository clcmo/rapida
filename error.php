<?php
	$page_redirected_from = $_SERVER['REQUEST_URI'];  // this is especially useful with error 404 to indicate the missing page.
    $redirect_url = parse_url($_SERVER["REDIRECT_URL"]);
    $end_of_path = strrchr($redirect_url["path"], "/");

    switch(getenv("REDIRECT_STATUS")) {
	    # "400 - Bad Request"
	    case 400:
	        $title = '400';
	        $message = 'IH RAPAZ!<br/>';
	        $message .= 'Me perdi aqui, não sei por ande andar.';
	    break;

	    # "401 - Unauthorized"
	    case 401:
	        $title = '401';
	        $message = 'EITA!<br/>';
	        $message .= 'O Pink e o Cérebro colocaram uma senha tão forte que nem eu sei achar.';
	    break;

	    # "403 - Forbidden"
	    case 403:
	        $title = '403';
	        $message = 'OPA!<br/>';
	        $message .= 'Parece que alguém tá tentando entrar nas colinas de Hogwarts, mas nem passou do teste do chapéu.';
	    break;

	    # "404 - Not Found"
	    case 404:
	        $title = '404';
	        $message = 'AHHH!<br/>';
	        $message .= 'Fui carregar tantos arquivos que acabei esquecendo deste.';
	    break;

	    # "500 - Internal Server Error"
	    case 500:
	        $title = '500';
	        $message = 'DESCULPE!<br/>';
	        $message .= 'Alguém me desligou da tomada.';
	    break;
	}
	include('../ops.php');