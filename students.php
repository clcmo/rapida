<?php
	include('header-admin.php');
	//include('load/pages/users.php');
?>
<div class="columns">
    <div class="column is-4">
        <div class="tabs is-left"><?php echo $Load->MainNavegation(); ?></div>
    </div>
    <div class="column">
    	<div class="tabs is-centered">
		  	<ul>
		    	<li class="is-active">
		      		<a>
		        		<span class="icon is-small"><i class="fas fa-search" aria-hidden="true"></i></span>
		        		<span><input class="input" type="search" placeholder="Procurar..."></span>
		      		</a>
		    	</li>
		    	<li>
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
		        		<span class="content is-blak">Add Professor</span>
		      		</a>
		    	</li>
			</ul>
		</div>
    </div>
</div>
<div class="box content">
	<?php
		echo $Load->HeroMessage(LINK, ucfirst('estudantes'), 'Visualização dos Estudantes Cadastrados'); ?>
	<hr/>
	<?php include('load/articles/students.php'); ?>
</div>
<?php include('footer-admin.php'); ?>