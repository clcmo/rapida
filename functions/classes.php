<?php
	# Lista de páginas e suas respectivas funcionalidades
	# Classe referente as Tabelas
  	class Tables {
    	# 1 - Verifica se a tabela existe, através da informação de uma string
    	function IsThisTableExists($name_table){
		    $Load = new Load;
		    $PDO = $Load->DataBase();
		    $con = $PDO->query("SHOW TABLES") or die ($PDO);
		    while ($row = $con->fetch(PDO::FETCH_OBJ)) {
		    	$tabs[] = $row;
		    }
		    return ($tabs) ? true : false;
	    }
		
		# 2.1 - Localizar uma coluna de uma tabela para carregar seus dados
	    function Found_Item($item, $name_table){
	    	return $item.'_'.substr($name_table, 0, 3);
	    }
	    # 2 - Carregar todos os dados (ou específicos) de uma tabela através do string informado
	    function SelectFrom($item = null, $name_table_and_cond, $limit = array()){
	    	$Tables = new Tables;
	    	switch ($item) {
	    		case 'COUNT': $sql = 'SELECT COUNT('.$Tables->Found_Item('id', $name_table_and_cond).') AS qt'; break;
	    		case null: $sql = 'SELECT *'; break;
	    		default: $sql = 'SELECT '.$item; break;
	    	}
	    	$sql .= (!$limit) ? ' FROM '.$name_table_and_cond : ' FROM '.$name_table_and_cond.' LIMIT '.$limit[1].', '.$limit[2];
	    	return $sql;
	    }
	    # 2.2 - Contar dados existentes de uma tabela através do string informado
	    function LoadCountFrom($name_table){
	      	$Tables = new Tables;
	      	return $Tables->SelectFrom('COUNT', $name_table);
	    }
	    # 3 - Cria o Hash da Senha, usando MD5 e SHA-1
	    function HashStr($password){
	    	return sha1(md5($password));
	    }
	    # 4 - Busca uma determinada linha da tabela //a desenvolver
	    function SearchId($name_table){
	     	return isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	    }
	    # 5 - Conta os registros de uma tabela ou de uma busca //a aprimorar
	    function CountViewTable($type = null, $name_table, $item = null){
	    	$Load = new Load;
	    	$Tables = new Tables;
	      	$PDO = $Load->DataBase();
	      	switch ($type) {
	      		case 'search':
	      			$q = isset($_GET['q']) ? $_GET['q'] : '';
	      			$qt = count($PDO->prepare($Tables->LoadCountFrom($name_table)." WHERE ".$item." LIKE '%".$q."%' ORDER BY ".$item) or die ($PDO));
	      		break;
	      		
	      		case null:
	      		default:
	      			$con = $PDO->query($Tables->LoadCountFrom($name_table)) or die ($PDO);
	      			while($row = $con->fetch(PDO::FETCH_OBJ)){
	        			$qt = $row->qt;
	      			}
	      		break;
	      	}
	      	return $qt;
	    }
	    # 6 - Deleta um registro do sistema // a desenvolver
	    function DeleteId($name_table){
	    	$Load = new Load;
	    	$Tables = new Tables;
	    	$PDO = $Load->DataBase();
	    	$con = $PDO->query('DELETE FROM '.$name_table.' WHERE '.$Tables->FoundId($name_table).' = '.$Tables->SearchId($name_table)) or die ($PDO);
	    	if ($con) {
	    	  return $Load->GoToLink($name_table);
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
        	$Load = new Load;
        	$link = (!$Login->IsLogged()) ? 'index' : 'admin';
			return $Load->GoToLink($link);
        }
    }
    $Login = new Login;
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
					$con = $PDO->query($Tables->SelectFrom('photo, email', 'users WHERE id_use = '.$_SESSION['id'])) or die ($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)) {
						$email = isset($row->email) ? $row->email : 'someone@somewhere.com';
						$photo = isset($row->photo) ? $row->photo : '';
					}
				break;
			}
			if(!$photo || $photo = null){
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
	# Classe Referente a Navegação das Páginas
	class Navegation {
		# 1 - Gera o Menu de topo se o usuário estiver logado. Menu irá variar de acordo com o tipo de usuário
	    function HeroMenu(){
	    	$Load = new Load;
	    	$Tables = new Tables;
	        $Login = new Login;
	        $menu = array();
	        $home = (!$Login->IsLogged()) ? 'index' : 'admin';
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
    								#echo $Tables->SelectFrom('type_use', 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1');
    								$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1')) or die ($PDO);
    								while($row = $con->fetch(PDO::FETCH_OBJ)){
					    				switch ($row->type_use){
											case 1:
												#diretor
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
											case 2:
												#coordenador
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
												#funcionário
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
											
											case 4:
												#professor
												$menu[2] = $menu[1].'
    											<a class="navbar-item" href="'.SERVER.'notifies"><i class="fas fa-book-open"></i>&nbsp;Notificações</a>
												<a class="navbar-item" href="'.SERVER.'admin"><i class="fas fa-graduation-cap"></i>&nbsp;Formandos</a>';
											break;
											case 5:
											#aluno
												$menu[2] = $menu[1].'
                    							<a class="navbar-item" href="'.SERVER.'#"><i class="fas fa-book-open"></i>&nbsp;Histórico</a>
												<a class="navbar-item" href="'.SERVER.'#"><i class="far fa-file"></i>&nbsp;Documentos</a>';
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
    	# 2 - Gera a informação e um mapa rápido de acesso através do link informado
	    function MainNavegation($link = LINK){
	    	$str = substr($link, 1);
	    	$mess ='<ul>Você está em: &nbsp;';
	    	if($str != 'admin'){
	    		switch ($str) {
	    			case 'classroom': $str = 'Turmas'; break;
	    			case 'courses': $str = 'Cursos'; break;
	    			case 'disciplines': $str = 'Disciplinas'; break;
	    			case 'employees': $str = 'Funcionários'; break;
	    			case 'historic': $str = 'Notas'; break;
	    			case 'notifies': $str = 'Notificações'; break;
	    			case 'profile': $str = 'Perfil'; break;
	    			case 'schedule-grid': $str = 'Grade'; break;
	    			case 'students': $str = 'Estudantes'; break;
					case 'teachers': $str = 'Professores'; break;
	    			case 'users': $str = 'Usuários'; break;
	    		}
	    		$mess .='
	    			<li class=""><a href="admin" aria-current="page">Início</a></li>
	    			<li class="is-active"><a href="'.$link.'" aria-current="page">'.ucfirst($str).'</a></li>';
	    	} else {
	    		$mess .= '<li class="is-active"><a href="'.$str.'" aria-current="page">Início</a></li>';
	    	}
	    	return $mess .= '</ul>';
	    }
	    # 2.1 - Mostra um menu personalizado, com mapa de acesso, através do link e do tipo de usuário informado
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
    		$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1')) or die ($PDO);
    		while($row = $con->fetch(PDO::FETCH_OBJ)){
    			switch ($row->type_use) {
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
	    function HeroMessage($title, $subtitle){
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
	$Navegation = new Navegation;
	# Classe que cataloga as funções referentes as páginas
    class Pages {
    	function LoadSamplePage($name_page){
    		$Tables = new Tables;
    		$Load = new Load;
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
			switch ($name_page) {
				case 'courses':
				case 'users': $script .= ' WHERE '; break;
				case 'disciplines': $script .= ', courses WHERE '.$name_page.'.id_cou = courses.id_cou AND '; break;
				case 'login': $script = 'users WHERE '; break;
				case 'notifies':
					$con = $PDO->query($Tables->SelectFrom('type_use','users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1', 1)) or die ($PDO);
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
			}
			switch($id){
				case false:
				case null:
					$name_use = $name_cou = $name_dis = $name_not = 'Informe o nome';
					$checked2 = $checked1 = '';
				break;
				case true:
					$script.= $id_table.' = '.$id;
					$PDO = $Load->DataBase();
					$con = $PDO->query($Tables->SelectFrom(null, $script)) or die ($PDO);
					$cont = $Tables->CountViewTable(null, $script);
					while($row = $con->fetch(PDO::FETCH_OBJ)){
						switch ($name_page) {
							case 'courses':
								$name_cou = $row->$name_table;
							break;
				
							case 'disciplines':
								$name_cou = $row->$name_table;
							break;
							case 'login':
								$email = $row->email;
							break;
							case 'notifies':
								$name_not = $row->$name_table;
							break;
							case 'users':
								$name_use = $row->$name_table;
							break;
						}
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
			}
			$picture = $Load->Gravatar();
			$placeholder = $email = isset($_GET['email']) ? $_GET['email'] : '';
		}
		function LoadTablePage($name_page){
			#$str = substr($name_page, 1, (MAX-5));
			$Load = new Load;
			$PDO = $Load->DataBase();
			$Tables = new Tables;
			$name_table = $name_page;
			switch ($name_page) {
			    case 'classroom':
			        $th = '
			                <th></th>
							<th>Nome do Curso</th>
							<th>Tipo de Curso</th>';
					$name_table .= ', courses WHERE '.$name_page.'.id_cou = courses.id_cou';
					$titulo = 'Turmas';
					$icon = '<i class="fas fa-users"></i>';
					$type_table = $Tables->Found_Item('type', 'courses');
				break;
				case 'courses':
					$th = '
						<th></th>
						<th>Nome</th>
						<th>Tipo de Curso</th>
						<th>Período</th>';
					$titulo = 'Cursos';
					$icon = '<i class="fas fa-pencil-alt"></i>';
					$type_table = $Tables->Found_Item('type', $name_page);
				break;
				case 'disciplines': 
					$th = '
						<th>Nome</th>
						<th>Nome do Curso</th>
						<th>Professor</th>';
					$name_table .= ', `courses`, `teachers`, `users` WHERE disciplines.id_cou = courses.id_cou AND disciplines.id_tea = teachers.id_tea AND teachers.id_use = users.id_use';
					$titulo = 'Disciplinas';
					$icon = '<i class="fas fa-chalkboard"></i>';
					$type_table = $Tables->Found_Item('type', 'courses');
				break;
				case 'notifies':
					$th = '
						<th></th>
						<th>Titulo</th>
						<th>Tipo da Notificação</th>
						<th>Nome do Usuário</th>';
					$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1', 1)) or die ($PDO);
					$name_table .= ', users WHERE users.id_use = '.$name_page.'.id_use';
					$titulo = 'Notificações';
					$icon = '<i class="fas fa-bell"></i>';
					while($row = $con->fetch(PDO::FETCH_OBJ)){
						switch ($row->type_use){
							case 1:
							case 3:
								$name_table .=' AND users.id_use = '.$_SESSION['id'];
							break;
							default:
							break;
						}
						$type_table = $Tables->Found_Item('type', $name_page);
					}
				break;
				case 'users':
					$th = '
						<th></th>
						<th>Nome</th>
						<th>Tipo do Usuário</th>
						<th></th>';
					$titulo = 'usuários';
				break;
			}
			$script = $Tables->SelectFrom(null, $name_table, 0, 10);
			echo $script;
			$con = $PDO->query($script) or die ($PDO);
			$cont = $Tables->CountViewTable(null, $name_table);
			$id = $Tables->Found_Item('id', $name_page);
			$name_table = $Tables->Found_Item('name', $name_page);
			echo '
			    	<div class="card events-card">
			            <header class="card-header">
			                <p class="card-header-title">'.ucfirst($titulo).'</p>
			                <a href="'.$name_page.'#show_all" class="card-header-icon" aria-label="more options"><span class="icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span></a>
			            </header>
			            <div class="card-table">
			                <div class="content">
			                    <table class="table is-fullwidth is-striped">
			                    	<thead>
			                    		<tr>'.$th.'</tr>
									</thead>
			                    	<tbody>';							
								    while($row = $con->fetch(PDO::FETCH_OBJ)){
								    	$status_table = $Tables->Found_Item('status', $name_page);
								    	switch ($row->$status_table) {
											case 1:
												$action_link = 'change?t='.$name_page.'?id='.$row->$id;
												$action_color = 'danger';
												$action_button = '<i class="fas fa-minus-circle"></i>';
											break;
											case 2: 
												$action_link = 'change?t='.$name_page.'?id='.$row->$id;
												$action_color = 'success';
												$action_button = '<i class="fas fa-check-square">';
											break;
										}
								    	switch ($name_page) {
								    		case 'classroom': 
								    			$col_1 = '<a href="'.$name_page.'?id='.$row->$id.'" class="button is-link is-small">'.$icon.'</a>';
								    			$col_2 = $row->name_cou;
								    			$type = ($row->$type_table == 1) ? 'Ensino Médio' : 'Ensino Modular';
								    			$col_3 = '<a class="button is-light is-inverted is-small">'.$type.'</a>';
												$col_4 = '<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'.$action_button.'</a>';
												$col_5 = '';
								    		break;
								    		case 'courses':
								    			$col_1 = '<a href="'.$name_page.'?id='.$row->$id.'" class="button is-link is-small">'.$icon.'</a>';
								    			$col_2 = $row->$name_table;
								    			$type = ($row->$type_table == 1) ? 'Ensino Médio' : 'Ensino Modular';
								    			$col_3 = '<a class="button is-light is-inverted is-small">'.$type.'</a>';
								    			switch ($row->period) {
								    				case 'M':
								    					$col_period = 'warning';
								    					$period = 'Manhã';
								    				break;
								    				
								    				case 'T':
								    					$col_period = 'danger';
								    					$period = 'Tarde';
								    				break;
								    				case 'N':
								    					$col_period = 'link';
								    					$period = 'Noite';
								    				break;
								    				case 'I':
								    					$col_period = 'primary';
								    					$period = 'Integral';
								    				break;
								    			}
								    			$col_4 = '<a href="schedule-grid?id='.$row->$id.'" class="button is-'.$col_period.' is-small">'.$period.'</a>';
								    			$col_5 = '<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'. $action_button.'</a>';
								    		break;
								    		case 'disciplines':
								    			$col_1 = $row->$name_table;
								    			$col_2 = '<a href="courses?n='.$row->name_cou.'">'.$row->name_cou.'</a>';
								    			$col_3 = '<a href="courses?n='.$row->name_use.'">'.$row->name_use.'</a>';
								    			$col_4 = '<a href="'.$name_page.'?id='.$row->$id.'" class="button is-link is-small">'.$icon.'</a>';
								    			$col_5 = '<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'. $action_button.'</a>';
								    		break;
								    		case 'notifies':
								    			$col_1 = '<a href="'.$name_page.'?id='.$row->$id.'" class="button is-link is-small">'.$icon.'</a>';
												$col_2 = $row->$name_table;
												switch ($row->$type_table) {
													case 1: $type = 'Solicitação'; break;
													case 2: $type = 'Revisão'; break;
													case 3: $type = 'Matrícula'; break;
													case 4: $type = 'Ocorrência'; break;
													case 5: $type = 'Trancamento'; break;
													case 6: $type = 'Histórico'; break;
													case 7: $type = 'Outros'; break;
												}
												$col_3 = '<a class="button is-light is-inverted is-small">'.$type.'</a>';
												$col_4 = $row->name_use;
												switch ($row->$status_table) {
													case 1:
														$action_link = 'get_doc?t='.$name_page.'?id='.$row->$id;
														$action_color = 'success';
														$action_button = '<i class="fas fa-file"></i>&nbsp;Gerar';
													break;
													case 2: 
														$action_link = 'view_doc?t='.$name_page.'?id='.$row->$id;
														$action_color = 'primary';
														$action_button = '<i class="fas fa-file">&nbsp;Ver';
													break;
												}
												$col_5 = '<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'.$action_button.'</a>';
								    		break;
								    		case 'users':
								    			$photo = ($row->photo) ? SERVER.'uploads/'.$row->photo : $Load->Gravatar($row->email);
								    			$col_1 = '<a href="'.SERVER.'profile?id='.$row->id_use.'" class="button is-link is-small"><i class="fas fa-pencil-alt"></i></a>';
								    			$col_2 = '<figure class="image is-32x32"><img class="is-rounded" src="'.$photo.'">';
								    			$col_3 = $row->$name_table;
								    			$col_4 = '<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'.$action_button.'</a>';
								    			$col_5 = '';
								    		break;
								    	}
										echo '
											<tr>
												<td>'.$col_1.'</td>
												<td>'.$col_2.'</td>
										    	<td>'.$col_3.'</td>
										    	<td>'.$col_4.'</td>
										    	<td>'.$col_5.'</td>
					    					</tr>';
					    			}
					    			echo '                         
			                            </tbody>
			                        </table>
			                    </div>
			                </div>
			                <footer class="card-footer">
			                	<a class="card-footer-item">Exibindo '.$cont.' de '.$cont.' resultados.</a>
			                </footer>
			            </div>';
		}
		function LoadSuperTablePage($name_page){
			$id = (isset($_GET['id'])) ? $_GET['id'] : '';
			$Load = new Load;
			$PDO = $Load->DataBase();
			$Tables = new Tables;
			$name_table = $name_page;
			switch ($name_page) {
		        case 'classroom':
		        	$th = '
		                    <th colspan="2">Aluno</th>
							<th>RA</th>
						    <th>Data de Matrícula</th>
						    <th>Data de Aniversário</th>';
					$name_table = 	$name_page.', courses, students, users';
					$name_table .= ' WHERE '.$name_page.'.id_cla = '.$id;
					$name_table .= ' AND '.$name_page.'.id_cou = courses.id_cou';
					$name_table .= ' AND students.id_cla = '.$name_page.'.id_cla';
					$name_table .= ' AND students.id_use = users.id_use AND users.type_use = 5';
				break;
				case 'historic':
					$th = '
							<th colspan="2">Aluno</th>
						    <th colspan="2">Notas</th>
						    <th colspan="2">Faltas</th>
						    <th colspan="2">Abonos</th>
						    <th>Média Final</th>';
					$name_table = 	'historic, disciplines, students, users';
					$name_table .= 	' WHERE historic.id_dis = disciplines.id_dis';
					$name_table .= 	' AND historic.id_stu = students.id_stu';
					$name_table .=	' AND students.id_use = users.id_use AND historic.id_his = '.$id;
				break;
			}
			$script = $Tables->SelectFrom($name_table, 0, 10);
		    $con = $PDO->query($script) or die ($PDO);
		    $id = $Tables->Found_Item('id', $name_page);
		    $name_table = $Tables->Found_Item('name', $name_page);
		    echo '
		    	<table class="table is-fullwidth is-striped">
		            <thead>
		                <tr>'.$th.'</tr>
					</thead>
		            <tbody>';							
					while($row = $con->fetch(PDO::FETCH_OBJ)){
						$name_use = $row->name_use;
						$photo = ($row->photo != null) ? SERVER.'uploads/'.$row->photo : $Load->Gravatar($row->email);
						switch ($name_page) {
							case 'classroom':
								$signup_date = date('d/m/Y', strtotime($row->signup_date));
								$birthday_date = date('d/m/Y', strtotime($row->birthday_date));
								$col_1 = '<p class="image is-64x64"><img class="is-rounded" src="'.$photo.'">';
							    $col_2 = $name_use;
							    $col_3 = $row->id_use;
							    $col_4 = $signup_date;
							    $col_5 = $birthday_date;
							    $col_6 = '<a class="button is-link" href="historic?id='.$row->id_use.'">Ver Historico</a>';
							    $col_7 = '<a class="button is-link" href="profile?id='.$row->id_use.'">Ver Perfil</a></td>';
							    $col_8 = $col_9 = $col_10 = '';
							break;
							#criar tabela e acrescentar notas, faltas, abonos, formula da avaliação e média final
							case 'historic':
								$col_1 = '<p class="image is-64x64"><img class="is-rounded" src="'.$photo.'">';
							    $col_2 = $name_use;
							    $col_3 = '10';
							    $col_4 = '7';
							    $col_5 = '6';
							    $col_6 = '3';
							    $col_7 = '2';
							    $col_8 = '2';
							    $col_9 = '8';
							    $col_10 = '';
							break;
						}
						echo '
							<tr>
								<th>'.$col_1.'</th>
								<th>'.$col_2.'</th>
								<td>'.$col_3.'</td>
								<td>'.$col_4.'</td>
								<td>'.$col_5.'</td>
								<td>'.$col_6.'</td>
								<td>'.$col_7.'</td>
								<td>'.$col_8.'</td>
								<td>'.$col_9.'</td>
								<td>'.$col_10.'</td>
				    		</tr>';
				    }
				    echo '                         
		                </tbody>
		            </table>';
		            #proxima etapa = exibir os resultados em multiplos de 10
		}
		function LoadArticlePage($name_page){
			$script .=' LIMIT '.$vi.', '.$vf;
		    $query = $PDO->query($Tables->SelectFrom($script)) or die ($PDO);
		    $cont = $Tables->CountViewTable($script);
		    while($row = $query->fetch(PDO::FETCH_OBJ)){
		    	$id = $Tables->Found_Item('id', $name_page);
				$edit_link = $name_page.'?id='.$row->$id;
				$titulo = $row->$name_table;
				$status_table = $Tables->Found_Item('status', $name_page);
				$action_link = ($status_table) ? 'deactivate?t='.$name_page.'?id='.$row->$id : 'activate?t='.$name_page.'?id='.$row->$id;
				$action_color = ($status_table) ? 'danger' : 'success';
				$action_button = ($status_table) ? '<i class="fas fa-minus-circle"></i>' : '<i class="fas fa-check-square">';
				switch ($name_page) {
					case 'classroom':
						$link = 'courses?id='.$row->$id;
						//$name_page.', courses, students, users WHERE '.$name_page.'.id_cla = '.$row->$id.' AND '.$name_page.'.id_cou = courses.id_cou AND students.id_cla = '.$name_page.'.id_cla AND students.id_use = users.id_use
						$cont_class = $Tables->CountViewTable($script);
						switch ($row->period) {
							case 'M': $period = 'Manhã'; break;
							case 'T': $period = 'Tarde'; break;
							case 'N': $period = 'Noite'; break;
							case 'I': $period = 'Integral'; break;
						}
						$message = 'Número de Alunos: '.$row->students.'</br>Período: '.$period.'<br/>Curso: ';
						$user = $titulo;
					break;
					case 'users':
						$link = 'profile?id='.$row->$id;
						switch ($row->birthday_date) {
							case true:
								$birthday_date = date('d/m/Y', strtotime($row->birthday_date));
								$birthday_year = date('Y', strtotime($row->birthday_date));
								$age = date(YEAR-$birthday_year);
							break;
							
							case false:
								$birthday_date = $birthday_year = $age = '';
							break;
						}
						
						switch ($row->signup_date) {
							case true:
								$signup_date = date('d/m/Y', strtotime($row->signup_date));
								$signup_year = date('Y', strtotime($row->signup_date));
								$signup_time = date(YEAR-$signup_year);
							break;
							
							case false:
								$signup_date = $signup_year = $signup_time = '';
							break;
						}
						$user = $login = ($row->login) ? $row->login : '';
						$email = ($row->email) ? $row->email : '';
						$img = isset($row->photo) ? '<img class="is-rounded" src="'.$row->photo.'">' : '<img class="is-rounded" src="'.$Load->Gravatar($email).'">';
						
						/*
						$cep = ($row->cep) ? $row->cep : '';
						$address = ($row->address) ? $row->address : '';
						$number = ($row->number) ? $row->number : '';
						$neighborhood = ($row->neighborhood) ? $row->neighborhood : '';
						$city = ($row->city) ? $row->city : '';
						$state = ($row->state) ? $row->state : '';
						$rg = ($row->rg) ? $row->rg : '';
						$cpf = ($row->cpf) ? $row->cpf : '';
						$phone = ($row->phone) ? $row->phone : '';*/
						#preparar especificações para cada tipo de usuário
						switch ($row->type_use) {
							case 1:
								$tag = 'is-primary';
								$tipo = 'Aluno';
								$string = 'turma';
								$input = '';
							break;
							case 2:
								$tag = 'is-warning';
								$tipo = 'Funcionário';
								$string = 'area';
								$input = '';
							break;
								
							case 3:
								$tag = 'is-success';
								$tipo = 'Professor';
								$string = 'area';
								$input = '';
							break;
							case 4:
							break;
							case 5:
							break;
						}
						$message = 'Idade: '.$age.'<br/>'.$tipo.' desde '.$signup_year.'<br/> Login: ';
					break;
				}
				echo '
					<article class="post">
						<h4>'.$titulo.'</h4>
						<div class="media">
							<div class="media-left">'.$img.'</div>
							<div class="media-content">
								<div class="content">
									<p>'.$message.'<a href="'.$link.'">'.$user.'</a></p>
								</div>
							</div>
							<div class="media-right">
								<a href="'.$edit_link.'" class="button is-link is-small"><i class="fas fa-pencil-alt"></i></a>
								<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'.$action_button.'</a>
							</div>
						</div>
						<hr />
					</article>';
			}
			echo'
					<div class="columns">
						<div class="column">
							<p>Exibindo '.$cont.' de '.$cont.' resultados.</p>
						</div>
						<div class="column">
						</div>
					</div>';
		}
		function LoadOptionsPage($name_page){
			$Tables = new Tables;
			$Load = new load;
			$PDO = $Load->DataBase();
			switch ($name_page) {
				case 'courses':
					$name_translated = 'Cursos';
					$script = $name_page.' WHERE status_cou = 1';
					$name_table = $Tables->Found_Item('name', $name_page);
					$id_table = $Tables->Found_Item('id', $name_page);
					$icon = '<i class="fas fa-chalkboard"></i>';
				break;
				
				case 'teachers':
					$name_translated = 'Professor';
					$script = $name_page.', users WHERE '.$name_page.'.id_use = users.id_use AND status_use = 1';
					$icon = '<i class="fas fa-user"></i>';
					$name_table = $Tables->Found_Item('name', 'users');
					$id_table = $Tables->Found_Item('id', $name_page);
				break;
			}
	
			$query = $PDO->query($Tables->SelectFrom(null, $script)) or die ($PDO);
			
			echo'
				<div class="field" id="'.$name_page.'">
			        <label class="label">'.$name_translated.'</label>
			        <div class="control has-icons-left">
			            <div class="select is-hovered is-link">
			            	<select name="'.$name_page.'">';
				            	while($row = $query->fetch(PDO::FETCH_OBJ)){
				            		echo '<option value="'.$row->$id_table.'">'.$row->$name_table.'</option>';
				            	}
			            echo '</select>
			            </div>
			            <span class="icon is-small is-left">'.$icon.'</span>
			        </div>
			    </div>';
		}
    }
    $Pages = new Pages;