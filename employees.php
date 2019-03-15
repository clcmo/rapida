<?php
	$name_page = 'funcionarios';
	include('header-admin.php');
	echo $Initial->Navegation(LINK, 'Funcionários');
?>
<nav class="navbar is-white">
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
</nav>
<div class="box content">
	<?php echo $User->ShowHero(LINK, $name_page, 'Gerenciamento de funcionários', 'Visualização dos Funcionários cadastrados').'<hr/>';
	include('load/load-employees.php'); ?>
</div>
<?php include('footer.php'); ?>