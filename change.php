<?php
	include ('header-admin.php');
?>
<p class="subtitle-is-6 has-text-centered">
	<?php
		$table = (isset($_GET['t'])) ? $_GET['t'] : '';
		$id_table = $Tables->Found_Item('id', $table);
		$status_table = $Tables->Found_Item('status', $table);

		$id = (isset($_GET['id'])) ? $_GET['id'] : '';
		
		$script = $Tables->SelectFrom($status_table, $table.' WHERE '.$id_table.' = '.$id);
		echo $script;
		//$script = 'SELECT '.$status_table.' FROM '.$table.' WHERE '.$table.'.'.$id_table.' = '.$id;
		$query = $PDO->query($script) or die ($PDO);
		while($row = $query->fetch(PDO::FETCH_OBJ)){
			$sql = 'UPDATE '.$table;
			switch ($row->$status_table) {
				#desativa
				case 1:
					$sql .= 'SET '.$status_table = '2';
				break;
				
				#ativa
				case 2:
					$sql .= 'SET '.$status_table = '1';
				break;
			}
			$sql .= ' WHERE '.$id_table.' = '.$id;
		}

		$stmt = $PDO->prepare($sql);
		$result = $stmt->execute();
	    if ($result){
	    	echo 'Alterado com sucesso.';
	    } else {
	    	echo 'Um erro ocorreu.';
	    }
	?>
</p>