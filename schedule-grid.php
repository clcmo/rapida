<?php
	include('header-admin.php');
	#include('load/pages/courses.php');
?>
<div class="columns">
    <div class="column is-4">
        <div class="tabs is-left"><?php echo $Load->MainNavegation(); ?></div>
    </div>
    <div class="column">
		<div class="tabs is-right">
			<ul>
				<li class="is-active">
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
	<!--Criar formato onde, a partir da seleção do curso, a página seja automaticamente redirecionada -->
	<?php include('load/options/courses.php'); ?>
	<?php echo $Load->HeroMessage(LINK, 'Grade de Horários', 'Visualização da grade de horários para '.$name_cou); ?>
	<hr />
	<?php include('load/schedule-grid.php'); ?>
</div>
<?php include('footer-admin.php'); ?>