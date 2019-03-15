<?php
	include('main.php');

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
	