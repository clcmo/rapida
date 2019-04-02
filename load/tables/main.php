<?php
	$script = (LINK != $name_page.'#show_all') ? $script : $script.' LIMIT 0, 5';

	$sql = $Tables->LoadFrom($script);
    $query = $PDO->query($sql) or die ($PDO);

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
                    		<tr>';
                    		switch ($name_page) {
                    			case 'classroom': 
                    				echo '
                    					<th>Nome</th>
										<th>Tipo de Curso</th>';
								break;
								case 'courses':
									echo '
										<th>Nome</th>
										<th>Tipo de Curso</th>
										<th>Período</th>';
								break;
								case 'disciplines': 
									echo '
										<th>Nome</th>
										<th>Nome do Curso</th>
										<th>Professor</th>';
								break;
								case 'notifies':
									echo '
										<th>Titulo</th>
										<th>Tipo da Notificação</th>
										<th>Nome do Usuário</th>';
								break;
							}
						echo'
							</tr>
						</thead>
                    	<tbody>';
					    while($row = $query->fetch(PDO::FETCH_OBJ)){
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
					    			$col_1 = $row->name_cou;
					    			$type = ($row->$type_table == 1) ? 'Ensino Médio' : 'Ensino Modular';
					    			$col_2 = '<a class="button is-light is-inverted is-small">'.$type.'</a>';
					    			$col_3 = '<a href="'.$name_page.'?id='.$row->$id.'" class="button is-link is-small">'.$icon.'</a>';
									$col_4 = '<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'.$action_button.'</a>';
									$col_5 = '';
					    		break;

					    		case 'courses':
					    			$col_1 = $row->$name_table;
					    			$type = ($row->$type_table == 1) ? 'Ensino Médio' : 'Ensino Modular';
					    			$col_2 = '<a class="button is-light is-inverted is-small">'.$type.'</a>';

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

					    			$col_3 = '<a href="schedule-grid?id='.$row->$id.'" class="button is-'.$col_period.' is-small">'.$period.'</a>';
					    			$col_4 = '<a href="'.$name_page.'?id='.$row->$id.'" class="button is-link is-small">'.$icon.'</a>';
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
									$col_1 = $row->$name_table;
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
									$col_2 = '<a class="button is-light is-inverted is-small">'.$type.'</a>';
									$col_3 = $row->name_use;
									$col_4 = '<a href="'.$name_page.'?id='.$row->$id.'" class="button is-link is-small">'.$icon.'</a>';
									switch ($row->$status_table) {
										case 1:
											$action_link = 'get_doc?t='.$name_page.'?id='.$row->$id;
											$action_color = 'success';
											$action_button = '<i class="fas fa-file"></i>';
										break;

										case 2: 
											$action_link = 'view_doc?t='.$name_page.'?id='.$row->$id;
											$action_color = 'primary';
											$action_button = '<i class="fas fa-file">';
										break;
									}
									$col_5 = '<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'. $action_button.'</a>';
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
                <footer class="card-footer"><a href="'.$name_page.'" class="card-footer-item">Ver Todas</a></footer>
            </div>';
	