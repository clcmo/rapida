<?php
	$links = array();
	$links[3] = '#';
	$links[4] = 'Voltar aonde estava';
	switch ($Login->IsLogged()) {
		case false:
			#exibir descrição do erro + página de acesso
			$title = 'Ops';
			$message = 'Esta página está inacessível, pois a sua seção não foi inicializada.';
			$links[1] = 'login';
			$links[2] = 'Entrar';
			include('functions/ops.php');
		break;
		case true:
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
				case 'change':
					#Verifica se a tabela e o valor foram informados. Se não houver, repetir mensagem de erro
					$res = '';
					$table = (isset($_GET['t'])) ? $_GET['t'] : '';
					$id = (isset($_GET['id'])) ? $_GET['id'] : '';
					if(!$table || !$id){
						$title = 'Ops';
						$message = 'Houve problemas durante a sua requisição.';
						$links[1] = SERVER; $links[2] = 'Início';
						include('functions/ops.php');
      				} else {
      					$id_table = $Tables->Found_Item('id', $table);
						$status_table = $Tables->Found_Item('status', $table);
						$query = $PDO->query($Tables->SelectFrom($status_table, $table.' WHERE '.$id_table.' = '.$id)) or die ($PDO);
						while($row = $query->fetch(PDO::FETCH_OBJ)){
							$sql = 'UPDATE '.$table;
							switch ($row->$status_table) {
								case 1: $sql .= 'SET '.$status_table = '2'; break; #desativa
								case 2: $sql .= 'SET '.$status_table = '1'; break; #ativa
							}
							$sql .= ' WHERE '.$id_table.' = '.$id;
						}
						$stmt = $PDO->prepare($sql);
						$result = $stmt->execute();
			    		if ($result){
			    			$res = 'Alterado com sucesso.';
			    		} else {
			    			$res = 'Um erro ocorreu.';
			    		}
			    		include('functions/sample-page.php');
      				}
				break;
				case 'classroom':
					#Verifica se a tabela e o valor foram informados. Se não houver, repetir mensagem de erro
					$id = (isset($_GET['id'])) ? $_GET['id'] : '';
					if(!$id){
						$title = 'Ops';
						$message = 'Houve problemas durante a sua requisição.';
						$links[1] = SERVER; $links[2] = 'Início';
						include('functions/ops.php');
      				} else {
      					$script .= ', courses WHERE '.$link.'.id_cou = courses.id_cou AND id_cla = '.$id;
      					$con = $PDO->query($Tables->SelectFrom(null, $script)) or die($PDO);
      					while($row = $con->fetch(PDO::FETCH_OBJ)){
      						$name_cou = $row->name_cou;
      					}
      				}
				break;
				case 'courses':
					$name_cou = 'Informe o nome do curso';
					$checked1 = $checked2 = $disabled = '';
            		$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use = '.$_SESSION['id'])) or die($PDO);
		            while($row = $con->fetch(PDO::FETCH_OBJ)){
		            	switch($row->type_use){
		            		case 4: 
		            			$script .= ', disciplines, teachers, users WHERE '.$link.'.id_cou = disciplines.id_cou AND disciplines.id_tea = teachers.id_tea AND teachers.id_use = users.id_use = '.$_SESSION['id'];
		            			$disabled = 'disabled';
		            			$selected_type = 'visualizar';
		            		break;
		            		case 5:
		            			$script .= ', classroom, students, users WHERE '.$link.'.id_cou = classroom.id_cou AND classroom.id_cla = students.id_cla AND students.id_use = users.id_use AND users.id_use = '.$_SESSION['id'];
								$disabled = 'disabled';
								$selected_type = 'visualizar';
		            		break;
		            		default: $script.= (isset($_GET['id'])) ? ' WHERE id_cou = '.$_GET['id'] : ''; break;
			            }
			            #echo $Tables->SelectFrom(null, $script);
			            $con = $PDO->query($Tables->SelectFrom(null, $script)) or die ($PDO);
			            while($row = $con->fetch(PDO::FETCH_OBJ)){
		                    #Verificar se a id do curso e o Get id são iguais
		                    if($row->id_cou){
		                        $name_cou = $row->name_cou;
		                        $period = $row->period;
		                    } else {
		                       	# demais funcionários poderão ver e alterar os dados do curso
		                        $title = 'Ops';
								$message = 'Houve problemas durante a sua requisição.';
								$links[1] = SERVER; $links[2] = 'Início';
								include('functions/ops.php');
		                    }
		            	}
		            }
        		break;
				case 'disciplines':
					$name_dis = $disabled = '';
					$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use = '.$_SESSION['id'])) or die($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)){
                		if($type_use = 4 || $type_use = 5){
		                    if($type_use = 4){
		                        $con = $PDO->query($Tables->SelectFrom(null, 'courses, disciplines, teachers, users WHERE courses.id_cou = disciplines.id_cou AND disciplines.id_tea = teachers.id_tea AND teachers.id_use = users.id_use = '.$_SESSION['id'])) or die ($PDO);
		                        $disabled = 'disabled';
                    			$selected_type = 'visualizar';
		                    } else {
		                        $con = $PDO->query($Tables->SelectFrom(null, 'courses, disciplines, teachers, users WHERE courses.id_cou = disciplines.id_cou AND disciplines.id_tea = teachers.id_tea AND teachers.id_use = users.id_use = '.$_SESSION['id'])) or die ($PDO);
		                        $disabled = 'disabled';
                    			$selected_type = 'visualizar';
		                    }
		                    while($row = $con->fetch(PDO::FETCH_OBJ)){
		                        #Verificar se a id do curso e o Get id são iguais
		                        if($row->id_dis){
		                            $name_dis = $row->name_dis;
		                        } else {
		                            $title = 'Ops';
									$message = 'Houve problemas durante a sua requisição.';
									$links[1] = SERVER; $links[2] = 'Início';
									include('functions/ops.php');
                        		}
                        	}
                        } else {
                        	$disabled = '';
                        	$selected_type = 'cadastrar';
                        }
                    } 
                    # demais funcionários poderão ver e alterar os dados do curso
        		break;
        		case 'events':
        		break;
				case 'employees': case 'students': case 'teachers': case 'directors' : case 'coordinators': 
					$con = $PDO->query($Tables->SelectFrom(null, $link.', users WHERE '.$link.'.id_use = users.id_use')) or die ($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)){
					}
				break;
				case 'historic': include('functions/sample-page.php'); break;
				case 'login': case 'signup': case 'forgot-pass':
					$message = 'Esta página está inacessível, pois a sua seção foi inicializada.';
					$links[1] = SERVER; $links[2] = 'Início';
					include('functions/ops.php');
				break;
				case 'notifies':
					$con = $PDO->query($Tables->SelectFrom('name_use, type_use','users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1')) or die ($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)){
						$name_use = $row->name_use;
						$name_not = '';
						switch ($row->type_use){
							case 1: case 2: break; #diretor e coordenador
							case 3: 
								#$script .= ' AND users.id_use = '.$_SESSION['id'];
								$button_title = 'Gerar Documento';
							break;
							case 4: $script .= ', users WHERE users.id_use = '.$link.'.id_use'; break;
							case 5: $script .= ', users WHERE users.id_use = '.$link.'.id_use AND users.id_use = '.$_SESSION['id']; break;
							default: break;
						}
						$con = $PDO->query($Tables->SelectFrom(null, $script)) or die($PDO);
						while($row = $con->fetch(PDO::FETCH_OBJ)){
							$name_not = $row->name_not;	
						}
					}
				break;
				case 'profile':
					#puxar a tabela de usuário e o id
					$id = (isset($_GET['id'])) ? $_GET['id'] : $_SESSION['id'];
					$script = 'users WHERE id_use = '.$id;
					$id_table = $Tables->Found_Item('id', 'users');
					$con = $PDO->query($Tables->SelectFrom(null, $script)) or die ($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)){
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
								$string = 'Area';
								$query = '';
								$input = '';
							break;
							case 2: 
								$type = 'Coordenador';
								$string = 'Curso';
								$table = 'coordenators';
								$query = '';
								$input = '';
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
				break;
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
				case 'schedule-grid': break;
			}
		break;
	}