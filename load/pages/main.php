<?php
	#com o nome da página estaremos puxando:
	$script = $link; #script sql

	$type_table = $Tables->Found_Item('type', $link);
	#o tipo na tabela informada
	$status_table = $Tables->Found_Item('status', $link);
	#o status na tabela informada
	$name_table = $Tables->Found_Item('name', $link);
	#o titulo/nome na tabela informada 
	$id_table = $Tables->Found_Item('id', $link);
	#o id na tabela informada
	
	switch ($link) {
		case 'profile': 
			$id = isset(($_GET['id'])) ? $_GET['id'] : $_SESSION['id'];
			$script = 'users WHERE ';
			$id_table = $Tables->Found_Item('id', 'users');
		break;

		case 'historic':
		break;
		
		case 'courses':
			$name_cou = 'Informe o nome do curso';
			$checked1 = $checked2 = $disabled = '';
            $con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use = '.$_SESSION['id'])) or die($PDO);
            while($row = $con->fetch(PDO::FETCH_OBJ)){
            	switch($row->type_use){
            		case 4: 
            			$script_con = $link.', disciplines, teachers, users WHERE '.$link.'.id_cou = disciplines.id_cou AND disciplines.id_tea = teachers.id_tea AND teachers.id_use = users.id_use = '.$_SESSION['id'];
            		break;
            		case 5:
            			$script_con = $link.', classroom, students, users WHERE '.$link.'.id_cou = classroom.id_cou AND classroom.id_cla = students.id_cla AND students.id_use = users.id_use AND users.id_use = '.$_SESSION['id'];
            		break;
	            }
	            #echo $Tables->SelectFrom(null, $script_con);
	            $con = $PDO->query($Tables->SelectFrom(null, $script_con)) or die ($PDO);
	            while($row = $con->fetch(PDO::FETCH_OBJ)){
                    #Verificar se a id do curso e o Get id são iguais
                    if($row->id_cou){
                        $name_cou = $row->name_cou;
                        $period = $row->period;
                        $disabled = 'disabled';
                        $selected_type = 'visualizar';
                    } else {
                       	# demais funcionários poderão ver e alterar os dados do curso
                        ?>
                        <div class="column is-4 is-offset-4">
                            <div class="box">
                                <h3 class="title is-medium">Ops</h3>
                                <p class="subtitle">Houve problemas durante a sua requisição.</p>
                                <p class="links">
                                    <a href="index">Início</a> &nbsp;·&nbsp;
                                    <a href="#">Voltar aonde estava</a> &nbsp;·&nbsp;
                                    <a href="help">Ajuda</a>
                                </p>
                            </div>
                        </div>
                        <?php
                    }
            	}
            }
        break;

        case 'disciplines': 
        $script .= ', courses WHERE '.$link.'.id_cou = courses.id_cou AND '; 
        break;

        case 'historic':
        break;

		#case 'users': $script .= ' WHERE '; break;
		
		case 'new-user':
			$name_use = '';
			$year = date('Y', strtotime(TODAY));
			$signup_date = date('d/m/Y', strtotime(TODAY));
			$email = isset($_GET['email']) ? $_GET['email'] : '';
			$login = '';
			$photo = $Load->Gravatar(MAIN_EMAIL);
			$cep = $address = $number = $neighborhood = $city = $state = $rg = $cpf = $phone = '';
			$birthday_date = date('d/m/Y', strtotime(TODAY));
			$birthday_year = date('Y', strtotime(TODAY));
			$data = $name_par = $phone_par = $rg_par = $cpf_par = $area = '';
			$type = 'usuário';
			$string = 'Tipo de Usuário';
			#criar radio button
		break;
		
		
		
		case 'notifies':
			$con = $PDO->query($Tables->SelectFrom('name_use, type_use','users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1')) or die ($PDO);
			while($row = $con->fetch(PDO::FETCH_OBJ)){
				$name_use = $row->name_use;
				switch ($row->type_use){
					case 2: break;
					case 3: $script .=' AND users.id_use = '.$_SESSION['id']; $button_title = 'Gerar Documento'; break;
					case 4: $script .= ', users WHERE users.id_use = '.$name_page.'.id_use AND '; break;
					case 5: $script .= ', users WHERE users.id_use = '.$name_page.'.id_use AND users.id_use = '.$_SESSION['id'].' AND '; break;
					default: break;
				}
			}
		break;

		case 'schedule-grid':
		break;
	}

	switch ($id) {
		case false:
			# code...
		break;
		
		default:
			$script.= $id_table.' = '.$id;
			$PDO = $Load->DataBase();
			$con = $PDO->query($Tables->SelectFrom(null, $script)) or die ($PDO);
			$cont = $Tables->CountViewTable(null, $script);
			while($row = $con->fetch(PDO::FETCH_OBJ)){
				switch($link){
					case 'profile':
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
					break;
				}
			}
		break;
	}




/*

	switch($id){
		case false:
			switch ($link) {
				case 'courses':
					$name_cou = 'Informe o nome';
				break;

				case 'disciplines':
					$name_dis = 'Informe o nome';
				break;

				case 'notifies':
					$name_not = 'Informe o nome';
				break;

				case 'users':
					$name_use = 'Informe o nome';
					$type = 'usuário';
				break;
			}
			$checked2 = '';
			$checked1 = '';
		break;

		case true:
			
			
			#echo $Tables->SelectFrom(null, $script);
			
			
				switch ($link) {
					case 'courses':
						$name_cou = $row->$name_table;
					break;
				
					case 'disciplines':
						$name_cou = $row->$name_table;
					break;

					case 'notifies':
						$name_not = $row->$name_table;
					break;

					case 'users':
						$name_use = $row->$name_table;
						$tipo = 'usuário';
						$email = $row->email;
						$birthday_date = ($row->birthday_date) ? date('d/m/Y', strtotime($row->birthday_date)) : '';
						$rg = ($row->rg) ? $row->rg : '';
						$cpf = ($row->cpf) ? $row->cpf : '';
						$phone = ($row->phone) ? $row->phone : '';

						$cep = ($row->cep) ? $row->cep : '';
						$address = ($row->address) ? $row->address : '';
						$number = ($row->number) ? $row->number : '';
						$neighborhood = ($row->neighborhood) ? $row->neighborhood : '';
						$city = ($row->city) ? $row->city : '';
						$state = ($row->state) ? $row->state : '';
						$photo = $Load->Gravatar();

						$input = '';
					break;
				}
				switch ($row->$type_table) {
					case 1:
						$button_title_2 = 'Ensino Médio';
						$checked1 = 'checked';
						$checked2 = '';
					break;
					case 2: 
						$button_title_2 = 'Ensino Modular';
						$checked2 = 'checked';
						$checked1 = '';
					break;
				}
			}
		break;
	}
	
	#$placeholder = $email = isset($_GET['email']) ? $_GET['email'] : '';
*/