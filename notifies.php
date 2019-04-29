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
            ?>
            <p class="subtitle-is-6 has-text-centered">
                <?php
                    #Verifica se a tabela e o valor foram informados. Se não houver, repetir mensagem de erro
                    $table = (isset($_GET['t'])) ? $_GET['t'] : '';
                    $id = (isset($_GET['id'])) ? $_GET['id'] : '';
                    if(!$table || !$id){
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
                    $id_table = $Tables->Found_Item('id', $table);
                    $status_table = $Tables->Found_Item('status', $table);
                    $query = $PDO->query($Tables->SelectFrom($status_table, $table.' WHERE '.$id_table.' = '.$id)) or die ($PDO);
                    while($row = $query->fetch(PDO::FETCH_OBJ)){
                        $sql = 'UPDATE '.$table;
                        switch ($row->$status_table) {
                            case 1: $sql .= 'SET '.$status_table = '2'; break; #desativa
                            case 2: $sql .= 'SET '.$status_table = '1'; break; #ativa
                        }
                        $sql .= ' WHERE '.$id_table.' = '.$id;
                    }
                    $stmt = $PDO->prepare($sql);
                    $result = $stmt->execute();
                    if ($result){
                        echo 'Alterado com sucesso.';
                    } else {
                        echo 'Um erro ocorreu.';
                    }
                ?>
            </p>
        <?php
        break;
    }
    include('footer.php');
<?php
	include('header.php');
	#$link = ($_GET['id']) ? $Load->DiscoverLink($link, 6) : $link;
  	include('load/pages/'.$link.'.php');
?>
<div class="columns">
    <div class="column">
        <div class="tabs is-left"><?php echo $Navegation->MainNavegation($link); ?></div>
    </div>
</div>
<div class="box content">
	<?php echo $Navegation->HeroMessage('Notificações', 'Informe os dados para '.$selected_type); ?>
	<hr/>
	<section class="info-tiles">
		<form action="" method="post">
			<div class="columns">
                <div class="column">
                    <p class="title is-small">Dados da Notificação</p>
                    <div class="columns">
                        <div class="column">
                        	<div class="field">
          						<label class="label">Título</label>
          						<div class="control has-icons-left has-icons-right">
          							<input class="input is-link" type="text" name="name_not" placeholder="Informe o título da notificação" value="<?php echo $name_not; ?>">
          							<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
        							<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
        						</div>
        					</div>
                        </div>
                        <div class="column">
                        	<div class="field">
                                <label class="label">Tipo</label>
                                <div class="control has-icons-left">
                                    <div class="select is-hovered is-link">
                                        <select name="type_not">
                                            <option value="1">Solicitação</option>
                                            <option value="2">Revisão</option>
                                            <option value="3">Matrícula</option>
                                        	<option value="4">Ocorrência</option>
                                            <option value="5">Trancamento</option>
                                            <option value="6">Histórico</option>
                                        </select>
                                    </div>
                                    <span class="icon is-small is-left"><i class="fas fa-bell"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                        	<div class="field">
          						<label class="label">Usuário Solicitante</label>
          						<div class="control has-icons-left has-icons-right">
          							<input class="input is-link" type="text" placeholder="Nome do Usuário" value="<?php echo $name_use; ?>" disabled>
          							<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
        							<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
        						</div>
        					</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                	<?php $Pages->LoadTablePage($link); ?>
                </div>
            </div>
            <div class="columns">
            	<div class="column">
					<input class="button is-block is-success is-large is-fullwidth" type="submit" name="<?php echo $type_button; ?>" value="Salvar" />
				</div>
				<div class="column">
					<input class="button is-block is-danger is-large is-fullwidth" type="button" name="cancel" value="Cancelar" />
				</div>
            </div>
		</form>
	</section>
	<p class="subtitle is-6">
		<?php
			if(isset($_POST['save'])) {
				$name_not = isset($_POST['name_not']) ? $_POST['name_not'] : '';
				$type_not = isset($_POST['type_not']) ? $_POST['type_not'] : '';

				if (empty($name_not) || empty($type_not)) {
					echo 'Informe o título e/ou tipo da notificação';
					exit;
				}

				//$id_use = $_SESSION['id'];
				//$status_not = 1;
				$date_not = date('Y-m-d H:i:s');
		        $stmt = $PDO->prepare('INSERT INTO notifies (name_not, type_not, id_use, date_not, status_not) VALUES (:name_not, :type_not, '.$_SESSION['id'].', :date_not, 1)');
		        $stmt->bindParam(':name_not', $name_not);
		        $stmt->bindParam(':type_not', $type_not);
		        $stmt->bindParam(':date_not', $date_not);

		        $result = $stmt->execute();
		        if($result){
		        	$id = $PDO->lastinsertid();
		        	echo 'Notificação adicionada com sucesso. Deseja <a href="?id='.$id.'">editar</a>';
		        } else {
		        	echo 'Ocorreu um erro';
		        	exit;
		        }


			} else if(isset($_POST['edit'])){

			}
		?>
	</p>
</div>
<?php include('footer-admin.php'); ?>