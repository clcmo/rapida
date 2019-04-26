<?php
	$id = ($link != 'notifies') ? $id : $_SESSION['id'];
	$query = $PDO->query($Tables->SelectFrom(null, 'users WHERE id_use LIKE '.$id.' AND status_use = 1')) or die ($PDO);
	
	while($row = $query->fetch(PDO::FETCH_OBJ)){
		$name_use = $row->name_use;
		$year = ($row->signup_date) ? date('Y', strtotime($row->signup_date)) : '';
		$signup_date = ($row->signup_date) ? date('d/m/Y', strtotime($row->signup_date)) : '';
		$email = ($row->email) ? $row->email : '';
		$login = ($row->login) ? $row->login : '';
		$photo = ($row->photo) ? SERVER.'uploads/'.$row->photo : $Load->Gravatar($email);
		$cep = ($row->cep) ? $row->cep : '';
		$address = ($row->address) ? $row->address : '';
		$number = ($row->number) ? $row->number : '';
		$neighborhood = ($row->neighborhood) ? $row->neighborhood : '';
		$city = ($row->city) ? $row->city : '';
		$state = ($row->state) ? $row->state : '';
		$rg = ($row->rg) ? $row->rg : '';
		$cpf = ($row->cpf) ? $row->cpf : '';
		$phone = ($row->phone) ? $row->phone : '';
		$birthday_date = ($row->birthday_date) ? date('d/m/Y', strtotime($row->birthday_date)) : '';
		$birthday_year = ($row->birthday_date) ? date('Y', strtotime($row->birthday_date)) : '0';

		$data = $name_par = $phone_par = $rg_par = $cpf_par = $area = '';

		switch ($row->type_use) {
			case 1:	
				$type = 'Diretor';
				$table = 'director';
				/*$string = 'Area';
				$query = '';
				$input = '';*/
			break;
			case 2: 
				$type = 'Coordenador';
				$string = 'Curso';
				$table = 'coordenators';
				/*$query = '';
				$input = '';*/
			break;
			case 3:
				$type = 'Funcionário';
				$table = 'employees';
				$string = 'Area';
				$found_area = $Tables->Found_Item('area', $table);
				$query = $PDO->query($Tables->SelectFrom($found_area, $table.', users WHERE users.id_use LIKE '.$id.' AND users.status_use = 1 AND '.$table.'.id_use = users.id_use')) or die ($PDO);
				while ($row = $query->fetch(PDO::FETCH_OBJ)) { $area = ($row->$found_area) ? $row->$found_area : ''; }
				$input = '
					<div class="control has-icons-left has-icons-right">
	  					<input class="input is-link" type="text" placeholder="'.$area.'" value="'.$area.'" name="area">
	  					<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
						<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
					</div>';
			break;
			case 4: 
				$type = 'Professor';
				$table = 'teachers';
				$string = 'Area';
				$found_area = $Tables->Found_Item('area', $table);
				$query = $PDO->query($Tables->SelectFrom($found_area, $table.', users WHERE users.id_use LIKE '.$id.' AND users.status_use = 1 AND '.$table.'.id_use = users.id_use')) or die ($PDO);
				while ($row = $query->fetch(PDO::FETCH_OBJ)) { $area = ($row->$found_area) ? $row->$found_area : ''; }
				$input = '
					<div class="control has-icons-left has-icons-right">
	  					<input class="input is-link" type="text" placeholder="'.$area.'" value="'.$area.'" name="area">
	  					<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
						<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
					</div>';
			break;
			case 5: 
				$type = 'Aluno';
				$string = 'Turma';
				$table = 'students';
				#$found_area = $Tables->Found_Item('area', $table);
				$query = $PDO->query($Tables->SelectFrom('name_cou', $table.', users, classroom, courses WHERE users.id_use LIKE '.$id.' AND users.status_use = 1 AND courses.id_cou = classroom.id_cla AND classroom.id_cla = '.$table.'.id_cla AND users.id_use = '.$table.'.id_use')) or die ($PDO);
				while ($row = $query->fetch(PDO::FETCH_OBJ)) { $area = ($row->name_cou) ? $row->name_cou : ''; }
				$input = '
					<div class="control has-icons-left has-icons-right">
	  					<input class="input is-link" type="text" placeholder="'.$area.'" value="'.$area.'" name="area" disabled>
	  					<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
						<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
					</div>';

				if($birthday_year - YEAR <= 18){
					#parents query
					$query = $PDO->query($Tables->SelectFrom(null, $table.', parents, users WHERE parents.id_stu = '.$table.'.id_stu AND '.$table.'.id_use = users.id_use AND users.id_use LIKE '.$id)) or die($PDO);
					while ($row = $query->fetch(PDO::FETCH_OBJ)) {
						$name_par = isset($row->name_par) ? $row->name_par : '';
						$cpf_par = isset($row->cpf_par) ? $row->cpf_par : '';
						$rg_par = isset($row->rg_par) ? $row->rg_par : '';
						$phone_par = isset($row->phone_par) ? $row->phone_par : '';
					}
					$data = '
						<p class="title is-small">Informações de Contato</p>
		  				<div class="columns">
							<div class="column is-6">
				  			<div class="field">
				  				<label class="label">Pai / Mãe / Responsável:</label>
				  				<div class="control has-icons-left has-icons-right">
		  							<input class="input is-link" type="text" placeholder="'.$name_par.'" value="'.$name_par.'" name="name_par" disabled>
		  							<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
				  			</div>
				  			</div>
				  			<div class="column is-6">
				  			<div class="field">
				  				<label class="label">Telefone de Contato:</label>
				  				<div class="control has-icons-left has-icons-right">
		  							<input class="input is-link" type="text" placeholder="'.$phone_par.'" value="'.$phone_par.'" name="phone_par" disabled>
		  							<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
				  			</div>
				  			</div>
				  		</div>
				  		<div class="columns">
				  			<div class="column is-6">
				  			<div class="field">
				  				<label class="label">RG:</label>
				  				<div class="control has-icons-left has-icons-right">
		  							<input class="input is-link" type="text" placeholder="'.$rg_par.'" value="'.$rg_par.'" name="rg_par" disabled>
		  							<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
				  			</div>
				  			</div>
				  			<div class="column is-6">
				  			<div class="field">
				  				<label class="label">CPF:</label>
				  				<div class="control has-icons-left has-icons-right">
		  							<input class="input is-link" type="text" placeholder="'.$cpf_par.'" value="'.$cpf_par.'" name="cpf_par" disabled>
		  							<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
				  			</div>
				  			</div>
				  		</div>';
				}
			break;
			default:
				$string = 'Area';
				$found_area = $Tables->Found_Item('area', $table);
				$query = $PDO->query($Tables->SelectFrom($found_area, 'users, '.$table.' WHERE users.id_use LIKE '.$id.' AND users.status_use = 1 AND '.$table.'.id_use = users.id_use')) or die ($PDO);
				while ($row = $query->fetch(PDO::FETCH_OBJ)) { $area = ($row->$found_area) ? $row->$found_area : ''; }
				$input = '
					<div class="control has-icons-left has-icons-right">
	  					<input class="input is-link" type="text" placeholder="'.$area.'" value="'.$area.'" name="area">
	  					<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
						<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
					</div>';
			break;
		}
	}