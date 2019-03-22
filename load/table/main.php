<?php
	$script = (LINK != $name_page.'#show_all') ? $script : $script.' LIMIT 0, 5';

	$sql = $Tables->LoadFrom($script);
    $query = $PDO->query($sql) or die ($PDO);
    //$titulo = ($name_page != 'notifies') ? 'Turmas' : 'Notificações';

    echo '
		<div class="card events-card">
            <header class="card-header">
                <p class="card-header-title">'.ucfirst($titulo).'</p>
                <a href="'.$name_page.'#show_all" class="card-header-icon" aria-label="more options"><span class="icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span></a>
            </header>
            <div class="card-table">
                <div class="content">
                    <table class="table is-fullwidth is-striped">
                    	<tbody>';
					    while($row = $query->fetch(PDO::FETCH_OBJ)){
							$name_table = $Tables->Found_Item('name', $script);
							$id = $Tables->Found_Item('id', $script);

							$col_1 = '<a href="?id='.$row->$id.'" class="button is-link is-small"><i class="fas fa-bell"></i></a>';
							$col_2 = isset(($row->$name_table)) ? $row->$name_table : $row->name_cou;
							
							$col_3 = '<a class="button is-dark is-primary is-small">'.$button_title_2.'</a>';
							$col_5 = '<a class="button is-light is-inverted is-small" href="'.$name_page.'?id='.$row->$id.'">'.$button_title.'</a>';

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
	