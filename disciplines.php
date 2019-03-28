<?php
	include('header-admin.php');
    include('load\pages\disciplines.php');
?>
<div class="columns">
    <div class="column is-4">
        <div class="tabs is-left"><?php echo $Load->MainNavegation(LINK, 'Disciplinas'); ?></div>
    </div>
</div>
<div class="box content">
    <?php echo $Load->HeroMessage(LINK, 'Disciplinas', 'Informe os dados para '.$selected_type); ?>
    <hr/>
    <section class="info-tiles">
		<form action="" method="post">
			<div class="columns">
                <div class="column is-7">
                    <p class="title is-small">Dados da Disciplina</p>
                    <div class="columns">
                        <div class="column">
                        	<div class="field">
          						<label class="label">Nome da Disciplina</label>
          						<div class="control has-icons-left has-icons-right">
          							<input class="input is-link" type="text" placeholder="<?php echo $name_dis; ?>" value="<?php echo $name_dis; ?>">
          							<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
        							<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
        						</div>
        					</div>
                        </div>
                        <div class="column">
                            <?php include('load/options/courses.php'); ?>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <?php include('load/options/teachers.php'); ?>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label">Período</label>
                                <div class="control has-icons-left">
                                    <div class="select is-hovered is-link">
                                        <select>
                                            <option>Manhã</option>
                                            <option>Tarde</option>
                                            <option>Noite</option>
                                        </select>
                                    </div>
                                    <span class="icon is-small is-left"><i class="fas fa-sun"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Sala</label>
                                <div class="control has-icons-left">
                                    <div class="select is-hovered is-link">
                                        <select>
                                            <option>Sala 1</option>
                                            <option>Sala 2</option>
                                            <option>Sala 3</option>
                                            <option>Sala 4</option>
                                            <option>Sala 5</option>
                                            <option>Sala 6</option>


                                            <option>Laboratório 1</option>
                                            <option>Laboratório 2</option>
                                            <option>Laboratório 3</option>
                                            <option>Laboratório 4</option>
                                            <option>Laboratório 5</option>
                                            <option>Laboratório 6</option>
                                        </select>
                                    </div>
                                    <span class="icon is-small is-left"><i class="fas fa-chalkboard-teacher"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label">Horário de Início</label>
                                <div class="control has-icons-left">
                                    <div class="select is-hovered is-link">
                                        <select>
                                            <option>07:40</option>
                                            <option>09:30</option>
                                            <option>11:20</option>
                                        </select>
                                    </div>
                                    <span class="icon is-small is-left"><i class="fas fa-clock"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-5">
                    <?php include('load/tables/disciplines.php'); ?>
                </div>
            </div>
            <div class="columns">
            	<div class="column">
					<input class="button is-block is-success is-large is-fullwidth" type="submit" name="save" value="Salvar" />
				</div>
				<div class="column">
					<input class="button is-block is-danger is-large is-fullwidth" type="button" name="cancel" value="Cancelar" />
				</div>
            </div>
        </form>
    </section>
</div>
<?php include('footer-admin.php'); ?>