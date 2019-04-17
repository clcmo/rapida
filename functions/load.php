<?php	
	# Classe Referente ao Carregamento das Atribuições, Variáveis
	class Load {
		# 1 - Conexão com o BD
	    function DataBase() {
	    	$pdo = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; charset=utf8', DB_USER, DB_PASS);
	    	$pdo->exec('set names utf8');
	    	return $pdo;
	    }
		
		# 2 Verifica se o server é https e printa a URL do link
	    function Server() {
	     	return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://'.$_SERVER["SERVER_NAME"].'/' : 'http://'.$_SERVER["SERVER_NAME"].'/';
	    }

	    # 3 - Redirecionamento de URL
	    function Link($name_page) {
	      	return header('Location: '.SERVER.''.$name_page);
	    }

	    # 4 - Gerador de Senha Aleatória
	    function RandomPass($size = 10, $ma = true, $mi = true, $nu = true, $si = false){
		 	$ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; 	# $ma contem as letras maiúsculas
		 	$mi = "abcdefghijklmnopqrstuvyxwz"; 	# $mi contem as letras minusculas
		 	$nu = "0123456789"; 					# $nu contem os números
		 	$si = "!@#$%¨&*()_+="; 					# $si contem os símbolos
		 
		 	if ($ma || $mi || $nu || $si){
		 		$password = str_shuffle($ma); 		# se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
		        $password .= str_shuffle($mi);		# se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
		        $password .= str_shuffle($nu);		# se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
		        $password .= str_shuffle($si);		# se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
		    }
	    	return substr(str_shuffle($password), 0, $size);	# retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
		}

		# 5 - Exibe a imagem gravada no BD ou a imagem gravada no site Gravatar.com
		function Gravatar($s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array()){
			$Login = new Login;
			$Tables = new Tables;
			switch ($Login->IsLogged()){
				case false:
					$email = isset($_GET['email']) ? $_GET['email'] : 'someone@somewhere.com';
					$photo = '';
				break;
				case true:
					$Load = new Load;
					$PDO = $Load->DataBase();
					$con = $PDO->query($Tables->LoadFrom('photo, email', 'users WHERE id_use = '.$_SESSION['id'])) or die ($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)) {
						$email = $row->email;
						$photo = $row->photo;
					}
				break;
			}
			if(!$photo){
				$url = 'https://www.gravatar.com/avatar/';
			    $url .= md5(strtolower(trim($email)));
			    $url .= "?s=$s&d=$d&r=$r";
			    if ($img) {
			    	$url = '<img src="'.$url.'"';
			        	foreach ($atts as $key => $val)
			            	$url .= ' '.$key.'="'.$val.'"';
			        	$url .= ' />';
			    	}
			    $photo = $url;
			}
            return $photo;
		}
	}
	$Load = new Load;
	define('SERVER', $Load->Server());