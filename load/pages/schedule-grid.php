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
				$name_cou = $row->name_cou;
				$start = array();
				$end = array();
				$class_time = array();
				switch ($row->period) {
					case 'I':
						$classes = 8;
						$start[1] = "07:30";
						$start[2] = $end[1] = "08:20";
						$start[3] = $end[2] = "09:10";
						$break_start = $end[3] = "10:00";
						$start[4] = $break_end = "10:20";
						$start[5] = $end[4] = "11:10";
						$lunch_start = $end[5] = "12:00";
						$start[6] = $lunch_end = "13:00";
						$start[7] = $end[6] = "13:50";
						$start[8] = $end[7] = "14:40";
						$end[8] = "15:30";
					break;
					
					case 'T':
						$classes = 6;
						$start[1] = "13:00";
						$start[2] = $end[1] = "13:50";
						$start[3] = $end[2] = "14:40";
						$break_start = $end[3] = "15:30";
						$start[4] = $break_end = "15:45";
						$start[5] = $end[4] = "16:35";
						$start[6] = $end[5] = "17:25";
						$lunch_start = $end[6] = "18:00";
						$lunch_end = "19:00";
					break;

					case 'N':
						$classes = 4;
						$start[1] = "19:00";
						$start[2] = $end[1] = "19:50";
						$break_start = $end[2] = "20:40";
						$start[3] = $break_end = "21:00";
						$start[4] = $end[3] = "21:50";
						$end[4] = "22:40";
					break;

					case 'M':
					break;
				}

				for ($i = 1; $i <= $classes; $i++){
					$class_time[$i] = $start[$i].' - '.$end[$i];
					echo '
						<th>'.$i.'</th>
						<th>'.$class_time[$i].'</th>';
						$sql = $Tables->LoadFrom($script.' AND '.$name_page.'.time_start = "'.$start[$i].':00"');
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