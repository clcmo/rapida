<?php

	$vf = 10;
	$pg = isset($_GET['pg']) ? $_GET['pg'] : '';
	$pc = (!$pg) ? 1 : $pg;
	$vi = $pc - 1;
	$vi = $vi * $vf;


	$sql = $Tables->LoadFrom($script.' LIMIT '.$vi.', '.$vf);
    $query = $PDO->query($sql) or die ($PDO);
    $cont = $Tables->CountViewTable($script.' LIMIT '.$vi.', '.$vf);

    while($row = $query->fetch(PDO::FETCH_OBJ)){
		$id = $Tables->Found_Item('id', $name_page);;
		$edit_link = $name_page.'?id='.$row->$id;

		$titulo = $row->$name_table;

		//$foto = isset($row->foto) ? SERVER.'uploads/'.$row->foto : $Load->Gravatar($main_email);
		$img = isset($row->foto) ? $foto : $img;

		$status_table = $Tables->Found_Item('status', $name_page);
	
		echo '
			<article class="post">
				<h4>'.$titulo.'</h4>
				<div class="media">
					<div class="media-left">'.$img.'</div>
					<div class="media-content">
						<div class="content">
							<p>'.$message.'<a href="'.$link.'">'.$user.'</a></p>
						</div>
					</div>
					<div class="media-right">
						<a href="'.$edit_link.'" class="button is-link is-small"><i class="fas fa-pencil-alt"></i></a>
						<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'.$action_button.'</a>
					</div>
				</div>
				<hr />
			</article>';
	}
	echo'
			<div class="columns">
				<div class="column">
					<p>Exibindo '.$cont.' de '.$cont.' resultados.</p>
				</div>
				<div class="column">
				</div>
			</div>';