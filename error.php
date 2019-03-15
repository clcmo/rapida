<?php
	/**
     * The error page for our theme.
     *
     * Displays all of the brand menu content and index
     *
     * @package Bulma by Milla
     */

	include('header-index.php');

	$page_redirected_from = $_SERVER['REQUEST_URI'];  // this is especially useful with error 404 to indicate the missing page.
    $redirect_url = parse_url($_SERVER["REDIRECT_URL"]);
    $end_of_path = strrchr($redirect_url["path"], "/");

    /*switch(getenv("REDIRECT_STATUS")) {
	    # "400 - Bad Request"
	    case 400:
	        $background = 'bg-facebook';
	        $cod = '400';
	        $exclaim = 'IH RAPAZ!';
	        $explain = 'Me perdi aqui, não sei por ande andar.';
	    break;

	    # "401 - Unauthorized"
	    case 401:
	 	   	$background = 'bg-danger';
	        $cod = '401';
	        $exclaim = 'EITA!';
	        $explain = 'O Pink e o Cérebro colocaram uma senha tão forte que nem eu sei achar.';
	    break;

	    # "403 - Forbidden"
	    case 403:
	        $background = 'bg-google';
	        $cod = '403';
	        $exclaim = 'OPA!';
	        $explain = 'Parece que alguém tá tentando entrar nas colinas de Hogwarts, mas nem passou do teste do chapéu.';
	    break;

	    # "404 - Not Found"
	    case 404:
	        $background = 'bg-primary';
	        $cod = '404';
	        $exclaim = 'AHHH!';
	        $explain = 'Fui carregar tantos arquivos que acabei esquecendo deste.';
	    break;

	    # "500 - Internal Server Error"
	    case 500:
	        $background = 'bg-info';
	        $cod = '500';
	        $exclaim = 'DESCULPE!';
	        $explain = 'Alguém me desligou da tomada.';
	    break;
	}*/
?>

	<div class="hero-body">
	    <div class="container has-text-centered">
	        <div class="column is-6 is-offset-3">
	            <h1 class="title is-logo is-large">Erro <?php echo getenv("REDIRECT_STATUS"); ?></h1>
	            <h2 class="subtitle">Um erro ocorreu durante a sua navegação.</h2>
	        </div>
	    </div>
	</div>
<?php include('footer-index.php'); ?>