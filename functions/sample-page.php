	<div class="columns">
		<div class="column">
			<div class="tabs is-left"><?php echo $Navegation->MainNavegation($link); ?></div>
		</div>
		
		<?php
			switch($link){
				case SERVER: case 'change': case 'documents': case 'ops': break;
				case 'reserve': case 'schedule-grid':
				?>
				<div class="column">
					<div class="tabs is-right">
					  	<ul>
					    	<li class="is-active">
					      		<a href="">
					        		<span class="icon is-small"><i class="fas fa-chalkboard" aria-hidden="true"></i></span>
					        		<span>Todos</span>
					        	</a>
					        </li>
					        <li>
					        	<a href="reserve">
					        		<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
					        		<span class="content is-link">Reserva de Sala</span>
					    		</a>
					    	</li>
					    	<li>
					    		<a href="reserve">
					    			<span class="icon is-small"><i class="fas fa-chalkboard" aria-hidden="true"></i></span>
					    			<span class="content is-danger">Manutenção</span>
					    		</a>
					    	</li>
						</ul>
					</div>
				</div>
				<?php
				break;
				default:
		?>
		<div class="column">
			<div class="tabs is-right">
			  	<ul>
			    	<li class="is-active">
			      		<a href="">
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
			    	<!--<li>
			    		<a>
			    			<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
			    			<span class="content is-blak">Add Turma</span>
			    		</a>
			    	</li>-->
				</ul>
			</div>
		</div>
		<?php
			break;
		}
		?>
	</div>
	<div class="box content">
		<?php
			switch($link){
				case 'change': case 'ops': break;
				case 'classroom': case 'historic': case 'schedule-grid': case 'reserve': 
					echo $Navegation->HeroMessage().'<hr/>';
					echo $Pages->LoadSuperTablePage();
				break;
				default:
				break;
			}
		?>
	</div>
	<p class="subtitle-is-6 has-text-centered">
		<?php
			switch($link){
				case 'change': echo $res; break;
			}
		?>
	</p>