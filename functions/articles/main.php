<?php
	$script = $link;

	switch ($link) {
		case 'classroom':
			$script .= ', courses WHERE '.$link.'.id_cou = courses.id_cou';
			$img = '<i class="fas fa-users" style="font-size: 3rem;"></i>';
			$id = $Tables->Found_Item('id', $name_page);
			$name_table = $Tables->Found_Item('name', 'courses');
			$type_table = $Tables->Found_Item('type', 'courses');
		break;
		
		case 'employees': case 'students': case 'teachers':
			$script .= ', users WHERE '.$link.'.id_use = users.id_use';
		break;

		case 'historic': break;

		case 'notifies':
			$query = $PDO->query($Tables->SelectFrom(null,'users WHERE id_use = '.$_SESSION['id'].' AND status_use = 1')) or die ($PDO);
			while($row = $query->fetch(PDO::FETCH_OBJ)){
				switch ($row->type_use){
					case 3:
					case 5:
						$script .= ', users WHERE '.$link.'.id_use = users.id_use AND users.id_use = '.$_SESSION['id'];
						$button = '';
						$profile_link = 'profile';
					break;

					default:
						$script.=', users WHERE '.$link.'.id_use = users.id_usu';
						$button = '<a class="button is-light is-inverted is-small">Gerar Documento</a>';
						$profile_link = 'profile?id='.$row->id_use;
					break;
				}
			}
		break;

	}

	$sql = $Tables->LoadFrom($load);
	$cont = $Tables->CountViewTable($load);
	$query = $PDO->query($sql) or die ($PDO);
	}

	$script .=' LIMIT '.$vi.', '.$vf;

    $query = $PDO->query($Tables->LoadFrom($script)) or die ($PDO);
    $cont = $Tables->CountViewTable($script);

    while($row = $query->fetch(PDO::FETCH_OBJ)){
    	$id = $Tables->Found_Item('id', $name_page);
		$edit_link = $name_page.'?id='.$row->$id;

		$titulo = $row->$name_table;

		$status_table = $Tables->Found_Item('status', $name_page);
		$action_link = ($status_table) ? 'deactivate?t='.$name_page.'?id='.$row->$id : 'activate?t='.$name_page.'?id='.$row->$id;
		$action_color = ($status_table) ? 'danger' : 'success';
		$action_button = ($status_table) ? '<i class="fas fa-minus-circle"></i>' : '<i class="fas fa-check-square">';

		switch ($name_page) {
			case 'classroom':
				$link = 'courses?id='.$row->$id;
				//$name_page.', courses, students, users WHERE '.$name_page.'.id_cla = '.$row->$id.' AND '.$name_page.'.id_cou = courses.id_cou AND students.id_cla = '.$name_page.'.id_cla AND students.id_use = users.id_use
				$cont_class = $Tables->CountViewTable($script);
				switch ($row->period) {
					case 'M':
						$period = 'Manhã';
					break;

					case 'T':
						$period = 'Tarde';
					break;
						
					case 'N':
						$period = 'Noite';
					break;

					case 'I':
						$period = 'Integral';
					break;
				}
				$message = 'Número de Alunos: '.$row->students.'</br>Período: '.$period.'<br/>Curso: ';
				$user = $titulo;
			break;

			case 'users':
				$link = 'profile?id='.$row->$id;
				switch ($row->birthday_date) {
					case true:
						$birthday_date = date('d/m/Y', strtotime($row->birthday_date));
						$birthday_year = date('Y', strtotime($row->birthday_date));
						$age = date(YEAR-$birthday_year);
					break;
					
					case false:
						$birthday_date = $birthday_year = $age = '';
					break;
				}
				
				switch ($row->signup_date) {
					case true:
						$signup_date = date('d/m/Y', strtotime($row->signup_date));
						$signup_year = date('Y', strtotime($row->signup_date));
						$signup_time = date(YEAR-$signup_year);
					break;
					
					case false:
						$signup_date = $signup_year = $signup_time = '';
					break;
				}

				$user = $login = ($row->login) ? $row->login : '';
				$email = ($row->email) ? $row->email : '';
				$img = isset($row->photo) ? '<img class="is-rounded" src="'.$row->photo.'">' : '<img class="is-rounded" src="'.$Load->Gravatar($email).'">';
				
				/*
				$cep = ($row->cep) ? $row->cep : '';
				$address = ($row->address) ? $row->address : '';
				$number = ($row->number) ? $row->number : '';
				$neighborhood = ($row->neighborhood) ? $row->neighborhood : '';
				$city = ($row->city) ? $row->city : '';
				$state = ($row->state) ? $row->state : '';

				$rg = ($row->rg) ? $row->rg : '';
				$cpf = ($row->cpf) ? $row->cpf : '';
				$phone = ($row->phone) ? $row->phone : '';*/

				#preparar especificações para cada tipo de usuário
				switch ($row->type_use) {
					case 1:
						$tag = 'is-primary';
						$tipo = 'Aluno';
						$string = 'turma';
						$input = '';
					break;

					case 2:
						$tag = 'is-warning';
						$tipo = 'Funcionário';
						$string = 'area';
						$input = '';
					break;
						
					case 3:
						$tag = 'is-success';
						$tipo = 'Professor';
						$string = 'area';
						$input = '';
					break;

					case 4:
					break;

					case 5:
					break;
				}

				$message = 'Idade: '.$age.'<br/>'.$tipo.' desde '.$signup_year.'<br/> Login: ';
			break;
		}

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
			</article>';
	}
	echo'
			<div class="columns">
				<div class="column">
					<p>Exibindo '.$cont.' de '.$cont.' resultados.</p>
				</div>
				<div class="column">
				</div>
			</div>';