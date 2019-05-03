<?php
	include('main.php');

	

	while($row = $query->fetch(PDO::FETCH_OBJ)){
		$foto = ($row->foto != null) ? SERVER.'uploads/'.$row->foto : $User->get_gravatar($main_email);
		switch ($row->tipo_not) {
			case 1:
				$tag = 'is-primary';
				$tipo = 'Solicitação';
			break;

			case 2:
				$tag = 'is-warning';
				$tipo = 'Revisão';
			break;

			case 3:
				$tag = 'is-success';
				$tipo = 'Matrícula';
			break;

			case 4:
				$tag = 'is-danger';
				$tipo = 'Ocorrência';
			break;

			case 5:
				$tag = 'is-light is-inverted';
				$tipo = 'Trancamento';
			break;

			case 6:
				$tag = 'is-link';
				$tipo = 'Histórico';
			break;
				
			default:
				$tag = '';
				$tipo = 'Outros';
			break;
		}

		$titulo = $row->tit_not;
		$nome = $row->nome_usu;
		$data = date('d/m/Y',strtotime($row->data_not));
		$hora = date('H:i:s',strtotime($row->data_not));
		
		
		echo '
			<article class="post">
				<h4>'.$titulo.'</h4>
				<div class="media">
					<div class="media-left"><p class="image is-32x32"><img class="is-rounded" src="'.$foto.'"></p></div>
					<div class="media-content">
						<div class="content">
							<p><a href="'.$profile_link.'">'.$nome.'</a> enviou em '.$data.', às '.$hora.'</p>
						</div>
					</div>
					<div class="media-right">
						Tipo: <a class="button '.$tag.' is-small">'.$tipo.'</a> '.$button.'
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
	