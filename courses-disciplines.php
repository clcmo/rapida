<?php
	include ('header.php');
	switch ($Login->IsLogged()) {
		case false:
			?>
			<div class="column is-4 is-offset-4">
				<div class="box">
	       			<h3 class="title is-medium">Ops</h3>
	        		<p class="subtitle">Esta página está inacessível, pois a sua seção não foi inicializada.</p>
	        		<p class="links">
	        		  <a href="login">Entrar</a> &nbsp;·&nbsp;
	        		  <a href="#">Voltar aonde estava</a> &nbsp;·&nbsp;
	        		  <a href="help">Ajuda</a>
	        		</p>
	        	</div>
	      	</div>
      		<?php
		break;
		case true:
			?>
			<p class="subtitle-is-6 has-text-centered">
				<?php
					#Verifica se a tabela e o valor foram informados. Se não houver, repetir mensagem de erro
					$table = (isset($_GET['t'])) ? $_GET['t'] : '';
					$id = (isset($_GET['id'])) ? $_GET['id'] : '';
					if(!$table || !$id){
						?>
						<div class="column is-4 is-offset-4">
							<div class="box">
				       			<h3 class="title is-medium">Ops</h3>
				        		<p class="subtitle">Houve problemas durante a sua requisição.</p>
				        		<p class="links">
				        		  <a href="index">Início</a> &nbsp;·&nbsp;
				        		  <a href="#">Voltar aonde estava</a> &nbsp;·&nbsp;
				        		  <a href="help">Ajuda</a>
				        		</p>
				        	</div>
				      	</div>
      					<?php
      				}
					$id_table = $Tables->Found_Item('id', $table);
					$status_table = $Tables->Found_Item('status', $table);
					$query = $PDO->query($Tables->SelectFrom($status_table, $table.' WHERE '.$id_table.' = '.$id)) or die ($PDO);
					while($row = $query->fetch(PDO::FETCH_OBJ)){
						$sql = 'UPDATE '.$table;
						switch ($row->$status_table) {
							case 1: $sql .= 'SET '.$status_table = '2'; break; #desativa
							case 2: $sql .= 'SET '.$status_table = '1'; break; #ativa
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
		<?php
		break;
	}
	include('footer.php');
<?php
	$name_page = 'Cursos e Disciplinas';
	include('header-admin.php'); 
?>
<div class="columns">
    <div class="column is-4">
        <div class="tabs is-left"><?php echo $Navegation->MainNavegation(LINK); ?></div>
    </div>
    <div class="column">
		<div class="tabs is-right">
			<ul>
		    	<li class="is-active">
		      		<a>
		        		<span class="icon is-small"><i class="fas fa-chalkboard" aria-hidden="true"></i></span>
		        		<span>Todos</span>
		      		</a>
		    	</li>
		    	<li>
		      		<a>
		        		<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
		        		<span class="content is-link">Ativos</span>
		      		</a>
		    	</li>
		    	<li>
		      		<a>
		        		<span class="icon is-small"><i class="fas fa-chalkboard" aria-hidden="true"></i></span>
		        		<span class="content is-danger">Inativos</span>
		      		</a>
		    	</li>
		  		<li>
		      		<a>
		        		<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
		        		<span class="content is-blak">Add Disciplina</span>
		      		</a>
		    	</li>
	    	</ul>
		</div>
	</div>
</div>
<div class="box content">
	<?php
		echo $Load->HeroMessage(LINK, 'Gerenciamento de cursos e disciplinas', 'Visualização da disciplinas cadastradas').'<hr/>'; 
		include ('load/article/courses-disciplines.php'); ?>
</div>
<?php include('footer-admin.php'); ?>