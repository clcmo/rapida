<?php
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
		</table>';

			

	/*include('main.php');

	$sql = $Tables->LoadFrom('turmas, cursos WHERE turmas.id_cur = cursos.id_cur LIMIT '.$vi.','.$vf);
	$query = $PDO->query($sql) or die ($PDO);
	$cont = $Tables->CountViewTable('turmas, cursos WHERE turmas.id_cur = cursos.id_cur LIMIT '.$vi.','.$vf);

	while($row = $query->fetch(PDO::FETCH_OBJ)){
		$titulo = $row->nome_cur;
		$data = date('d/m/Y',strtotime($row->data_inicio));
		$alunos = $row->alunos;
		$button1 = ($row->alunos < 40) ? '<a class="button is-light is-inverted is-small">Add Aluno</a>': '';
		$button2 = '<a href="classroom-students?id='.$row->id_tur.'" class="button is-light is-inverted is-small">Ver Alunos</a>';
		$button3 = '<a href="edit-classroom?id='.$row->id_tur.'" class="button is-light is-inverted is-small">Editar Turma</a>';
		$semestres = $row->semestres;
		$tag = ($row->status = 1) ? 'is-link' : 'is-danger';
		$tipo = ($row->status = 1) ? 'Ativo' : 'Inativo';
		echo '
			<article class="post">
				<h4>'.$titulo.'</h4>
				<div class="media">
					<div class="media-left"><i class="fas fa-users" style="font-size: 3rem;"></i></div>
					<div class="media-content">
						<div class="content">
							<p>Início das aulas: '.$data.' <br/>Semestres Restantes: '.$semestres.'<br/>Alunos Matriculados: '.$alunos.'</p>
						</div>
					</div>
					<div class="media-right">
						<p>Status: <a class="button '.$tag.' is-small">'.$tipo.'</a> '.$button1.' '.$button2.' '.$button3.'</p>
					</div>
				</div>
				<hr />
			</article>';
	}

	echo '
		<div class="columns">
			<div class="column">
				<p>Exibindo '.$cont.' de '.$cont.' resultados.</p>
			</div>
			<div class="column">
			</div>
		</div>';

		while($row = $query->fetch(PDO::FETCH_OBJ)){
		$message = 'Oi';
		$link = $user = $action_link = $action_color = $action_button = '';
	}

	//$script = $name_page.', courses, students, users WHERE '.$name_page.'id_cla = '.$_GET['id'].' AND '.$name_page.'.id_cou = courses.id_cou AND students.id_cla = '.$name_page.'.id_cla AND students.id_use = users.id_use';
	//$second_script = 'courses';
	
	include('main.php');

	$sql = $Tables->LoadFrom('turmas, cursos, alunos, usuarios WHERE turmas.id_tur = '.$_GET['id'].' AND turmas.id_cur = cursos.id_cur AND alunos.id_tur = turmas.id_tur AND alunos.id_usu = usuarios.id_usu LIMIT '.$vi.','.$vf);
	$query = $PDO->query($sql) or die ($PDO);


	//$cont = $Tables->CountViewTable('turmas, cursos, alunos, usuarios WHERE turmas.id_tur = '.$_GET['id'].' AND turmas.id_cur = cursos.id_cur AND alunos.id_tur = turmas.id_tur AND alunos.id_usu = usuarios.id_usu LIMIT '.$vi.','.$vf);
	while($row = $query->fetch(PDO::FETCH_OBJ)){
		$foto = ($row->foto != null) ? SERVER.'uploads/'.$row->foto : $User->get_gravatar($main_email);
		echo '
			<article class="post">
				<h4>'.$row->nome_usu.'</h4>
				<div class="media">
					<div class="media-left"><p class="image is-32x32"><img class="is-rounded" src="'.$foto.'"></p></div>
					<div class="media-content">
						<div class="content">
							<p><a href="'.SERVER.'profile?id='.$row->id_usu.'">'.$row->login.'</a> cadastrou-se em '.date('d/m/Y',strtotime($row->data_cad)).', às '.date('H:i:s',strtotime($row->data_cad)).'</p>
						</div>
					</div>
					<div class="media-right">
						<a href="'.SERVER.'profile?id='.$row->id_usu.'" class="button is-light is-inverted is-small">Editar Dados</a>
						<a href="'.SERVER.'desactivate?id='.$row->id_usu.'" class="button is-danger is-small">Desativar Conta</a>
					</div>
				</div>
				<hr />
			</article>';
		$cont = $row->id_alu;
	}
	echo '
		<div class="columns">
			<div class="column">
				<p>Exibindo '.$cont.' de '.$cont.' resultados.</p>
			</div>
			<div class="column">
			</div>
		</div>';
	
	*/