<?php
	$script = $name_page = 'users';
	$name_table = $Tables->Found_Item('name', $name_page);

	/*include('main.php');
	
	$cont = $Tables->CountViewTable($name_page);
	$sql = $Tables->LoadFrom($name_page.' LIMIT '.$vi.','.$vf);
	$query = $PDO->query($sql) or die ($PDO);
	
	while($row = $query->fetch(PDO::FETCH_OBJ)){
		$ano_cad = ($row->data_cad) ? date('Y', strtotime($row->data_cad)) : '';
		$data_cad = ($row->data_cad) ? date('d/m/Y', strtotime($row->data_cad)) : '';
		$hora_cad = ($row->data_cad) ? date('H:i:s',strtotime($row->data_cad)): '';

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
		}


		/*echo '
			<article class="post">
				<h4>'.$nome.'</h4>
				<div class="media">
					<div class="media-left"><p class="image is-32x32"><img class="is-rounded" src="'.$foto.'"></p></div>
					<div class="media-content">
						<div class="content">
							<p><a href="'.SERVER.'profile?id='.$id_usu.'">'.$login.'</a> cadastrou-se em '.$data_cad.', às '.$hora_cad.'</p>
						</div>
					</div>
					<div class="media-right">
						Tipo: <a class="button '.$tag.' is-small">'.$tipo.'</a>
						<a href="'.SERVER.'profile?id='.$id_usu.'" class="button is-light is-inverted is-small">Editar Dados</a>
						<a href="'.SERVER.'desactivate?id='.$id_usu.'" class="button is-danger is-small">Desativar Conta</a>
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
		</div>';*/