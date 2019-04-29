<?php include('main.php');

	/*$name_table = $Tables->Found_Item('name', $name_page);
	$status_table = $Tables->Found_Item('status', $name_page);
	$id_table = $Tables->Found_Item('id', $name_page);

	switch (isset($_GET['id'])) {
		case true:
			$selected_type = 'editar';
			$type_button = 'edit';
			$sql = $Tables->LoadFrom($name_page.' WHERE '.$id_table.' = '.$_GET['id']);
			$query = $PDO->query($sql) or die ($PDO);

			while($row = $query->fetch(PDO::FETCH_OBJ)){
				$birthday_date = ($row->birthday_date) ? date('d/m/Y', strtotime($row->birthday_date)) : '';
				$birthday_year = date('Y', strtotime($row->birthday_date));
				$age = date(YEAR-$birthday_year);

				$signup_date = ($row->signup_date) ? date('d/m/Y', strtotime($row->signup_date)) : '';
				$signup_year = date('Y', strtotime($row->signup_date));
				$signup_time = date('H:i:s',strtotime($row->signup_date))

				$login = ($row->login) ? $row->login : '';
				$email = ($row->email) ? $row->email : '';
				
				$cep = ($row->cep) ? $row->cep : '';
				$address = ($row->address) ? $row->address : '';
				$number = ($row->number) ? $row->number : '';
				$neighborhood = ($row->neighborhood) ? $row->neighborhood : '';
				$city = ($row->city) ? $row->city : '';
				$state = ($row->state) ? $row->state : '';

				$rg = ($row->rg) ? $row->rg : '';
				$cpf = ($row->cpf) ? $row->cpf : '';
				$phone = ($row->phone) ? $row->phone : '';
				$id_use = $row->id_use;


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
			}
		break;
		
		case false:
			$selected_type = 'cadastrar';
			$type_button = 'save';

			$data_cad = date('d/m/Y', strtotime(TODAY));
			$tipo = ucfirst('usuário');
			$foto = $Load->Gravatar($main_email);
			$id = $name_use = $email = $cep = $address = $number = $neighborhood = $city = $state = $rg = $cpf = $phone = $data = $birthday_date = '';
			$login = $area = 'a ser definido';

			$string = 'tipo de usuário';
			$input = '
				<div class="control has-icons-left">
	                <div class="select is-hovered is-link">
	                    <select>
	                    	<option>Aluno</option>
	                        <option>Funcionário</option>
	                        <option>Professor</option>
	                    </select>
	                </div>
	                <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
	            </div>';
		break;
	}*/