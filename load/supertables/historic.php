<?php
	$name_page = 'historic';
	include ('main.php');
/*
	$id = (isset($_GET['id'])) ? $_GET['id'] : '';

	$name_page = 'classroom';
	$name_table = $Tables->Found_Item('name', $name_page);
	$status_table = $Tables->Found_Item('status', $name_page);
	$id_table = $Tables->Found_Item('id', $name_page);

	echo'
		<table>
			<thead>
				<tr>
					<th colspan="2">Aluno</th>
				    <th colspan="2">Notas</th>
				    <th colspan="2">Faltas</th>
				    <th colspan="2">Abonos</th>
				    <th>Média Final</th>
	      		</tr>
	  		</thead>
			<tbody>';
			# Puxar as informações das tabelas
			$script = $name_page.', courses, students, users WHERE '.$name_page.'.id_cou = courses.id_cou AND students.id_cla = '.$name_page.'.id_cla AND students.id_use = users.id_use AND courses.id_cou = '.$id;
			$sql = $Tables->LoadFrom($script);
			$query = $PDO->query($sql) or die ($PDO);
			while($row = $query->fetch(PDO::FETCH_OBJ)){
				$name_use = $row->name_use;
				$pic = ($row->photo != null) ? SERVER.'uploads/'.$row->photo : $Load->Gravatar($row->email);
				echo '
					<th><p class="image is-64x64"><img class="is-rounded" src="'.$pic.'"></th>
					<th>'.$name_use.'</p></th>';
					$sql = $Tables->LoadFrom($script.' AND users.id_use = '.$row->id_use);
					$query = $PDO->query($sql) or die ($PDO);
					while($row = $query->fetch(PDO::FETCH_OBJ)){
						echo'
							<td>10</td>
							<td>10</td>
							<td>5</td>
							<td>3</td>
							<td>5</td>
							<td>3</td>
							<td>7</td>';
					}
			}
		echo'
			<tbody>
		</table>';*/