<?php
	switch ($name_page) {
		case 'courses':
			$name_translated = 'Cursos';
			$script = $name_page.' WHERE status_cou = 1';
			$name_table = $Tables->Found_Item('name', $name_page);
			$id_table = $Tables->Found_Item('id', $name_page);
			$icon = '<i class="fas fa-chalkboard"></i>';
		break;
		
		case 'teachers':
			$name_translated = 'Professor';
			$script = $name_page.', users WHERE '.$name_page.'.id_use = users.id_use AND status_use = 1';
			$icon = '<i class="fas fa-user"></i>';
			$name_table = $Tables->Found_Item('name', 'users');
			$id_table = $Tables->Found_Item('id', $name_page);
		break;
	}
	
	$query = $PDO->query($Tables->SelectFrom(null, $script)) or die ($PDO);
	
	echo'
		<div class="field" id="'.$name_page.'">
	        <label class="label">'.$name_translated.'</label>
	        <div class="control has-icons-left">
	            <div class="select is-hovered is-link">
	            	<select name="'.$name_page.'">';
		            	while($row = $query->fetch(PDO::FETCH_OBJ)){
		            		echo '<option value="'.$row->$id_table.'">'.$row->$name_table.'</option>';
		            	}
	            echo '</select>
	            </div>
	            <span class="icon is-small is-left">'.$icon.'</span>
	        </div>
	    </div>';