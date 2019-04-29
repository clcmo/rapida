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
      			#include('load/pages/courses.php');
      			?>
				<div class="columns">
					<div class="column is-4">
						<div class="tabs is-left"><?php echo $Navegation->MainNavegation($link); ?></div>
					</div>
					<div class="column">
						<div class="tabs is-right">
						  	<ul>
						    	<li class="is-active">
						      		<a href="classroom">
						        		<span class="icon is-small"><i class="fas fa-chalkboard" aria-hidden="true"></i></span>
						        		<span>Todos</span>
						      		</a>
						    	</li>
						    	<li>
						      		<a href="?type=1">
						        		<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
						        		<span class="content is-link">Ativos</span>
						      		</a>
						    	</li>
						    	<li>
						      		<a href="?type=2">
						        		<span class="icon is-small"><i class="fas fa-chalkboard" aria-hidden="true"></i></span>
						        		<span class="content is-danger">Inativos</span>
						      		</a>
						    	</li>
						    	<li>
						      		<a>
						        		<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
						        		<span class="content is-blak">Add Turma</span>
						      		</a>
						    	</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="box content">
				<!--Criar formato onde, a partir da seleção da turma, a página seja automaticamente redirecionada -->
				<?php 
				#include('load/options/courses.php');
				#echo $link;
				echo $Navegation->HeroMessage('Turmas', 'Visualização da Turma de '.$name_cou).'<hr/>';
				echo $Pages->LoadSuperTablePage($link);
				?>
			</div>
			<?php
      	}
		break;
	}
	include('footer.php');