<?php
	$name_page = 'usuarios';
	$script = $name_page;
	$sql = $Tables->LoadFrom($script);
	$query = $PDO->query($sql) or die ($PDO);

	while($row = $query->fetch(PDO::FETCH_OBJ)){
		$foto = ($row->foto) ? SERVER.'uploads/'.$row->foto : $Load->Gravatar($row->email_usu);
		switch ($row->status_usu) {
			case 1:
				# desativar...
				$button = '<a href="'.SERVER.'deactivate?t=usuarios?id='.$row->id_usu.'" class="button is-danger is-small"><i class="fas fa-minus-circle"></i></a>';
			break;
			
			case 2:
				# ativar...
				$button = '<a href="'.SERVER.'activate?t=usuarios?id='.$row->id_usu.'" class="button is-success is-small"><i class="fas fa-check-square"></a>';
			break;
		}
?>
	<tr>
		<td width="5%"><figure class="image is-32x32"><img class="is-rounded" src="'.$foto.'"></td>
		<td>'.$row->nome_usu.'</td>
		<td width="5%"><a href="'.SERVER.'profile?id='.$row->id_usu.'" class="button is-link is-small"><i class="fas fa-pencil-alt"></i></a></td>
		<td width="5%">'.$button.'</td>
	</tr>';