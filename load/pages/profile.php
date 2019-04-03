<?php
	if($name_page != 'notifies'){
		$id = (!isset($_GET['id'])) ? $_SESSION['id'] : $_GET['id'];
	} else {
		$id = $_SESSION['id'];
	}
	$sql = $Tables->LoadFrom('users WHERE id_use LIKE '.$id.' AND status_use = 1 LIMIT 1');
	$query = $PDO->query($sql) or die ($PDO);
	
	while($row = $query->fetch(PDO::FETCH_OBJ)){
		$name_use = $row->name_use;
		$year = ($row->signup_date) ? date('Y', strtotime($row->signup_date)) : '';
		$signup_date = ($row->signup_date) ? date('d/m/Y', strtotime($row->signup_date)) : '';
		$email = ($row->email) ? $row->email : '';
		$login = ($row->login) ? $row->login : '';

		$photo = ($row->photo) ? SERVER.'uploads/'.$row->photo : $Load->Gravatar($main_email);

		switch ($row->type_use) {
			case 1:	$type = 'Aluno'; break;
			case 2: $type = 'Funcionário'; break;
			case 3: $type = 'Professor'; break;
			case 4: $type = 'Aluno'; break;
			case 5: $type = 'Aluno'; break;
			case 6: $type = 'Aluno'; break;
			default: break;
		}

	}

	/*
		$cep_res = ($row->cep_res) ? $row->cep_res : '';
		$end_res = ($row->end_res) ? $row->end_res : '';
		$num_res = ($row->num_res) ? $row->num_res : '';
		$bai_res = ($row->bai_res) ? $row->bai_res : '';
		$cid_res = ($row->cid_res) ? $row->cid_res : '';
		$uf = ($row->uf) ? $row->uf : '';

		$rg = ($row->rg_usu) ? $row->rg_usu : '';
		$cpf = ($row->cpf_usu) ? $row->cpf_usu : '';
		$tel = ($row->tel_usu) ? $row->tel_usu : '';

		$data_nasc = ($row->data_nasc) ? $row->data_nasc : '';
		$ano_nasc = ($row->data_nasc) ? date('Y', strtotime($row->data_nasc)) : '';

		switch ($row->tipo_usu){
			case 1:
				$tag = 'is-primary';
				$tipo = 'Aluno';
				$string = 'turma';

				$sql_tipo = $Tables->LoadFrom('usuarios, alunos, turmas, cursos WHERE usuarios.id_usu LIKE '.$id.' AND usuarios.status_usu = 1 AND cursos.id_cur = turmas.id_cur AND turmas.id_tur = alunos.id_tur AND usuarios.id_usu = alunos.id_usu LIMIT 1');
				$query_tipo = $PDO->query($sql_tipo) or die ($PDO);
				while ($row = $query_tipo->fetch(PDO::FETCH_OBJ)) {
					$area = $row->nome_cur;
				}

				//Fazer query para turmas
				$sql_tur =  $Tables->LoadFrom('turmas, cursos WHERE cursos.id_cur = turmas.id_cur');
				$query_tur = $PDO->query($sql_tur) or die ($PDO);
				$input = '
				<div class="control has-icons-left">
  					<div class="select is-hovered is-link">
    					<select>';
    					while ($row = $query_tur->fetch(PDO::FETCH_OBJ)) {
							$input = $input.'<option>'.$row->nome_cur.' ('.$row->ano.' / '.$row->semestre.')'.'</option>';
						}
						$input = $input.'</select>
  					</div>
  					<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
				</div>';

				//Fazer nova query para a identificação dos responsáveis
				if($ano_nasc - YEAR <= 18){
					$data = '
						<p class="title is-small">Informações de Contato</p>
						<p><strong>Pai / Mãe / Responsável: </strong>Nome do Responsável</p>
						<p><strong>Telefone de Contato: </strong> (11) 9652-5656</p>
						<p><strong>RG:</strong> RG</p>
						<p><strong>CPF:</strong> RG</p>';
				}
			break;

			case 2:
				$data = '';
				$tag = 'is-warning';
				$tipo = 'Funcionário';
				
				$string = 'area';
				$sql_tipo = $Tables->LoadFrom('usuarios, funcionarios WHERE usuarios.id_usu LIKE '.$id.' AND usuarios.status_usu = 1 AND funcionarios.id_usu = usuarios.id_usu LIMIT 1');
				$query_tipo = $PDO->query($sql_tipo) or die ($PDO);
				while ($row = $query_tipo->fetch(PDO::FETCH_OBJ)) {
					$area = $row->area_fun;
				}

				$input = '
				<div class="control has-icons-left has-icons-right">
  					<input class="input is-link" type="text" placeholder="'.$area.'" name="area">
  					<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
					<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
				</div>';
			break;
						
			case 3:
				$data = '';
				$tag = 'is-success';
				$tipo = 'Professor';
				$string = 'area';

				$sql_tipo = $Tables->LoadFrom('usuarios, professores WHERE usuarios.id_usu LIKE '.$id.' AND usuarios.status_usu = 1 AND professores.id_usu = usuarios.id_usu LIMIT 1');
				$query_tipo = $PDO->query($sql_tipo) or die ($PDO);
				while ($row = $query_tipo->fetch(PDO::FETCH_OBJ)) {
					$area = $row->area_pro;
				}
				$input = '
				<div class="control has-icons-left has-icons-right">
  					<input class="input is-link" type="text" placeholder="'.$area.'" name="area">
  					<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
					<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
				</div>';
			break;
		}
	}*/