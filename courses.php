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
            $name_cou = $checked1 = $checked2 = $disabled = '';
            $con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use = '.$_SESSION['id'])) or die($PDO);
            while($row = $con->fetch(PDO::FETCH_OBJ)){
                if($type_use = 4 || $type_use = 5){
                    if($type_use = 4){
                        $con = $PDO->query($Tables->SelectFrom(null, 'courses, disciplines, teachers, users WHERE courses.id_cou = disciplines.id_cou AND disciplines.id_tea = teachers.id_tea AND teachers.id_use = users.id_use = '.$_SESSION['id'])) or die ($PDO);
                    } else {
                        $con = $PDO->query($Tables->SelectFrom(null, 'courses, disciplines, teachers, users WHERE courses.id_cou = disciplines.id_cou AND disciplines.id_tea = teachers.id_tea AND teachers.id_use = users.id_use = '.$_SESSION['id'])) or die ($PDO);
                    }
                    $disabled = 'disabled';
                    $selected_type = 'visualizar';
                    while($row = $con->fetch(PDO::FETCH_OBJ)){
                        #Verificar se a id do curso e o Get id são iguais
                        if($row->id_cou){
                            $name_cou = $row->name_cou;
                            $period = $row->period;
                        } else {
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
                        }
                    }
                } else {
                    # demais funcionários poderão ver e alterar os dados do curso
                    include('load/pages/'.$link.'.php');
                }
            }
            ?>
            <div class="columns">
                <div class="column is-4">
                    <div class="tabs is-left"><?php echo $Navegation->MainNavegation($link); ?></div>
                </div>
            </div>
            <div class="box content">
                <?php echo $Navegation->HeroMessage('Cursos', 'Informe os dados para '.$selected_type); ?>
                <hr/>
                <section class="info-tiles">
                    <form action="" method="post">
                        <div class="columns">
                            <div class="column is-7">
                                <p class="title is-small">Dados do Curso</p>
                                <div class="columns">
                                    <div class="column is-6">
                                        <div class="field" id="name_cou">
                                            <label class="label">Nome do Curso</label>
                                            <div class="control has-icons-left has-icons-right">
                                                <input class="input is-link" type="text" name="name_cou" placeholder="<?php echo $name_cou; ?>" <?php echo $disabled; ?>>
                                                <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
                                                <span class="icon is-small is-right"><i class="fas fa-check"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="field" id="type_cou">
                                            <label class="label">Tipo</label>
                                            <div class="control has-icons-left">
                                                <label class="radio"><input type="radio" name="type_cou" value="1" <?php echo $checked1; ?> onclick="Change('period')" <?php echo $disabled; ?>> ETIM</label>
                                                <label class="radio"><input type="radio" name="type_cou" value="2" <?php echo $checked2; ?> onclick="Change('period')" <?php echo $disabled; ?>> Modular</label>
                                            </div>
                                        </div>
                                        <div class="field" id="period" style="display:none;">
                                            <label class="label">Período</label>
                                            <div class="control has-icons-left">
                                                <div class="select is-hovered is-link">
                                                    <select name="period" <?php echo $disabled; ?>>
                                                        <option value="M">Manhã</option>
                                                        <option value="T">Tarde</option>
                                                        <option value="N">Noite</option>
                                                    </select>
                                                </div>
                                                <span class="icon is-small is-left"><i class="fas fa-sun"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-5"><?php echo $Pages->LoadTablePage($link); ?></div>
                        </div>
                        <div class="columns">
                            <div class="column">
                                <input class="button is-block is-success is-large is-fullwidth" type="submit" name="<?php echo $type_button; ?>" value="Salvar" <?php echo $disabled; ?>/>
                            </div>
                            <div class="column">
                                <input class="button is-block is-danger is-large is-fullwidth" type="button" name="cancel" value="Cancelar" <?php echo $disabled; ?>/>
                            </div>
                        </div>
                    </form>
                </section>
                <p class="subtitle is-6 has-text-centered">
                    <?php
                        if(isset($_POST['save']) || isset($_POST['edit'])){
                            $name_cou = isset($_POST['name_cou']) ? $_POST['name_cou'] : '';
                            $type_cou = isset($_POST['type_cou']) ? $_POST['type_cou'] : '';
                            $period = isset($_POST['period']) ? $_POST['period'] : '';
                            if (empty($name_cou)) {
                                echo 'Informe o nome do curso.</br>';
                                exit;
                            }
                            $sql = "SELECT name_cou, period FROM courses";
                            $con = $PDO->query($sql) or die ($PDO);
                            while ($row = $con->fetch(PDO::FETCH_OBJ)){
                                if ($row->name_cou == $name_cou && $row->period == $period){
                                    echo 'Curso já está registrado.</br>';
                                }
                            }
                            if($type_cou == 1){
                                $name_cou = 'Ensino Médio e '.$name_cou;
                                $period = 'I';
                            }
                        }
                        if(isset($_POST['save'])) {
                            $sql = "INSERT INTO courses (name_cou, type_cou, status_cou, period) VALUES (:name_cou , :type_cou, 1, :period)";
                            $stmt = $PDO->prepare($sql);
                            $stmt->bindParam(':name_cou', $name_cou);
                            $stmt->bindParam(':type_cou', $type_cou);
                            $stmt->bindParam(':period', $period);
                            $result = $stmt->execute();
                            if ($result){
                                $id = $PDO->lastInsertId();
                                echo 'Curso cadastrado com sucesso. Para editar, entre no <a href="?id='.$id.'">link</a>.</br>';
                            } else {
                                echo 'Um erro aconteceu.</br>';
                                exit;
                            }
                        } else if(isset($_POST['edit'])){
                            $sql = "UPDATE courses SET name_cou = :name_cou, type_cou = :type_cou, period = :period WHERE id_cur = ".$id;
                            $stmt = $PDO->prepare($sql);
                            $stmt->bindParam(':name_cou', $name_cou);
                            $stmt->bindParam(':type_cou', $type_cou);
                            $stmt->bindParam(':period', $period);
                            $result = $stmt->execute();
                            if ($result){
                                echo 'Curso atualizado com sucesso. Para editar, entre no <a href="?id='.$id.'">link</a>.</br>';
                            } else {
                                echo 'Um erro aconteceu.</br>';
                                exit;
                            }
                        }
                    ?>
                </p>
            </div>
        <?php
        break;
    }
    include('footer.php');