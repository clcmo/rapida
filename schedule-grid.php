<?php
	include('header-admin.php');
?>
<div class="columns">
    <div class="column is-4">
        <div class="tabs is-left"><?php echo $Load->MainNavegation(LINK, 'Grade'); ?></div>
    </div>
    <div class="column">
		<div class="tabs is-right">
			<ul>
				<li class="is-active">
				    <a>
				    	<span class="icon is-small"><i class="fas fa-sun" aria-hidden="true"></i></span>
			        	<span class="content is-link">Manhã</span>
			        </a>
			    </li>
				<li>
				    <a>
						<span class="icon is-small"><i class="fas fa-sun" aria-hidden="true"></i></span>
			    		<span class="content is-danger">Tarde</span>
			    	</a>
			    </li>
				<li>
					<a>
						<span class="icon is-small"><i class="fas fa-moon" aria-hidden="true"></i></span>
			    		<span class="content is-blak">Noite</span>
			    	</a>
			    </li>
				<li>
					<a href="message">
						<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
			    		<span class="content is-blak">Solicitar Reserva de Sala</span>
			    	</a>
			    </li>
			    <li>
					<a>
						<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
			    		<span class="content is-blak">Grade de Manutenção</span>
			    	</a>
			    </li>
			</ul>
		</div>
	</div>
</div>
<div class="box content">
	<?php echo $Load->HeroMessage(LINK, 'Grade de Horários', 'Visualização da grade de horários para '.YEAR); ?>
	<hr />
	<?php include('load/schedule-grid.php'); ?>
</div>
