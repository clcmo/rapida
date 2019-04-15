<?php
	# Classe referente as Tabelas
  	class Tables {
    	# 1 - Verifica se a tabela existe, através da informação de uma string
    	function IsTableExists($str) {
		    $Load = new Load;
		    $PDO = $Load->DataBase();
		    $con = $PDO->query("SHOW TABLES") or die ($PDO);
		    while ($row = $con->fetch(PDO::FETCH_OBJ)) {
		    	$tabs[] = $row;
		    }
		    return ($tabs) ? true : false;
	    }

	    # 2 - Carregar todos os dados (ou específicos) de uma tabela através do string informado
	    function LoadFrom($item, $as, $str, $limit = array()){
	    	$sql = 'SELECT '.$item;
	    	if ($as){
	    		$sql .= 'AS '.$as;
	    	}
	    	$sql .= ' FROM '.$str;
	    	if($limit){
	    		$sql .= 'LIMIT '.$limit[1].', '.$limit[2];
	    	}
	    	return $sql;
	    }

	    # 2.1 - Localizar uma tabela para carregar seus dados
	    function Found_Item($item, $str) {
	    	return $item.'_'.substr($str, 0, 3);
	    }

	    # 2.2 - Contar dados exixtentes de uma tabela através do string informado
	    function LoadCountFrom($str){
	      	$Tables = new Tables;
	      	return $Tables->LoadFrom('count ('.$Tables->Found_Item('id', $str).')', 'qt', $str);
	    }

	    # 3 - Cria o Hash da Senha, usando MD5 e SHA-1
	    function HashStr($str) {
	    	return sha1(md5($str));
	    }

	    # 4 - Busca uma determinada linha da tabela //a desenvolver
	    function SearchId($str) {
	     	return isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	    }

	    # 5 - Conta os registros de uma tabela
	    function CountViewTable($str){
	    	$Load = new Load;
	    	$Tables = new Tables;
	      	$PDO = $Load->DataBase();
	      	$con = $PDO->query($Tables->LoadCountFrom($str)) or die ($PDO);
	      	while($row = $con->fetch(PDO::FETCH_OBJ)){
	        	$qt = $row->qt;
	      	}
	      	return $qt;
	    }

	    # 5.1 - Conta os registros de uma busca
	    function CountSearchTable($str, $con){
	    	$Load = new Load;
	    	$Tables = new Tables;
	    	$PDO = $Load->DataBase();
	    	$q = isset($_GET['q']) ? $_GET['q'] : '';
	    	$con = $PDO->prepare($Tables->LoadCountFrom($str)." WHERE ".$con." LIKE %".$q."% ORDER BY ".$con) or die ($PDO);
	    	$qt = count($con);
	    	return $qt;
	    }

	    # 6 - Deleta um registro do sistema // a desenvolver
	    function DeleteId($str) {
	    	$Load = new Load;
	    	$Tables = new Tables;
	    	$PDO = $Load->DataBase();
	    	$con = $PDO->query('DELETE FROM '.$str.' WHERE '.$Tables->FoundId($str).' = '.$Tables->SearchId($str)) or die ($PDO);
	    	if ($con) {
	    	  return $Load->GoToLink($str);
	    	} else {
	    	  //return messageShow('error', $_SERVER['REQUEST_URI'], $str);
	    	}
	    }
  	}
  	$Tables = new Tables;


    # Classe Referente ao Login
  	class Login { 
        # 1 - Retorna se o usuário logou
        function IsLogged() {
        	return (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) ? false : true;
        }

        #2 - Checa se o usuário está logado e redireciona para uma das páginas
        function Check(){
        	$Login = new Login;
        	$link = (!$Login->IsLogged()) ? 'index' : 'admin';
			return header('Location: '.$link);
        }
    }
    $Login = new Login;


    # Classe Referente ao Carregamento das Atribuições, Variáveis e Menus
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
	    function GoToLink($str) {
	      	return header('Location: '.SERVER.''.$str);
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
			switch ($Login->IsLogged()){
				case false:
					$email = isset($_GET['email']) ? $_GET['email'] : 'someone@somewhere.com';
					$photo = '';
				break;
				case true:
					$Load = new Load;
					$PDO = $Load->DataBase();
					$con = $PDO->query($Tables->LoadFrom('photo, email', null, 'users WHERE id_use = '.$_SESSION['id']), null) or die ($PDO);
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

		# 6 - Gera o Menu de topo se o usuário estiver logado. Manu irá variar de acordo com o tipo de usuário
	    function HeroMenu(){
	    	$Load = new Load;
	    	$Tables = new Tables;
	        $Login = new Login;
	        $menu = array();
	        $menu[1] = '
	        <div class="hero-head">
	        	<nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
				  	<div class="navbar-brand">
					    <a class="navbar-item is-logo" href="'.SERVER.''.$home.'">rÁpidA</a>
					    <div class="navbar-burger burger" data-target="navMenubd-example">
					    	<span></span>
					    	<span></span>
					    	<span></span>
					    </div>
				  	</div>
                    <div id="navMenubd-example" class="navbar-menu">
	    				<div class="navbar-start">';
                    		switch ($Login->IsLogged()) {
                    			case true:
    								$PDO = $Load->DataBase();
    								$con = $PDO->query($Tables->LoadFrom('type_use', null, 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1', 0, 1)) or die ($PDO);
    								while($row = $con->fetch(PDO::FETCH_OBJ)){
    									switch ($row->type_use) {
    										case 1:
    											$menu[2] = $menu[1].'
                    							<a class="navbar-item" href="'.SERVER.'#"><i class="fas fa-book-open"></i>&nbsp;Histórico</a>
												<a class="navbar-item" href="'.SERVER.'#"><i class="far fa-file"></i>&nbsp;Documentos</a>';
    										break;
    										
    										case 2:
    											$menu[2] = $menu[1].'
    												<div class="navbar-item has-dropdown is-hoverable">
	        											<a class="navbar-link is-active" href="'.SERVER.'users"><i class="fas fa-users"></i>&nbsp;Usuários</a>
	        											<div class="navbar-dropdown ">
	        												<a class="dropdown-item " href="'.SERVER.'employees">Funcionários</a>
	        												<hr class="navbar-divider">
	        												<a class="dropdown-item " href="'.SERVER.'teachers">Professores</a>
	        												<a class="dropdown-item " href="'.SERVER.'#">Coordenadores</a>
	        												<a class="dropdown-item " href="'.SERVER.'#">Direção</a>
	        												<hr class="navbar-divider">
	        												<a class="dropdown-item " href="'.SERVER.'students">Alunos</a>
	        												<!--<a class="dropdown-item" href="'.SERVER.'classroom">Turmas de Alunos</a>-->
	        											</div>
	        										</div>
	        										<div class="navbar-item has-dropdown is-hoverable">
	        											<a class="navbar-link is-active" href="courses-disciplines"><i class="fas fa-book-open"></i>&nbsp;Cursos e Disciplinas</a>
	        											<div class="navbar-dropdown ">
	        												<a class="dropdown-item " href="'.SERVER.'courses">Cursos</a>
	        												<a class="dropdown-item " href="'.SERVER.'disciplines">Disciplinas</a>
	        												<!--<a class="dropdown-item " href="'.SERVER.'schedule-grid">Grade de Horários</a>-->
	        											</div>
	        										</div>
													<!--<a class="navbar-item" href="'.SERVER.'events"><i class="fas fa-graduation-cap"></i>&nbsp;Eventos</a>-->';
    										break;

											case 3:
    											$menu[2] = $menu[1].'
    											<a class="navbar-item" href="'.SERVER.'admin"><i class="fas fa-book-open"></i>&nbsp;Ocorrências</a>
												<a class="navbar-item" href="'.SERVER.'admin"><i class="fas fa-graduation-cap"></i>&nbsp;Formandos</a>';
    										break;
    										
    										case 4:
    											$menu[2] = $menu[1].'';
    										break;

    										case 5:
    											$menu[2] = $menu[1].'';
    										break;
    									}
    								}

                    				$menu[3] = $menu[2].'
                    				</div>
                    				<a class="navbar-item">
										<i class="fas fa-search" aria-hidden="true"></i>&nbsp;<span><input class="input" type="search" placeholder="Procurar..."></span>
									</a>
                    				<div class="navbar-end">
										<a class="navbar-item" href="profile"><i class="fas fa-user"></i>&nbsp;Perfil</a>
                    					<a class="navbar-item" href="notifies"><i class="fas fa-bell"></i>&nbsp;Notificações</a>
                    					<a class="navbar-item" href="profile"><i class="fas fa-book"></i>&nbsp;Biblioteca</a>
										<a class="navbar-item" href="logout"><i class="fas fa-sign-out-alt"></i>&nbsp;Sair</a>
									</div>
									</div>
                    				</div>
	        						</div>
	        						</nav>';
                    			break;
                    			
                    			case false:
                    				$menu[2] = $menu[1].'
                    				</div>
		                    		<div class="navbar-end">
			    						<a class="navbar-item" href="login"><i class="fa fa-user"></i>&nbsp;Login</a>
			    						<a class="navbar-item" href="example"><i class="fab fa-superpowers"></i>&nbsp;Exemplos</a>
			    						<a class="navbar-item" href="#"><i class="fab fa-github"></i>&nbsp;Instale</a>
			    					</div>
	        						</nav>
	        						</div>';
                    			break;
                    		}
            return ($Login->IsLogged()) ? $menu[3] : $menu[2];
    	}

    	# 7 - Gera a informação e um mapa rápido de acesso através do link informado
	    function MainNavegation($link, $str){
	    	$mess ='<ul>Você está em: &nbsp;';
	    	if($str){
	    		$mess .='
	    			<li class=""><a href="admin" aria-current="page">Início</a></li>
	    			<li class="is-active"><a href="'.$link.'" aria-current="page">'.$str.'</a></li>';
	    	} else {
	    		$mess .= '<li class="is-active"><a href="admin" aria-current="page">Início</a></li>';
	    	}
	    	$mess .= '</ul>';
   			return $mess;
	    }

	    # 7.1 - Mostra um menu personalizado, com mapa de acesso, através do link e do tipo de usuário informado
    	function FooterMenu() {
    		$Load = new Load;
    		$Tables = new Tables;
    		$menu = '
    		<div class="columns">
    		<div class="column is-3">
    		<aside class="menu is-hidden-mobile">
        	<p class="menu-label">Gerais</p>
        	<ul class="menu-list">
                <li><a href="'.SERVER.'admin" class="is-active">Início</a></li>
                <li><a href="'.SERVER.'profile">Perfil</a></li>
                <li><a href="'.SERVER.'notifies">Notificações</a></li>
                <li><a href="#">Biblioteca Online</a></li>
            </ul>
			</aside>
			</div>
			<div class="column is-3">';
    		$PDO = $Load->DataBase();
    		$con = $PDO->query($Tables->LoadFrom('type_use', null, 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1', 0, 1)) or die ($PDO);
    		while($row = $con->fetch(PDO::FETCH_OBJ)){
    			switch ($row->type_use) {
    				switch ($row->type_use){
					case 1:
						#diretor
					break;

					case 2:
						#coordenador
					break;

					case 3:
						#funcionário
						$menu .= '
		    				<p class="menu-label">Administração</p>
		                    <ul class="menu-list">
		                        <li>
		                            <a href="courses-disciplines">Cursos e Disciplinas</a>
		                            <ul>
		                                <li><a href="'.SERVER.'courses">Curso</a></li>
		                                <li><a href="'.SERVER.'disciplines">Disciplina</a></li>
		                                <!--<li><a href="'.SERVER.'schedule-grid">Grade de Horários</a></li>-->
		                            </ul>
		                        </li>
		                        <li>
		                            <a href="users">Usuários</a>
		                            <ul>
		                                <li><a href="'.SERVER.'teachers">Professores</a></li>
		                                <li><a href="'.SERVER.'employees">Funcionarios</a></li>
		                                <li>
		                                	<a href="'.SERVER.'students">Alunos</a>
											<ul>
			                                	<li><a href="'.SERVER.'classroom">Turmas e Alunos</a></li>
			                            	</ul>
		                                </li>
		                            </ul>
		                        </li>
		                        <li><a href="'.SERVER.'events">Eventos</a></li>
		                    </ul>
		                    </div>
		                    </div>';
					break;
					
					case 4:
						#professor
						$menu .= '
		    				<p class="menu-label">Professores</p>
		                    <ul class="menu-list">
		                        <li>
		                            <a>Alunos</a>
		                            <ul>
		                                <li><a href="'.SERVER.'partial">Adicionar Nota</a></li>
		                                <li><a href="'.SERVER.'average">Adicionar Média</a></li>
		                                <li><a href="'.SERVER.'average">Gerenciar</a></li>
		                            </ul>
		                        </li>
		                    </ul>
		                    </div>
		                    </div>';
					break;

					case 5:
						$menu .= '
		    				<p class="menu-label">Alunos</p>
		                    <ul class="menu-list">
		                    	<li><a href="'.SERVER.'notifies">Solicitar Documentos</a></li>
		                        <li><a href="'.SERVER.'historic">Visualizar Histórico</a></li>
		                        <li><a href="#">Rematrícula</a></li>
		                    </ul>
		                    </div>
		                    </div>';
					break;
				}
    		}
    		return $menu;
    	}

	    function HeroMessage($link, $title, $subtitle){
	    	$hero = '
    		<section class="hero is-info welcome is-small">
			    <div class="hero-body">
			        <div class="container">
			        	<h1 class="title is-medium">'.$title.'</h1>
			            <h2 class="subtitle">'.$subtitle.'</h2>
			        </div>
			    </div>
			</section>';
			return $hero;
	    }
	}
	$Load = new Load;
    define('SERVER', $Load->Server());

    # Classe que cataloga as funções referentes as páginas
    class Pages{
    	function LoadSamplePage($name_page){
    		$Tables = new Tables;
    		$Load = new Load;
			switch ($name_page) {
				default:
					$id = (isset($_GET['id'])) ? $_GET['id'] : (isset($_SESSION['id'])) ? $_SESSION['id'] : '';
					#puxa a id informada

					#com o nome da página estaremos puxando:
					$script = $name_page;
					#script sql
					$type_table = $Tables->Found_Item('type', $name_page);
					#o tipo na tabela informada
					$status_table = $Tables->Found_Item('status', $name_page);
					#o status na tabela informada
					$name_table = $Tables->Found_Item('name', $name_page);
					#o titulo/nome na tabela informada 
					$id_table = $Tables->Found_Item('id', $name_page);
					#o id na tabela informada
				break;

				case 'courses':
					$script .= ' WHERE ';
				break;
				
				case 'disciplines':
					$script .= ', courses WHERE '.$name_page.'.id_cou = courses.id_cou AND ';
				break;

				case 'login':
					$script = 'users WHERE ';
				break;

				case 'notifies':
					$con = $PDO->query($Tables->LoadFrom('type_use', null, 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1', 0, 1)) or die ($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)){
						$name_use = $row->name_use;
						switch ($row->type_use){
							case 1:
								#diretor
							break;

							case 2:
								#coordenador
							break;

							case 3:
								#funcionário
								$script .= ', users WHERE users.id_use = '.$name_page.'.id_use AND ';
								$button_title = 'Gerar Documento';
							break;
							
							case 4:
								#professor
							break;

							case 5:
								$script .= ', users WHERE users.id_use = '.$name_page.'.id_use AND users.id_use = '.$_SESSION['id'].' AND ';
								/*$profile_link = SERVER.'profile';*/
							break;
						}
					}
				break;

				case 'users':
					#preparar codigo
				break;
			}

			switch ($id) {
				case true:
					$script.= $id_table.' = '.$id;
					$con = $PDO->query($Tables->LoadFrom($script)) or die ($PDO);
					$cont = $Tables->CountViewTable($script);
					while($row = $con->fetch(PDO::FETCH_OBJ)){
						$name_cou = $name_dis = $name_not = $row->$name_table;
						switch ($row->$type_table) {
							case 1: 
								$button_title_2 = 'Ensino Médio';
								$checked1 = 'checked';
								$checked2 = '';
							break;
							case 2: 
								$button_title_2 = 'Ensino Modular';
								$checked2 = 'checked';
								$checked1 = '';
							break;
						}
						$placeholder = $email = $row->email;
					}
				break;
				
				case false:
					$name_cou = $name_dis = $name_not = 'Informe o nome';
					$checked2 = '';
					$checked1 = '';
				break;
			}
			$picture = $Load->Gravatar();
			$placeholder = $email = isset($_GET['email']) ? $_GET['email'] : '';
		}
    }
    $Pages = new Pages;