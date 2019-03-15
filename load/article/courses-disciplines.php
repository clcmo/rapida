<?php
	$name_page = 'disciplines';
	$script = $name_page.', `courses`, `teachers`, `users` WHERE disciplines.id_cur = courses.id_cur AND disciplines.id_pro = teachers.id_pro AND teachers.id_usu = users.id_usu';

	$sql = $Tables->LoadFrom($script);
	$query = $PDO->query($sql) or die ($PDO);

	while($row = $query->fetch(PDO::FETCH_OBJ)){
		
		switch ($row->periodo) {
			case 'M':
				$periodo = 'Manhã';
			break;

			case 'T':
				$periodo = 'Tarde';
			break;

			case 'N':
				$periodo = 'Noite';
			break;
		}
		
		$curso = $row->nome_cur;
		$professor = $row->nome_usu;
		$sala = $row->sala;
		$link = 'profile?id='.$row->id_usu;
		$user = 'Professor: '.$professor;

		$message = '
			<p>Curso: '.$curso.'<br/>Período: '.$periodo.'
			<br/>Sala: '.$sala.'</p>';
		$img = '<i class="fas fa-users" style="font-size: 3rem;"></i>';

		echo '
			<article class="post">
				<h4>'.$titulo.'</h4>
				<div class="media">
					<div class="media-left">'.$img.'</div>
					<div class="media-content">
						<div class="content">
							<p>'.$message.'<a href="'.$link.'">'.$user.'</a></p>
						</div>
					</div>
					<div class="media-right">
						<a href="'.$edit_link.'" class="button is-link is-small"><i class="fas fa-pencil-alt"></i></a>
						<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'.$action_button.'</a>
					</div>
				</div>
				<hr />
			</article>
			<div class="columns">
				<div class="column">
					<p>Exibindo'.$cont.' de '.$cont.' resultados.</p>
				</div>
				<div class="column">
				</div>
			</div>';
	}

	//include('main-article.php');