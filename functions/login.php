<?php    
    # Classe Referente ao Login
  	class Login { 
        # 1 - Retorna se o usuário logou
        function IsLogged() {
        	return (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) ? false : true;
        }

        #2 - Checa se o usuário está logado e redireciona para uma das páginas
        function Check(){
        	$Login = new Login;
        	$Load = new Load;
        	$link = (!$Login->IsLogged()) ? 'index' : 'admin';
			return $Load->GoToLink($link);
        }
    }
    $Login = new Login;