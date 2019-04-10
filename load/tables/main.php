<?php
	$script = $name_page;
	switch ($name_page) {
        case 'classroom':
        	$th = '
                    <th></th>
					<th>Nome do Curso</th>
					<th>Tipo de Curso</th>';
			$script .= ', courses WHERE '.$name_page.'.id_cou = courses.id_cou';
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
			#$script = $name_page;
			$titulo = 'Cursos';
			$icon = '<i class="fas fa-pencil-alt"></i>';
			
			
		break;
		case 'disciplines': 
			$th = '
				<th>Nome</th>
				<th>Nome do Curso</th>
				<th>Professor</th>';
			$script .= ', `courses`, `teachers`, `users` WHERE disciplines.id_cou = courses.id_cou AND disciplines.id_tea = teachers.id_tea AND teachers.id_use = users.id_use';
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

			$sql = $Tables->LoadFrom('users WHERE id_use = '.$_SESSION['id'].' AND status_use = 1 LIMIT 1');
			$con = $PDO->query($sql) or die ($PDO);
	
			$script .= ', users WHERE users.id_use = '.$name_page.'.id_use';
			$titulo = 'Notificações';
			$icon = '<i class="fas fa-bell"></i>';
			while($row = $con->fetch(PDO::FETCH_OBJ)){
				switch ($row->type_use){
					case 1:
					case 3:
						$script .=' AND users.id_use = '.$_SESSION['id'];
					break;

					default:
					break;
				}
				$type_table = $Tables->Found_Item('type', $name_page);
			}
		break;
		case 'users':
		break;
	}

	$script = (LINK != $name_page.'#show_all') ? $script : $script.' LIMIT '.$vi.','.$vf;
    $con = $PDO->query($Tables->LoadFrom($script)) or die ($PDO);
    $cont = $Tables->CountViewTable($script);

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
					    			$col_1 = '<a href="'.SERVER.'profile?id='.$row->id_usu.'" class="button is-link is-small"><i class="fas fa-pencil-alt"></i></a>';
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