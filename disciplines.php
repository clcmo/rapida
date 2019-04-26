<?php
	include('header-admin.php');
    $link = isset($_GET['id']) ? substr(LINK, 1, 7): LINK;
    include('load/pages/'.$link.'.php');
?>
<div class="columns">
    <div class="column is-4">
        <div class="tabs is-left"><?php echo $Navegation->MainNavegation(); ?></div>
    </div>
</div>
<div class="box content">
    <?php echo $Navegation->HeroMessage('Disciplinas', 'Informe os dados para '.$selected_type); ?>
    <hr/>
    <section class="info-tiles">
		<form action="" method="post">
			<div class="columns">
                <div class="column is-7">
                    <p class="title is-small">Dados da Disciplina</p>
                    <div class="columns">
                        <div class="column">
                        	<div class="field" id="name_dis">
          						<label class="label">Nome da Disciplina</label>
          						<div class="control has-icons-left has-icons-right">
          							<input class="input is-link" type="text" placeholder="<?php echo $name_dis; ?>" value="<?php echo $name_dis; ?>">
          							<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
        							<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
        						</div>
        					</div>
                        </div>
                        <div class="column">
                            <?php $Pages->LoadOptionsPage('courses'); ?>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <?php $Pages->LoadOptionsPage('teachers'); ?>
                        </div>
                        <div class="column">
                            <div class="field" id="classroom">
                                <label class="label">Sala</label>
                                <div class="control has-icons-left">
                                    <div class="select is-hovered is-link">
                                        <select name="classroom">
                                            <option value="Sala 1">Sala 1</option>
                                            <option value="Sala 2">Sala 2</option>
                                            <option value="Sala 3">Sala 3</option>
                                            <option value="Sala 4">Sala 4</option>
                                            <option value="Sala 5">Sala 5</option>
                                            <option value="Sala 6">Sala 6</option>
                                            <option value="Laboratorio 1">Laboratório 1</option>
                                            <option value="Laboratorio 2">Laboratório 2</option>
                                            <option value="Laboratorio 3">Laboratório 3</option>
                                            <option value="Laboratorio 4">Laboratório 4</option>
                                            <option value="Laboratorio 5">Laboratório 5</option>
                                            <option value="Laboratorio 6">Laboratório 6</option>
                                        </select>
                                    </div>
                                    <span class="icon is-small is-left"><i class="fas fa-chalkboard-teacher"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="field" id="class_day">
                                <label class="label">Dia da Semana</label>
                                <div class="control has-icons-left">
                                    <div class="select is-hovered is-link">
                                        <select value="class_day">
                                            <option value="1">Segunda</option>
                                            <option value="2">Terca</option>
                                            <option value="3">Quarta</option>
                                            <option value="4">Quinta</option>
                                            <option value="5">Sexta</option>
                                            <option value="6">Sábado</option>
                                        </select>
                                    </div>
                                    <span class="icon is-small is-left"><i class="fas fa-clock"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field" id="time_start">
                                <label class="label">Início</label>
                                <div class="control has-icons-left">
                                    <div class="select is-hovered is-link">
                                        <select value="time_start">
                                            <option value="1">Aula 1</option>
                                            <option value="2">Aula 2</option>
                                            <option value="3">Aula 3</option>
                                            <option value="4">Aula 4</option>
                                            <option value="5">Aula 5</option>
                                            <option value="6">Aula 6</option>
                                            <option value="7">Aula 7</option>
                                            <option value="8">Aula 8</option>
                                        </select>
                                    </div>
                                    <span class="icon is-small is-left"><i class="fas fa-clock"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field" id="time_end">
                                <label class="label">Fim</label>
                                <div class="control has-icons-left">
                                    <div class="select is-hovered is-link">
                                        <select value="time_start">
                                            <option value="1">Aula 1</option>
                                            <option value="2">Aula 2</option>
                                            <option value="3">Aula 3</option>
                                            <option value="4">Aula 4</option>
                                            <option value="5">Aula 5</option>
                                            <option value="6">Aula 6</option>
                                            <option value="7">Aula 7</option>
                                            <option value="8">Aula 8</option>
                                        </select>
                                    </div>
                                    <span class="icon is-small is-left"><i class="fas fa-clock"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-5">
                    <?php $Pages->LoadTablePage($link); ?>
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
    <p class="subtitle is-6 has-text-centered">
        <?php
            if(isset($_POST['save']) || isset($_POST['edit'])){
                $name_dis = isset($_POST['name_dis']) ? $_POST['name_dis'] : '';
                $id_cou = isset($_POST['courses']) ? $_POST['courses'] : '';
                $id_tea = isset($_POST['teachers']) ? $_POST['teachers'] : '';
                $classroom = isset($_POST['classroom']) ? $_POST['classroom'] : '';
                $class_day = isset($_POST['class_day']) ? $_POST['class_day'] : '';
                $time_start = isset($_POST['time_start']) ? $_POST['time_start'] : '';
                $time_end = isset($_POST['time_end']) ? $_POST['time_end'] : '';
                $start = array(); 
                $end = array();

                if (empty($name_dis)) {
                    echo 'Informe o nome da disciplina.</br>';
                    exit;
                }

                $id = (!isset($_GET['id'])) ? $PDO->lastInsertId() : $_GET['id'];

                $sql = "SELECT * FROM disciplines, courses WHERE disciplines.id_cou = courses.id_cou AND disciplines.id_dis = ".$id;
                $con = $PDO->query($sql) or die ($PDO);
                while ($row = $con->fetch(PDO::FETCH_OBJ)){
                    if ($row->name_dis == $name_dis && $row->id_cou == $id_cou){
                        echo 'Disciplina já está registrada.</br>';
                    }

                    switch($row->period){
                        case 'I':
                            $start[1] = '07:30:00';
                            $start[2] = $end[1] = '08:20:00';
                            $start[3] = $end[2] = '09:10:00';
                            $end[3] = '10:00:00';
                            $start[4] = '10:20:00';
                            $start[5] = $end[4] = '11:00:00';
                            $end[5] = '12:00:00';
                            $start[6] = '13:00:00';
                            $start[7] = $end[6] = "13:50";
                            $start[8] = $end[7] = "14:40";
                            $end[8] = "15:30";
                        break;

                        case 'T':
                            $start[1] = "13:00";
                            $start[2] = $end[1] = "13:50";
                            $start[3] = $end[2] = "14:40";
                            $end[3] = "15:30";
                            $start[4] = "15:45";
                            $start[5] = $end[4] = "16:35";
                            $start[6] = $end[5] = "17:25";
                            $end[6] = "18:00";
                        break;

                        case 'N':
                            $start[1] = "19:00";
                            $start[2] = $end[1] = "19:50";
                            $end[2] = "20:40";
                            $start[3] = "21:00";
                            $start[4] = $end[3] = "21:50";
                            $end[4] = "22:40";
                        break;
                    }
                }
            }

            if(isset($_POST['save'])) {
                $sql = "INSERT INTO disciplines (name_dis, id_cou, id_tea, classroom, time_start, time_end, status_dis) VALUES (:name_dis , :id_cou, :id_tea, :classroom, :time_start :time_end, 1)";
                $stmt = $PDO->prepare($sql);
                $stmt->bindParam(':name_cou', $name_cou);
                $stmt->bindParam(':id_cou', $id_cou);
                $stmt->bindParam(':id_tea', $id_tea);
                $stmt->bindParam(':classroom', $classroom);
                $stmt->bindParam(':time_start', $start[$time_start]);
                $stmt->bindParam(':time_end', $end[$time_end]);
                $result = $stmt->execute();
                if ($result){
                    $id = $PDO->lastInsertId();
                    echo 'Disciplina cadastrada com sucesso. Para editar, entre no <a href="?id='.$id.'">link</a>.</br>';
                } else {
                    echo 'Um erro aconteceu.</br>';
                    exit;
                }

            } else if(isset($_POST['edit'])){
                $sql = "UPDATE courses SET name_cou = :name_cou, type_cou = :type_cou, period = :period WHERE id_cur = ".$id;
                $stmt = $PDO->prepare($sql);
                 $stmt->bindParam(':name_cou', $name_cou);
                $stmt->bindParam(':id_cou', $id_cou);
                $stmt->bindParam(':id_tea', $id_tea);
                $stmt->bindParam(':classroom', $classroom);
                $stmt->bindParam(':time_start', $start[$time_start]);
                $stmt->bindParam(':time_end', $end[$time_end]);
                $result = $stmt->execute();
                if ($result){
                    echo 'Disciplina atualizada com sucesso. Para editar, entre no <a href="?id='.$id.'">link</a>.</br>';
                } else {
                    echo 'Um erro aconteceu.</br>';
                    exit;
                }
            }
        ?>
    </p>
</div>
<?php include('footer-admin.php'); ?>