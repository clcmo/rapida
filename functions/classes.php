<?php
	# Lista de páginas e suas respectivas funcionalidades
	# Classe Referente ao Login
  	class Login { 
        # 1 - Retorna se o usuário logou
        function IsLogged() {
        	return (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) ? false : true;
        }
    }
    $Login = new Login;

    # Classe referente as Tabelas
  	class Tables {
		# 1.1 - Localizar uma coluna de uma tabela para carregar seus dados
	    function Found_Item($item, $name_table){
	    	return $item.'_'.substr($name_table, 0, 3);
	    }
	    
	    # 1 - Carregar todos os dados (ou específicos) de uma tabela através do string informado
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
	    
	    # 2 - Cria o Hash da Senha, usando MD5 e SHA-1
	    function HashStr($password){
	    	return sha1(md5($password));
	    }
	    
	    # 3 - Busca uma determinada linha da tabela //a desenvolver
	    function SearchId($name_table){
	     	return isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	    }
	    
	    # 4 - Conta os registros de uma tabela ou de uma busca //a aprimorar
	    function CountViewTable($type = null, $name_table, $item = null){
	    	$Load = new Load;
	    	$Tables = new Tables;
	      	$PDO = $Load->DataBase();
	      	switch ($type) {
	      		case 'search':
	      			$q = isset($_GET['q']) ? $_GET['q'] : '';
	      			$qt = count($PDO->prepare($Tables->SelectFrom('COUNT', $name_table)." WHERE ".$item." LIKE '%".$q."%' ORDER BY ".$item) or die ($PDO));
	      		break;
	      		
	      		case null:
	      		default:
	      			$con = $PDO->query($Tables->SelectFrom('COUNT', $name_table)) or die ($PDO);
	      			while($row = $con->fetch(PDO::FETCH_OBJ)){
	        			$qt = $row->qt;
	      			}
	      		break;
	      	}
	      	return $qt;
	    }
	    
	    # 5 - Deleta um registro do sistema // a desenvolver
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
	    function Link($name_page = null) {
	      	return header('Location: '.SERVER.''.$name_page);
	    }
	    
	    # 4 - Descobrir o link para gerar o Load page
	    function DiscoverLink($link = LINK, $sizeof = false){
	    	if ($link != 'login')
	    		$link = (isset($_GET['id'])) ? substr($link, 0, $sizeof) : $link;
	    	else
         		$link = (isset($_GET['email'])) ? substr($link, 1) : $link;
         	return $link;
	    }
	    
	    # 5 - Gerador de Senha Aleatória
	    function RandomPass($size = 10, $ma = true, $mi = true, $nu = true, $si = false){
	    	#letras maiusculas e minusculas
	    	foreach(range('a', 'z') as $mi) {
	    		$mi;
	    		$ma = strtoupper($mi);
	    	}
	    	#numeros
		 	foreach(range(0, 9) as $nu) { $nu; }
		 	#simbolos
		 	foreach(range('!', '+') as $si) { $si; }
		 
		 	if ($ma || $mi || $nu || $si){
		 		$password = str_shuffle($ma); 		# se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
		        $password .= str_shuffle($mi);		# se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
		        $password .= str_shuffle($nu);		# se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
		        $password .= str_shuffle($si);		# se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
		    }
	    	return substr(str_shuffle($password), 0, $size);	# retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
		}
		
		# 5 - Exibe a imagem gravada no BD ou a imagem gravada no site Gravatar.com
		function Gravatar($email = MAIN_EMAIL, $s = 240, $d = 'mp', $r = 'g', $img = false, $atts = array(), $photo = ''){
			$Load = new Load;
			$Tables = new Tables;
			$PDO = $Load->DataBase();
			switch (LINK) {
				case 'employees': case 'teachers': case 'students':
					$con = $PDO->query($Tables->SelectFrom($Tables->Found_Item('id', $link).' AS id', $link.', users WHERE '.$link.'.id_use = users.id_use')) or die ($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)) {
						$id = $row->id;
						#echo $Tables->SelectFrom('photo, email', $link.', users WHERE '.$link.'.id_use = users.id_use and users.id_use = '.$id);
						$con = $PDO->query($Tables->SelectFrom('photo, email', $link.', users WHERE '.$link.'.id_use = users.id_use and users.id_use = '.$id)) or die ($PDO);
					}
				break;

				case 'classroom':
					$con = $PDO->query($Tables->SelectFrom('id_stu', 'students, users WHERE students.id_use = users.id_use')) or die ($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)) {
						$id = $row->id_stu;
						#echo $Tables->SelectFrom('photo, email', $link.', students, users WHERE students.id_cla = '.$link.'.id_cla AND students.id_use = users.id_use and students.id_stu = '.$id);
						$con = $PDO->query($Tables->SelectFrom('photo, email', $link.', students, users WHERE students.id_cla = '.$link.'.id_cla AND students.id_use = users.id_use and students.id_stu = '.$id)) or die ($PDO);
					}
				break;
				
				case 'profile': 
					$id = (isset($_GET['id'])) ? $_GET['id'] : $_SESSION['id'];
					#echo $Tables->SelectFrom('photo, email', 'users WHERE id_use = '.(isset($_GET['id'])) ? $_GET['id'] : $_SESSION['id']);
					$con = $PDO->query($Tables->SelectFrom('photo, email', 'users WHERE id_use = '.$id)) or die ($PDO);
				break;
			}
			#while($row = $con->fetch(PDO::FETCH_OBJ)) {
			#	$email = $row->email;
			#	$photo = isset($row->photo) ? 'uploads/'.$row->photo : '';
			#}
			
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

		function WhatLink($link = LINK){
			switch ($link) {
				case 'coordinators': $str = 'Coordenadores'; break;
		    	case 'classroom': $str = 'Turmas'; break;
		    	case 'courses': $str = 'Cursos'; break;
		    	case 'directors': $str = 'Diretores'; break;
		    	case 'disciplines': $str = 'Disciplinas'; break;
		    	case 'employees': $str = 'Funcionários'; break;
		    	case 'historic': $str = 'Notas'; break;
		   		case 'notifies': $str = 'Notificações'; break;
		    	case 'profile': $str = 'Perfil'; break;
		    	case 'schedule-grid': $str = 'Grade'; break;
		    	case 'students': $str = 'Estudantes'; break;
				case 'teachers': $str = 'Professores'; break;
	    		case 'new-user': $str = 'Cadastro'; break;
		    }
		    
		    return $str;
		}
	}
	$Load = new Load;
	define('SERVER', $Load->Server());

	# Classe Referente a Navegação das Páginas
	class Navegation {
		# 1 - Gera o Menu de topo se o usuário estiver logado. Menu irá variar de acordo com o tipo de usuário
	    function HeroMenu(
	    	$menu = '
		    	<div class="hero-head">
		        		<nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
						  	<div class="navbar-brand">
							    <a class="navbar-item is-logo" href="'.SERVER.'">rÁpidA</a>
							    <div class="navbar-burger burger" data-target="navMenubd-example">
							    	<span></span>
							    	<span></span>
							    	<span></span>
							    </div>
						  	</div>
	                    	<div id="navMenubd-example" class="navbar-menu">
		    					<div class="navbar-start">'
		){
	    	$Load = new Load;
	    	$Tables = new Tables;
	        $Login = new Login;
			switch ($Login->IsLogged()) {
	            case true:
	    			$PDO = $Load->DataBase();
	    			$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1')) or die ($PDO);
	    			while($row = $con->fetch(PDO::FETCH_OBJ)){
						switch ($row->type_use){
							case 1:
							case 2:
							case 3: 
								#diretor, coordenador e funcionário estão unificados no momento
								$menu .= '
	    							<div class="navbar-item has-dropdown is-hoverable">
		        						<a class="navbar-link is-active" href="#"><i class="fas fa-users"></i>&nbsp;Usuários</a>
		        						<div class="navbar-dropdown ">
		        							<a class="dropdown-item " href="'.SERVER.'new-user">'.$Load->WhatLink('new-user').'</a>
		        							<a class="dropdown-item " href="'.SERVER.'employees">'.$Load->WhatLink('employees').'</a>
		        							<hr class="navbar-divider">
		        							<a class="dropdown-item " href="'.SERVER.'teachers">'.$Load->WhatLink('teachers').'</a>
		        							<a class="dropdown-item " href="'.SERVER.'#">'.$Load->WhatLink('coordinators').'</a>
		        							<a class="dropdown-item " href="'.SERVER.'#">'.$Load->WhatLink('directors').'</a>
		        							<hr class="navbar-divider">
		        							<a class="dropdown-item " href="'.SERVER.'students">'.$Load->WhatLink('students').'</a>
		        							<!--<a class="dropdown-item" href="'.SERVER.'classroom">'.$Load->WhatLink('classroom').'</a>-->
		        						</div>
		        					</div>
		        					<div class="navbar-item has-dropdown is-hoverable">
		        						<a class="navbar-link is-active" href="#"><i class="fas fa-book-open"></i>&nbsp;Cursos e Disciplinas</a>
		        						<div class="navbar-dropdown ">
		        							<a class="dropdown-item " href="'.SERVER.'courses">'.$Load->WhatLink('courses').'</a>
		        							<a class="dropdown-item " href="'.SERVER.'disciplines">'.$Load->WhatLink('disciplines').'</a>
		        							<!--<a class="dropdown-item " href="'.SERVER.'schedule-grid">'.$Load->WhatLink('schedule-grid').'</a>-->
		        						</div>
		        					</div>
									<!--<a class="navbar-item" href="'.SERVER.'events"><i class="fas fa-graduation-cap"></i>&nbsp;'.$Load->WhatLink('events').'</a>-->';
							break;
												
							case 4:
								#professor
								$menu .= '
	    						<a class="navbar-item" href="'.SERVER.'notifies"><i class="fas fa-book-open"></i>&nbsp;'.$Load->WhatLink('notifies').'</a>
								<a class="navbar-item" href="'.SERVER.'"><i class="fas fa-graduation-cap"></i>&nbsp;Formandos</a>';
							break;
							case 5:
							#aluno
								$menu .= '
	                    		<a class="navbar-item" href="'.SERVER.'historic"><i class="fas fa-book-open"></i>&nbsp;'.$Load->WhatLink('historic').'</a>
								<a class="navbar-item" href="'.SERVER.'#"><i class="far fa-file"></i>&nbsp;Documentos</a>';
							break;
	    			}
	    		}
	                $menu .= '
	                    </div>
	                    <!--<a class="navbar-item" href="search">
							<i class="fas fa-search" aria-hidden="true"></i>&nbsp;<span><input class="input" type="search" placeholder="Procurar..."></span>
						</a>-->
	                    <div class="navbar-end">
							<a class="navbar-item" href="'.SERVER.'profile"><i class="fas fa-user"></i>&nbsp;'.$Load->WhatLink('profile').'</a>
	                    	<a class="navbar-item" href="'.SERVER.'notifies"><i class="fas fa-bell"></i>&nbsp;'.$Load->WhatLink('notifies').'</a>
	                    	<a class="navbar-item" href="'.SERVER.'#"><i class="fas fa-book"></i>&nbsp;Biblioteca</a>
							<a class="navbar-item" href="'.SERVER.'logout"><i class="fas fa-sign-out-alt"></i>&nbsp;Sair</a>
						</div>
					</div>
		        </nav>';
	            break;
	                    			
	            case false:
	                $menu .= '
	                    </div>
			            <div class="navbar-end">
				    		<a class="navbar-item" href="'.SERVER.'login"><i class="fa fa-user"></i>&nbsp;Login</a>
				    		<a class="navbar-item" href="'.SERVER.'example"><i class="fab fa-superpowers"></i>&nbsp;Exemplos</a>
				    		<a class="navbar-item" href="'.SERVER.'#"><i class="fab fa-github"></i>&nbsp;Instale</a>
				    	</div>
		        	</nav>';
	            break;
	        }            		
            return $menu;
    	}

    	# 2 - Gera a informação e um mapa rápido de acesso através do link informado
	    function MainNavegation($link = LINK, $mess = '<ul>Você está em: &nbsp;'){
	    	$Load = new Load;
	    	if(!$link || $link == 'index') {
	    		$mess .= '<li class="is-active"><a href="'.SERVER.'" aria-current="page">Início</a></li>';
	    	} else {
		    	$mess .='
	    			<li class=""><a href="'.SERVER.'" aria-current="page">Início</a></li>
	    			<li class="is-active"><a href="'.SERVER.''.$link.'" aria-current="page">'.ucfirst($Load->WhatLink($link)).'</a></li>';
	    	}
	    	return $mess .= '</ul>';
	    }


	    # 2.1 - Mostra um menu personalizado, com mapa de acesso, através do link e do tipo de usuário informado
    	function FooterMenu(
	    	$menu = '
	    		<div class="columns">
		    		<div class="column is-3">
			    		<aside class="menu is-hidden-mobile">
			        	<p class="menu-label">Gerais</p>
				        	<ul class="menu-list">
				                <li><a href="'.SERVER.'" class="is-active">Início</a></li>
				                <li><a href="'.SERVER.'profile">Perfil</a></li>
				                <li><a href="'.SERVER.'notifies">Notificações</a></li>
				                <li><a href="'.SERVER.'#">Biblioteca Online</a></li>
				            </ul>
						</aside>
					</div>
				<div class="column is-3">'
    	) {
    		$Load = new Load;
    		$Tables = new Tables;
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
		                            <a href="#">Cursos e Disciplinas</a>
		                            <ul>
		                                <li><a href="'.SERVER.'courses">'.$Load->WhatLink('courses').'</a></li>
		                                <li><a href="'.SERVER.'disciplines">'.$Load->WhatLink('disciplines').'</a></li>
		                                <!--<li><a href="'.SERVER.'schedule-grid">Grade de Horários</a></li>-->
		                            </ul>
		                        </li>
		                        <li>
		                            <a href="#">Usuários</a>
		                            <ul>
		                            	<li><a href="'.SERVER.'new-user">Cadastrar</a></li>
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
		                        <li><a href="'.SERVER.'#">Rematrícula</a></li>
		                    </ul>
		                    </div>
		                    </div>';
					break;
				}
    		}
    		return $menu;
    	}
	    function HeroMessage(){
	    	$Load = new Load;
	    	$Tables = new Tables;
	    	$PDO  = $Load->DataBase();
	    	$title = $subtitle = '';
	    	switch(LINK){
	    		case '': case SERVER:
	    			$title = 'Olá, '.$_SESSION['name']; 
	    			$subtitle = 'Tenha um bom dia!';
	    		break;

	    		case 'historic':
					$title = $Load->WhatLink('historic');
	    			$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use = '.$_SESSION['id'])) or die ($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)){
						switch($row->type_use){
							case 5: $name_use = $_SESSION['name']; break;
							default: 
								$id = (isset($_GET['id'])) ? $_GET['id'] : '';
								$con = $PDO->query($Tables->SelectFrom('name_use', 'users WHERE id_use = '.$id)) or die ($PDO);
								while($row = $con->fetch(PDO::FETCH_OBJ)){ 
									$name_use = $row->name_use; 
								}
							break;
						}
					}
	    			$subtitle = 'Histórico de notas de '.$name_use;
	    		break;
	    	}
	    	$hero = '
    		<section class="hero is-info welcome is-small">
			    <div class="hero-body">
			        <div class="container">
			        	<h1 class="title is-medium is-white">'.$title.'</h1>
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
    	
		function LoadTablePage($name_page = LINK){
			#$str = substr($name_page, 1, (MAX-5));
			$Load = new Load;
			$PDO = $Load->DataBase();
			$Tables = new Tables;
			$script = $name_page;
			$type_table = $Tables->Found_Item('type', $name_page);
			$id = $Tables->Found_Item('id', $name_page);
			$name_table = $Tables->Found_Item('name', $name_page);
			switch ($name_page) {
			    case 'classroom':
			        $th = '<th></th><th>Nome do Curso</th><th>Tipo de Curso</th>';
					$script .= ', courses WHERE '.$name_page.'.id_cou = courses.id_cou';
					$titulo = 'Turmas';
					$icon = '<i class="fas fa-users"></i>';
					$type_table = $Tables->Found_Item('type', 'courses');
					$name_table = $Tables->Found_Item('name', 'courses');
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
					$th = '<th></th><th>Titulo</th><th>Tipo da Notificação</th><th>Nome do Usuário</th>';
					$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1')) or die ($PDO);
					$script .= ', users WHERE users.id_use = '.$name_page.'.id_use';
					$titulo = 'Notificações';
					$icon = '<i class="fas fa-bell"></i>';
					while($row = $con->fetch(PDO::FETCH_OBJ)){
						switch ($row->type_use){
							case 2: break;
							case 4: case 5: $script .=' AND users.id_use = '.$_SESSION['id']; break;
							default: break;
						}
						
					}
				break;
				case 'users':
					$th = '<th></th><th>Nome</th><th>Tipo do Usuário</th><th></th>';
					$titulo = 'usuários';
					$icon = '<i class="fas fa-users"></i>';
				break;
			}
			;
			#echo $script;
			$con = $PDO->query($Tables->SelectFrom(null, $script)) or die ($PDO);
			#echo $Tables->CountViewTable(null, $script);
			$cont = $Tables->CountViewTable(null, $script);
			echo '
			    	<div class="card events-card">
			            <header class="card-header">
			                <p class="card-header-title">'.ucfirst($titulo).'</p>
			                <a href="'.$name_page.'" class="card-header-icon" aria-label="more options"><span class="icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span></a>
			            </header>
			            <div class="card-table">
			                <div class="content">
			                    <table class="table is-fullwidth is-striped">
			                    	<thead><tr>'.$th.'</tr></thead>
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
													case 1: $type = 'Solicitação'; $color = 'is-primary'; break;
													case 2: $type = 'Revisão'; $color = 'is-warning'; break;
													case 3: $type = 'Matrícula'; $color = 'is-success'; break;
													case 4: $type = 'Ocorrência'; $color = 'is-danger'; break;
													case 5: $type = 'Trancamento'; $color = 'is-dark'; break;
													case 6: $type = 'Histórico'; $color = 'is-link'; break;
													case 7: $type = 'Outros'; $color = 'is-primary'; break;
												}
												$col_3 = '<a class="button '.$color.' is-small">'.$type.'</a>';
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
												#$col_5 = '<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'.$action_button.'</a>';
												$col_5 = '';
								    		break;
								    		case 'users':
								    			#$photo = ($row->photo) ? SERVER.'uploads/'.$row->photo : $Load->Gravatar($row->email);
								    			$col_1 = '<a href="'.SERVER.'profile?id='.$row->id_use.'" class="button is-link is-small"><i class="fas fa-pencil-alt"></i></a>';
								    			$col_2 = $row->$name_table;
								    			switch ($row->type_use) {
								    				case 1:$type = 'Diretor';break;
								    				case 2:$type = 'Coordenador';break;
								    				case 3:$type = 'Funcionário';break;
								    				case 4:$type = 'Professor';break;
								    				case 5:$type = 'Aluno'; break;
								    			}
								    			#$col_2 = '<figure class="image is-32x32"><img class="is-rounded" src="'.$photo.'">';
								    			$col_3 = $type;
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

		function LoadSuperTablePage($link = LINK, $th = ''){
			$id = (isset($_GET['id'])) ? $_GET['id'] : '';
			$Load = new Load;
			$PDO = $Load->DataBase();
			$Tables = new Tables;
			$table = '';
			switch ($link) {
		        case 'classroom':
		        	$th = '<th colspan="2">Aluno</th><th>RA</th><th>Data de Matrícula</th><th>Data de Aniversário</th>';
					$name_table = 	$name_page.', courses, students, users';
					$name_table .= ' WHERE '.$name_page.'.id_cla = '.$id;
					$name_table .= ' AND '.$name_page.'.id_cou = courses.id_cou';
					$name_table .= ' AND students.id_cla = '.$name_page.'.id_cla';
					$name_table .= ' AND students.id_use = users.id_use AND users.type_use = 5';
				break;
				case 'historic':
					$th = '<th colspan="2">Aluno</th><th colspan="2">Notas</th><th colspan="2">Faltas</th><th colspan="2">Abonos</th><th>Média Final</th>';
					#Verificar se o tipo do usuário é aluno ou não
					$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use = '.$_SESSION['id'])) or die ($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)){
						switch($row->type_use){
							case 5: 
								$id = $_SESSION['id'];
								$name_use = $_SESSION['name'];
							break;
							default:
								$id = (isset($_GET['id'])) ? $_GET['id'] : '';
								if(!$id){
									$title = 'Ops';
									$message = 'Houve problemas durante a sua requisição.';
									$links[1] = SERVER; $links[2] = 'Início';
									$links[3] = '#';  $links[4] = 'Voltar aonde estava';
									include('ops.php');
									exit;
								}
							break;
						}
						$table =  $link.', students, disciplines, users';
						$table .= ' WHERE '.$link.'.id_dis = disciplines.id_dis'; 
						$table .= ' AND '.$link.'.id_stu = students.id_stu';
						$table .= ' AND students.id_use = users.id_use';
						$table .= ' And users.id_use = '.$id;
					}
				break;
			}
			#echo $Tables->SelectFrom(null, $table);
		    $con = $PDO->query($Tables->SelectFrom(null, $table)) or die ($PDO);
		    #$id = $Tables->Found_Item('id', $name_page);
		    #$name_table = $Tables->Found_Item('name', $name_page);

		    echo '<table class="table is-fullwidth is-striped"><thead><tr>'.$th.'</tr></thead><tbody>';						
			while($row = $con->fetch(PDO::FETCH_OBJ)){
				$name_use = $row->name_use;
				#$name_cou = $row->name_cou;
				$photo = $Load->Gravatar();
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
					    $col_3 = $row->n1;
						$col_4 = $row->n2;
						$col_5	= $row->mp;
						$col_6	= $row->fi;
						$col_7	= $row->fa;
						$col_8	= $row->f;
						$col_9	= $row->mf;
						$col_10	= $row->status_his;
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

		function LoadArticlePage($name_page = LINK){
			$Load = new Load;
			$Tables = new Tables;
			$PDO = $Load->DataBase();
			$pg = isset($_GET['pg']) ? $_GET['pg'] : '';
			$script = $name_page;
			switch ($name_page){
				default:
		    		$name_table = $Tables->Found_Item('name', $name_page);
				break;
				case 'employees': 
					$script.=', users  WHERE '.$name_page.'.id_emp = users.id_use'; 
					$name_table = $Tables->Found_Item('name', 'users'); 
				break;
			}

			#echo $Tables->SelectFrom(null, $script, (1 * $pg), (10 * $pg));
		    $query = $PDO->query($Tables->SelectFrom(null, $script, (1 * $pg), (10 * $pg))) or die ($PDO);
		    $cont = $Tables->CountViewTable(null, $script);

		    while($row = $query->fetch(PDO::FETCH_OBJ)){
		    	$id = $Tables->Found_Item('id', $name_page);
		    	$edit_link = $name_page.'?id='.$row->$id;
		    	$status_table = $Tables->Found_Item('status', $name_page);
		   		$action_link = ($status_table) ? 'deactivate?t='.$name_page.'?id='.$row->$id : 'activate?t='.$name_page.'?id='.$row->$id;
				$action_color = ($status_table) ? 'danger' : 'success';
				$action_button = ($status_table) ? '<i class="fas fa-minus-circle"></i>' : '<i class="fas fa-check-square">';
				$content = '';
				#$img = '<img class="is-rounded" src="'.$Load->Gravatar().'">';
		    	$titulo = $row->$name_table;
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
					
					case 'employees':
					case 'teachers':
					case 'students':
					#case 'users':
						#echo $id;
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

						$user = $login = ($row->login) ? $row->login : '';
						$email = ($row->email) ? $row->email : '';
						$img = isset($row->photo) ? '<img class="is-rounded" src="'.$row->photo.'">' : '<img class="is-rounded" src="'.$Load->Gravatar().'">';
						
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

						$content = 'Idade: '.$age.'<br/>';
						$content .= $tipo.' desde '.$signup_year.'<br/>';
						$content .= 'Login: <a href="'.$link.'">'.$user.'</a>';
					break;
				}
				echo '
					<article class="post">
						<h4>'.$titulo.'</h4>
						<div class="media">
							<div class="media-left">'.$img.'</div>
							<div class="media-content">
								<div class="content">
									<p>'.$content.'</p>
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

		function LoadOptionsPage($name_page = LINK){
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