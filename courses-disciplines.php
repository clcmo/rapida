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
			#Verifica se a tabela e o valor foram informados. Se não houver, repetir mensagem de erro
			$id = (isset($_GET['id'])) ? $_GET['id'] : '';
			if(!$id){
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
      		} else {
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
						echo $Navegation->HeroMessage('Gerenciamento de cursos e disciplinas', 'Visualização da disciplinas cadastradas').'<hr/>'; 
						include ('load/article/courses-disciplines.php'); ?>
				</div>
      			<?php
      		}
		break;
	}
	include('footer.php');