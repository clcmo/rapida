<?php
	switch ($name_page) {
        case 'classroom':
        	$th = '
                    <th colspan="2">Aluno</th>
					<th>RA</th>
				    <th>Data de Matrícula</th>
				    <th>Data de Aniversário</th>';
			$script = 	$name_page.', courses, students, users';
			$script .= ' WHERE '.$name_page.'.id_cla = '.$id;
			$script .= ' AND '.$name_page.'.id_cou = courses.id_cou';
			$script .= ' AND students.id_cla = '.$name_page.'.id_cla';
			$script .= ' AND students.id_use = users.id_use AND users.type_use = 1';
		break;

		case 'historic':
			$th = '
					<th colspan="2">Aluno</th>
				    <th colspan="2">Notas</th>
				    <th colspan="2">Faltas</th>
				    <th colspan="2">Abonos</th>
				    <th>Média Final</th>';
			$script = 	'classroom, courses, students, users';
			$script .= 	' WHERE classroom.id_cou = courses.id_cou';
			$script .= 	' AND students.id_cla = classroom.id_cla';
			$script .=	' AND students.id_use = users.id_use AND courses.id_cou = '.$id;
		break;
	}

	$script = (LINK != $name_page.'#show_all') ? $script : $script.' LIMIT '.$vi.','.$vf;
    $con 	= $PDO->query($Tables->LoadFrom($script)) or die ($PDO);

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