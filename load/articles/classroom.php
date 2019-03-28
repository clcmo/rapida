<?php
	$name_page = 'classroom';
	$script = $name_page.', courses WHERE '.$name_page.'.id_cou = courses.id_cou';
	$img = '<i class="fas fa-users" style="font-size: 3rem;"></i>';

	$id = $Tables->Found_Item('id', $name_page);
	$name_table = $Tables->Found_Item('name', 'courses');
	$type_table = $Tables->Found_Item('type', 'courses');

	include('main.php');



	/*while($row = $query->fetch(PDO::FETCH_OBJ)){
		$message = 'Oi';
		$link = $user = $action_link = $action_color = $action_button = '';
	}*/
	//$script = $name_page.', courses, students, users WHERE '.$name_page.'id_cla = '.$_GET['id'].' AND '.$name_page.'.id_cou = courses.id_cou AND students.id_cla = '.$name_page.'.id_cla AND students.id_use = users.id_use';
	//$second_script = 'courses';
	

	/*
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
		</div>';*/
	
