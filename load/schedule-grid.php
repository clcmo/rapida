<?php
	$id = (isset($_GET['id'])) ? $_GET['id'] : '';

	$name_page = 'disciplines';
	$name_table = $Tables->Found_Item('name', $name_page);
	$status_table = $Tables->Found_Item('status', $name_page);
	$id_table = $Tables->Found_Item('id', $name_page);

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
			<tbody>';

			# Puxar as informações das tabelas
			$script = $name_page.', courses WHERE '.$name_page.'.id_cou = courses.id_cou AND courses.id_cou = '.$id;
			$sql = $Tables->LoadFrom($script);
			$query = $PDO->query($sql) or die ($PDO);
			while($row = $query->fetch(PDO::FETCH_OBJ)){
				$class_time_start = array();
				$class_time_end = array();
				$class_time = array();
				switch ($row->period) {
					case 'I':
						$classes = 8;
						$class_time_start[1] = "07:30";
						$class_time_start[2] = $class_time_end[1] = "08:20";
						$class_time_start[3] = $class_time_end[2] = "09:10";
						$break_start = $class_time_end[3] = "10:00";
						$class_time_start[4] = $break_end = "10:20";
						$class_time_start[5] = $class_time_end[4] = "11:10";
						$lunch_start = $class_time_end[5] = "12:00";
						$class_time_start[6] = $lunch_end = "13:00";
						$class_time_start[7] = $class_time_end[6] = "13:50";
						$class_time_start[8] = $class_time_end[7] = "14:40";
						$class_time_end[8] = "15:30";
					break;
					
					case 'T':
						$classes = 6;
						$class_time_start[1] = "13:00";
						$class_time_start[2] = $class_time_end[1] = "13:50";
						$class_time_start[3] = $class_time_end[2] = "14:40";
						$break_start = $class_time_end[3] = "15:30";
						$class_time_start[4] = $break_end = "15:45";
						$class_time_start[5] = $class_time_end[4] = "16:35";
						$class_time_start[6] = $class_time_end[5] = "17:25";
						$lunch_start = $class_time_end[6] = "18:00";
						$lunch_end = "19:00";
					break;

					case 'N':
						$classes = 4;
						$class_time_start[1] = "19:00";
						$class_time_start[2] = $class_time_end[1] = "19:50";
						$break_start = $class_time_end[2] = "20:40";
						$class_time_start[3] = $break_end = "21:00";
						$class_time_start[4] = $class_time_end[3] = "21:50";
						$class_time_end[4] = "22:40";
					break;

					case 'M':
					break;
				}

				for ($i = 1; $i <= $classes; $i++){
					$class_time[$i] = $class_time_start[$i].' - '.$class_time_end[$i];
					echo '
						<th>'.$i.'</th>
						<th>'.$class_time[$i].'</th>';
						$sql = $Tables->LoadFrom($script.' AND '.$name_page.'.time_start = "'.$class_time_start[$i].':00"');
						$query = $PDO->query($sql) or die ($PDO);
						while($row = $query->fetch(PDO::FETCH_OBJ)){
							echo'<td><a href="'.$name_page.'?id='.$row->id_dis.'">'.$row->$name_table.'<br/>'.$row->classroom.'</td>';
						}
					echo '</tr>';
				}
			}
			echo'
			</tbody>
		</table>';