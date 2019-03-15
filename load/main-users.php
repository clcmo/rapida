<?php
	include('main.php');
	/*if(LINK != 'profile') {
		$id = '';
		$table_name = $name_page.' LIMIT '.$vi.','.$vf;
		$cont = $Tables->CountViewTable('usuarios');
	} else {
		$id = (!isset($_GET['id'])) ? $_SESSION['id'] : $_GET['id'];
		$table_name = $name_page.' WHERE id_usu LIKE '.$id.' AND status_usu = 1 LIMIT 1';
		$cont = '';
	}*/

	if(isset($_GET['id'])){
		$sql = $Tables->LoadFrom($name_page. 'WHERE id_usu = '.$_GET['id']);
		$query = $PDO->query($sql) or die ($PDO);

		while($row = $query->fetch(PDO::FETCH_OBJ)){
			$ano_cad = ($row->data_cad) ? date('Y', strtotime($row->data_cad)) : '';
			$data_cad = ($row->data_cad) ? date('d/m/Y', strtotime($row->data_cad)) : '';
			$hora_cad = ($row->data_cad) ? date('H:i:s', strtotime($row->data_cad)): '';

			$login = ($row->login) ? $row->login : '';
			$email = ($row->email_usu) ? $row->email_usu : '';

			$foto = ($row->foto) ? SERVER.'uploads/'.$row->foto : $Load->Gravatar($main_email);
			
			$cep_res = ($row->cep_res) ? $row->cep_res : '';
			$end_res = ($row->end_res) ? $row->end_res : '';
			$num_res = ($row->num_res) ? $row->num_res : '';
			$bai_res = ($row->bai_res) ? $row->bai_res : '';
			$cid_res = ($row->cid_res) ? $row->cid_res : '';
			$uf = ($row->uf) ? $row->uf : '';

			$rg = ($row->rg_usu) ? $row->rg_usu : '';
			$cpf = ($row->cpf_usu) ? $row->cpf_usu : '';
			$tel = ($row->tel_usu) ? $row->tel_usu : '';

			$nome = ($row->nome_usu) ? $row->nome_usu : '';
			$data_nasc = ($row->data_nasc) ? $row->data_nasc : '';
			$ano_nasc = ($row->data_nasc) ? date('Y', strtotime($row->data_nasc)) : '';
			$id_usu = $row->id_usu;


			switch ($row->tipo_usu) {
				case 1:
					$tag = 'is-primary';
					$tipo = 'Aluno';
				break;

				case 2:
					$tag = 'is-warning';
					$tipo = 'Funcionário';
				break;
					
				case 3:
					$tag = 'is-success';
					$tipo = 'Professor';
				break;

				case 4:
				break;

				case 5:
				break;
			}
		}
	} else {
		$data_cad = date('d/m/Y', strtotime(TODAY));
		$tipo = ucfirst('usuário');
		$foto = $Load->Gravatar($main_email);
		$id = $nome = $email = $cep_res = $end_res = $num_res = $bai_res = $cid_res = $uf = $rg = $cpf = $tel = $data = $data_nasc = '';
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

	}
	
	