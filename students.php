<?php
	include('header.php');
	include('functions/pages.php');
?>
<div class="columns">
    <div class="column">
        <div class="tabs is-left"><?php echo $Navegation->MainNavegation($link); ?></div>
    </div>
    <div class="column">
    	<div class="tabs is-centered">
		  	<ul>
		    	<li class="is-active">
		      		<a href="#">
		        		<span class="icon is-small"><i class="fas fa-user" aria-hidden="true"></i></span>
		        		<span>Todos</span>
		      		</a>
		    	</li>
		    	<li>
		      		<a href="#">
		        		<span class="icon is-small"><i class="fas fa-user" aria-hidden="true"></i></span>
		        		<span class="content is-link">Ativos</span>
		      		</a>
		    	</li>
		    	<li>
		      		<a href="#">
		        		<span class="icon is-small"><i class="fas fa-user" aria-hidden="true"></i></span>
		        		<span class="content is-danger">Inativos</span>
		      		</a>
		    	</li>
		  		<li>
		      		<a href="new-user">
		        		<span class="icon is-small"><i class="fas fa-user" aria-hidden="true"></i></span>
		        		<span class="content is-blak">Add Aluno</span>
		      		</a>
		    	</li>
			</ul>
		</div>
    </div>
</div>
<div class="box content">
	<?php echo $Navegation->HeroMessage(ucfirst('alunos'), 'Visualização dos Alunos Cadastrados'); ?>
	<hr/>
	<?php echo $Pages->LoadArticlePage($link); ?>
</div>
<?php include('footer.php'); ?>