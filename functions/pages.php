<?php
	# Classe que cataloga as funções referentes as páginas
    class Pages {
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
					$con = $PDO->query($Tables->LoadFrom('type_use','users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1', 0, 1)) or die ($PDO);
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
					#$con = $PDO->query($Tables->LoadFrom($script)) or die ($PDO);
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
						$con = $PDO->query($Tables->LoadFrom('type_use', 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1', 0, 1)) or die ($PDO);
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
				$script = $Tables->LoadFrom($name_table, 0, 10);
				#echo $script;
			    $con = $PDO->query($script) or die ($PDO);
			    #$cont = $Tables->CountViewTable($name_table);

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
													case 1: 
														$type = 'Solicitação'; 
													break;
													case 2: 
														$type = 'Revisão'; 
													break;
													case 3: 
														$type = 'Matrícula'; 
													break;
													case 4: 
														$type = 'Ocorrência'; 
													break;
													case 5: 
														$type = 'Trancamento'; 
													break;
													case 6: 
														$type = 'Histórico'; 
													break;
													case 7: 
														$type = 'Outros'; 
													break;
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

			$script = $Tables->LoadFrom($name_table, 0, 10);
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

		    $query = $PDO->query($Tables->LoadFrom($script)) or die ($PDO);
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
							case 'M':
								$period = 'Manhã';
							break;

							case 'T':
								$period = 'Tarde';
							break;
								
							case 'N':
								$period = 'Noite';
							break;

							case 'I':
								$period = 'Integral';
							break;
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
    }
    $Pages = new Pages;