<?php
	#unificando pages/login and main.php
	$title = $Load->WhatLink();
	$links = array();
	$links[1] = SERVER; 
	$links[2] = 'Início';
	$links[3] = '#'; 
	$links[4] = 'Voltar aonde estava';
	switch ($Login->IsLogged()) {
    case false:
    	switch(LINK){
    		case 'login': case 'login?email='.$email: 
	    		$links[1] = SERVER.'signup';
				$links[2] = 'Cadastrar';
				$links[3] = SERVER.'forgot-pass';
				$links[4] = 'Recuperar Senha';

				$title = ($Load->WhatLink() != 'login') ? $Load->WhatLink('login') : $title;

        		$message = '
        			Informe os dados para entrar
			        <figure class="image is-128x128 avatar"><img class="is-rounded" src="'.$picture.'"></figure>
			        <form method="post" action="">
			            <div class="field">
			              <div class="control">
			                <input class="input is-large" type="email" name="email" placeholder="'.$placeholder.'" value="'.$email.'" autofocus="">
			              </div>
			            </div>
			            <div class="field">
			              <div class="control">
			                <input class="input is-large" type="password" name="password" placeholder="Sua Senha">
			              </div>
			            </div>
			            <div class="field">
			              <label class="checkbox"><input type="checkbox">&nbsp;Lembre-me</label>
			            </div>
			            <input class="button is-block is-info is-large is-fullwidth" type="submit" name="signin" value="Entrar" />
			        </form>
			        <p class="content has-text-centered">';

				if(isset($_POST['signin'])) {
					# Resgata variáveis do formulário
					$email = isset($_POST['email']) ? $_POST['email'] : '';
					$password = isset($_POST['password']) ? $Tables->HashStr($_POST['password']) : '';
					
					# Verifica se os campos estão vazios e exibe uma mensagem de erro
					if (empty($email) || empty($password)){
						$message .= 'Informe email e/ou senha.'; 
						exit;
					}
			                        
			        # Verificar se o usuário existe e se a senha é a mesma     
			        $stmt = $PDO->prepare(
			        	$Tables->SelectFrom(null, 'users 
			        		WHERE email = :email 
			        		AND password = :password 
			        		AND status_use = 1', 0, 1));
					$stmt->bindParam(':email', $email);
					$stmt->bindParam(':password', $password);
					$stmt->execute();
					$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($users) <= 0) {
						$message .= 'Email ou senha incorretos. Deseja <strong><a href="forgot-pass?email='.$email.'">recuperar</a></strong>?'; 
						exit;
					}
			            
					# Busca os resultados e os cataloga com a variável $_SESSION
					$user = $users[0];
					$_SESSION['logged_in'] = true;    
					$_SESSION['id'] = $user['id_use'];
					$_SESSION['name'] = $user['name_use'];
					$Load->Link();
			    }
			    $message .= '</p>';
    		break;
    		case 'forgot-pass': case 'forgot-pass?email='.$email: 
    			$links[1] = SERVER.'login'; 
		        $links[2] = 'Entrar';
		        $links[3] = SERVER.'signup'; 
		        $links[4] = 'Cadastrar';

		        $title = ($Load->WhatLink() != 'forgot-pass') ? $Load->WhatLink('forgot-pass') : $title;
		        $message = '
		        	Informe o e-mail para recuperar seu acesso
					<figure class="image is-128x128 avatar"><img class="is-rounded" src="'.$picture.'"></figure>
					<form method="post" action="">
			            <div class="field">
			              <div class="control">
			                <input class="input is-large" type="email" name="email" placeholder="'.$placeholder.'" value="'.$email.'" autofocus="">
			              </div>
			            </div>
			            <input class="button is-block is-info is-large is-fullwidth" type="submit" name="recover" value="Recuperar" />
					</form>
					<p class="content has-text-centered">';

		          	if(isset($_POST['recover'])) {
			            # Resgata variáveis do formulário
			            $email = isset($_POST['email']) ? $_POST['email'] : '';

			            # Verifica se os campos estão vazios e exibe uma mensagem de erro
			            if (empty($email))
							$message .= 'Informe email.';
			            

		            	# Verifica se o usuário existe e exibe ou uma mensagem de erro ou vai ao cadastro
		            	$con = $PDO->prepare(
		            		$Tables->SelectFrom(null, 'users
		            		 WHERE email = '.$email.' 
		            		 AND status_use = 1')) or die ($PDO);
		            	
		            	if(count($con) == 1)
		               		$password = $Tables->HashStr($Load->RandomPass());
		               		$stmt = $PDO->prepare("UPDATE users 
		               			SET password = :password
		               			WHERE email = ".$email) or die ($PDO);
		               		$stmt->bindParam(':password', $password);
		               		$stmt->execute();
		               		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
			                if (count($users) <= 0)
			                	$message .= 'Um erro aconteceu';

			                # Busca os resultados e os cataloga com a variável $_SESSION
			                $user = $users[0];
			                $_SESSION['logged_in'] = true;
			                  
			                $_SESSION['id'] = $user['id_use'];
			                $_SESSION['name'] = $user['name_use'];
			                $Load->Link();
		          	}
		        $message .= '</p>';
    		break;
    		case 'signup': case 'signup?email='.$email:
    			$links[1] = 'login'; 
		        $links[2] = 'Entrar';
		        $links[3] = 'forgot-pass'; 
		        $links[4] = 'Recuperar Senha';

		        $title = ($Load->WhatLink() != 'signup') ? $Load->WhatLink('signup') : $title;
		        $name_use = ($email) ? substr($email, 0, strlen(strstr($email, '@'))) : '';

		        $message = 'Informe os dados para cadastrar
		            <figure class="image is-128x128 avatar"><img class="is-rounded" src="'.$picture.'"></figure>
		            <form method="post" action="">
						<div class="field">
			                <div class="control">
			                	<input class="input is-large" type="text" name="name_use" placeholder="'.$name_use.'" value="'.$name_use.'" autofocus="">
			                </div>
		              	</div>
		              	<div class="field">
			                <div class="control">
			                	<input class="input is-large" type="email" name="email" placeholder="'.$placeholder.'" value="'.$placeholder.'" autofocus="">
			                </div>
		              	</div>
		              	<div class="field">
			                <div class="control">
			                  <input class="input is-large" type="password" name="password" placeholder="'.$password.'" autofocus="">
			                </div>
		              	</div>
		              	<div class="field">
			                <div class="control">
			                  <input class="input is-large" type="password" name="password_conf" placeholder="'.$password_conf.'" autofocus="">
			                </div>
		              	</div>
		              	<div class="field">
			                <div class="control">
			                  <input class="input is-large" type="date" name="birthday_date" placeholder="'.date('Y-m-d', strtotime(TODAY)).'" autofocus="">
			                </div>
		              	</div>
		              	<div class="field">
			                <div class="control">
			                	<input class="input is-large" type="text" name="cep" placeholder="Seu CEP" autofocus="">
			                </div>
		              	</div>
		              	<div class="field" id="type_use">
		                	<label class="label">Tipo de Usuário</label>
		                  	<div class="control has-icons-left">
			                    <div class="select is-hovered is-link">
			                      <select name="type_use">
			                        <option value="1">Diretor</option>
			                        <option value="2">Coordenador</option>
			                        <option value="3">Funcionário</option>
			                        <option value="4" disabled>Professor</option>
			                        <option value="5" disabled>Aluno</option>
			                      </select>
			                    </div>
		                    	<span class="icon is-small is-left"><i class="fas fa-chalkboard-teacher"></i></span>
		                  	</div>
		                </div>

		              	<div class="field"><label class="checkbox"><input type="checkbox">&nbsp;Aceito os <a href="terms">Termos</a></label></div>
		              	<input class="button is-block is-info is-large is-fullwidth" type="submit" name="signup" value="Cadastrar" />
		            </form>
		            <p class="content has-text-centered">';

			        if(isset($_POST['signup'])) {
			        	# Resgata variáveis do formulário
			        	$type_use = isset($_POST['type_use']) ? $_POST['type_use'] : '';
			        	$name_use = isset($_POST['name_use']) ? $_POST['name_use'] : '';
			        	$login = strstr($name_use, ' ');
			        	$password = isset($_POST['password']) ? $_POST['password'] : '';
			        	$password_conf = isset($_POST['password_conf']) ? $_POST['password_conf'] : '';
			        	$email = isset($_POST['email']) ? $_POST['email'] : '';
			        	$cep = isset($_POST['cep']) ? $_POST['cep'] : '';
			        	$birthday_date = isset($_POST['birthday_date']) ? $_POST['birthday_date'] : '';

			        	# Verifica se os campos estão vazios e exibe uma mensagem de erro
			        	if (empty($name_use) || empty($password) || empty($password_conf) || empty($email) || empty($cep) || empty($birthday_date)){
			          		$message .= 'Informe o email e a senha.<br/>';
			          		exit;
			        	}

			        	if($password != $password_conf){
			          		$message .= 'As duas senhas não conferem.<br/>';
			          		exit;
			        	}

			        	# Verifica se o usuário existe e exibe ou uma mensagem de erro ou vai ao cadastro
			        	$stmt = $PDO->prepare($Tables->SelectFrom(null, 'users WHERE email = :email AND status_use = 1', 0, 1));
			            $stmt->bindParam(':email', $email);
			            $stmt->execute();
			            $con = $stmt->fetchAll(PDO::FETCH_ASSOC);
			         	if(count($con) == 1){
			         		$message .= '
			          		E-mail já existe. 
			          		Deseja <strong><a href="forgot-pass?email='.$email.'">recuperar sua senha</a></strong> 
			          		ou <strong><a href="login?email='.$email.'">fazer login</a></strong>?<br/>';
			          		exit;
			         	}
			          		
			          	# Gerar a critografia da senha
			          	$password = $Tables->HashStr($password);
			          	$photo = $Load->Gravatar($email);
			          	$status_use = '1';
			          	#$signup_date = date('Y-m-d H:i:s', strtotime(TODAY));

			          	$stmt = $PDO->prepare("
			          		INSERT INTO users (type_use, status_use, signup_date, name_use, login, password, email, photo, cep, birthday_date) 
			          		VALUES (:type_use, :status_use, :signup_date, :name_use, :login, :password, :email, :photo, :cep, :birthday_date)");
			          	
						$stmt->bindParam(':type_use', $type_use, PDO::PARAM_STR);
			          	$stmt->bindParam(':status_use', $status_use, PDO::PARAM_STR);
			          	#$stmt->bindParam(':signup_date', $signup_date, PDO::PARAM_STR);
			          	$stmt->bindParam(':name_use', $name_use, PDO::PARAM_STR);
			          	$stmt->bindParam(':login', $login, PDO::PARAM_STR);
			          	$stmt->bindParam(':password', $password, PDO::PARAM_STR);
			          	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			          	$stmt->bindParam(':photo', $photo, PDO::PARAM_STR);
			          	$stmt->bindParam(':cep', $cep, PDO::PARAM_STR);
			          	$stmt->bindParam(':birthday_date', $birthday_date, PDO::PARAM_STR);			          	
			          	$result = $stmt->execute();

			          	if ($result){
			          		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
				            if (count($users) <= 0){
				               	$message .= 'Ops, houve um erro aqui.<br/>';
				               	exit;
				            }
				            # Busca os resultados e os cataloga com a variável $_SESSION
				            $user = $users[0];
				            $_SESSION['logged_in'] = true;
				            $_SESSION['id'] = $user['id_use'];
				            $_SESSION['name'] = $user['name_use'];
				            #redireciona para a página de início
				            $Load->Link();
			          	} else {
			          		print_r($stmt->errorInfo());
			          	}
			        }
			    $message .= '</p>';
    		break;
    		default:
    			#exibir descrição do erro + página de acesso
				$title = 'Ops';
				$message = 'Esta página está inacessível, pois a sua seção não foi inicializada.';
				$links[1] = 'login';
				$links[2] = 'Entrar';
    		break;
    	}
    	include('models/ops.php');
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
    	switch($link){
	    	case 'login': case 'forgot-pass': case 'signup':
		        $title = 'Ops';
		        $message = 'Sessão já inicializada';
		        include('models/ops.php');
		    break;
		    case 'change':
					#Verifica se a tabela e o valor foram informados. Se não houver, repetir mensagem de erro
					$res = '';
					$table = (isset($_GET['t'])) ? $_GET['t'] : '';
					$id = (isset($_GET['id'])) ? $_GET['id'] : '';
					if(!$table || !$id)
						$title = 'Ops';
						$message = 'Houve problemas durante a sua requisição.';
						include('models/ops.php');

      				$id_table = $Tables->Found_Item('id', $table);
					$status_table = $Tables->Found_Item('status', $table);
					$query = $PDO->query($Tables->SelectFrom($status_table, $table.' WHERE '.$id_table.' = '.$id)) or die ($PDO);
					while($row = $query->fetch(PDO::FETCH_OBJ)){
						$sql = 'UPDATE '.$table;
						switch ($row->$status_table) {
							case 1: 
								$sql .= 'SET '.$status_table = '2'; 
							break; #desativa
							case 2: 
								$sql .= 'SET '.$status_table = '1'; 
							break; #ativa
						}
						$sql .= ' WHERE '.$id_table.' = '.$id;
					}
					$stmt = $PDO->prepare($sql);
					$result = $stmt->execute();
			    	if ($result)
			    		$res = 'Alterado com sucesso.';
			    	else 
			    		$res = 'Um erro ocorreu.';
			    	include('models/sample-page.php');
			break;
			case 'classroom':
					switch ($Load->IsUserTheseType()) {
						case true:
							$script .= ', courses, students, users WHERE '.$link.'.id_cou = courses.id_cou 
							AND classroom.id_cla = students.id_cla 
							AND students.id_use = users.id_use AND users.id_use = '.$_SESSION['id'];
						break;
						
						case false: default:
							$id = (isset($_GET['id'])) ? $_GET['id'] : '';
							if(!$id){
								$title = 'Ops';
								$message = 'Houve problemas durante a sua requisição.';
								$links[1] = SERVER; $links[2] = 'Início';
								include('models/ops.php');
	      					} else 
	      						$script .= ', courses WHERE '.$link.'.id_cou = courses.id_cou AND id_cla = '.$id;
	      				break;
					}
					$con = $PDO->query($Tables->SelectFrom(null, $script)) or die($PDO);
	      			while($row = $con->fetch(PDO::FETCH_OBJ)){
	      				$name_cou = $row->name_cou;
	      			}
      				include('models/sample-page.php');
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
		                    	$name_cou = $row->name_cou; $period = $row->period;
		                    } else {
		                       	# demais funcionários poderão ver e alterar os dados do curso
		                        $title = 'Ops';
								$message = 'Houve problemas durante a sua requisição.';
								$links[1] = SERVER; $links[2] = 'Início';
								include('models/ops.php');
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
									include('models/ops.php');
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
			case 'historic': case 'schedule-grid': case 'reserve': include('models/sample-page.php'); break;
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
				$selected_type = 'editar';
				$type_button = 'edit';
				$disabled = '';
				$id = (isset($_GET['id'])) ? $_GET['id'] : $_SESSION['id'];
				$id_table = $Tables->Found_Item('id', 'users');
				$con = $PDO->query($Tables->SelectFrom(null, 'users WHERE id_use = '.$id)) or die ($PDO);

				while($row = $con->fetch(PDO::FETCH_OBJ)){
					$name_use = $row->name_use;
					$year = ($row->signup_date) ? date('Y', strtotime($row->signup_date)) : '';
					$signup_date = ($row->signup_date) ? date('Y-m-d', strtotime($row->signup_date)) : '';
					$email = ($row->email) ? $row->email : '';
					$login = ($row->login) ? $row->login : '';
					$photo = ($row->photo) ? $row->photo : $Load->Gravatar();
					$cep = ($row->cep) ? $row->cep : '';
					$address = ($row->address) ? $row->address : '';
					$number = ($row->number) ? $row->number : '';
					$neighborhood = ($row->neighborhood) ? $row->neighborhood : '';
					$city = ($row->city) ? $row->city : '';
					$state = ($row->state) ? $row->state : '';
					$rg = ($row->rg) ? $row->rg : '';
					$cpf = ($row->cpf) ? $row->cpf : '';
					$phone = ($row->phone) ? $row->phone : '';
					$birthday_date = ($row->birthday_date) ? date('Y-m-d', strtotime($row->birthday_date)) : '';
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
				include('models/sample-page.php');
			break;
			case 'new-user':
				$checked1 = $checked2 = $checked3 = $checked4 = $checked5 = '';
				$name_use = '';
				$year = date('Y', strtotime(TODAY));
				$signup_date = date('Y-m-d', strtotime(TODAY));
				$email = isset($_GET['email']) ? $_GET['email'] : '';
				$login = '';
				$photo = $Load->Gravatar(MAIN_EMAIL);
				$cep = $address = $number = $neighborhood = $city = $state = $rg = $cpf = $phone = '';
				$birthday_date = date('Y-m-d', strtotime(TODAY));
				$birthday_year = date('Y', strtotime(TODAY));
				$data = $name_par = $phone_par = $rg_par = $cpf_par = $area = '';
				$type = 'usuário';
				$string = 'Tipo de Usuário';
				include('models/sample-page.php');
			break;
		}
      break;
    }
  