<?php
	$name_page = 'grade';
	include('header-admin.php');
	include('load/load-schedule-grid.php');
?>
<div class="columns">
	<div class="column is-3">
		<div class="tabs is-left"><?php echo $Initial->Navegation(LINK, 'Grade'); ?></div>
	</div>
	<div class="column is-9">
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
	<?php echo $User->ShowHero(LINK, $name_page, 'Grade de Horários', 'Visualização da grade de horários para '.YEAR); ?>
	<hr />
	<table>
		<thead>
			<tr>
				<th>Aula</th>
				<th>Horário</th>
			    <th>Segunda</th>
			    <th>Terça</th>
			    <th>Quarta</th>
			    <th>Quinta</th>
			    <th>Sexta</th>
			    <th>Sábado</th>
      		</tr>
  		</thead>
		<tbody>
			<tr>
				<th>1</th>
				<th>07:30 - 08:20</th>
				<td>Nome da Disciplina</td>
				<td>Nome da Disciplina</td>
				<td>Nome da Disciplina</td>
				<td>Nome da Disciplina</td>
				<td>Nome da Disciplina</td>
				<td>Nome da Disciplina</td>
			</tr>
			<tr>
				<th>2</th>
				<th>08:20 - 09:10</th>
				<td>Nome da Disciplina</td>
				<td>Nome da Disciplina</td>
				<td>Nome da Disciplina</td>
				<td>Nome da Disciplina</td>
				<td>Nome da Disciplina</td>
				<td>Nome da Disciplina</td>
			</tr>
		</tbody>
	</table>
</div>
