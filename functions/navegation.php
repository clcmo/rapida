<?php
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
    								$con = $PDO->query($Tables->LoadFrom('type_use', 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1', 0, 1)) or die ($PDO);
    								while($row = $con->fetch(PDO::FETCH_OBJ)){
					    				switch ($row->type_use){
											case 1:
												#diretor
											break;

											case 2:
												#coordenador
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
	    			case 'classroom': $str = 'turmas'; break;
	    			case 'courses': $str = 'Cursos'; break;
	    			case 'disciplines': $str = 'Disciplinas'; break;
	    			case 'employees': $str = 'funcionários'; break;
	    			case 'historic': $str = 'Notas'; break;
	    			case 'notifies': $str = 'Notificações'; break;
	    			case 'profile': $str = 'perfil'; break;
	    			case 'schedule-grid': $str = 'grade'; break;
	    			case 'students': $str = 'estudantes'; break;
					case 'teachers': $str = 'professores'; break;
	    			case 'users': $str = 'usuários'; break;
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
    		$con = $PDO->query($Tables->LoadFrom('type_use', 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1', 0, 1)) or die ($PDO);
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
	$Navegation = new Navegation;