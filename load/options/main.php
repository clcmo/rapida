<?php
	$sql = $Tables->LoadFrom($script);
	$query = $PDO->query($sql) or die ($PDO);
	
	echo'
		<div class="field">
	        <label class="label">'.$name_translated.'</label>
	        <div class="control has-icons-left">
	            <div class="select is-hovered is-link">
	            	<select>';
		            	while($row = $query->fetch(PDO::FETCH_OBJ)){
		            		echo '<option>'.$row->$name_table.'</option>';
		            	}
	            echo '</select>
	            </div>
	            <span class="icon is-small is-left">'.$icon.'</span>
	        </div>
	    </div>';