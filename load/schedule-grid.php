<?php
	$name_page = 'disciplines';
	$name_table = $Tables->Found_Item('name', $name_page);
	$status_table = $Tables->Found_Item('status', $name_page);
	$id_table = $Tables->Found_Item('id', $name_page);

	//Verificar por horário?
	$script = $name_page.', courses WHERE '.$name_page.'.id_cou = courses.id_cou';
	
	echo'
		<table>
			<thead>
				<tr>
					<th>Aula</th>
					<th>Horário</th>
				    <th>Segunda</th>
				    <th>Terça</th>
				    <th>Quarta</th>
				    <th>Quinta</th>
				    <th>Sexta</th>
				    <th>Sábado</th>
	      		</tr>
	  		</thead>
			<tbody>
				<tr>
					<th>1</th>
					<th>07:30 - 08:20</th>';
					$sql = $Tables->LoadFrom($script.' AND time_start = "07:40:00"');
					$query = $PDO->query($sql) or die ($PDO);
					while($row = $query->fetch(PDO::FETCH_OBJ)){
						echo'<td>'.$row->$name_table.'</td>';
					}
			echo'
				</tr>
				<tr>
					<th>2</th>
					<th>08:20 - 09:10</th>';
					$sql = $Tables->LoadFrom($script.' AND time_start = "07:40:00" OR time_start = "08:20:00"');
					$query = $PDO->query($sql) or die ($PDO);
					while($row = $query->fetch(PDO::FETCH_OBJ)){
						echo'<td>'.$row->$name_table.'</td>';
					}
			echo'
				</tr>
			</tbody>
		</table>';