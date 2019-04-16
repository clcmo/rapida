<?php
	include('header-admin.php');
	#include('load/pages/notifies.php');
?>
<div class="columns">
    <div class="column is-4">
        <div class="tabs is-left"><?php echo $Load->MainNavegation(); ?></div>
    </div>
    <div class="column is-8">
		<div class="tabs is-right">
			<div class="container">
				<div class="navbar-menu">
					<div class="navbar-end">
						<a class="navbar-item" href="#"><span class="tag is-small">Todas</span></a>
						<a class="navbar-item" href="#"><span class="tag is-primary is-small">Solicitações</span></a>
						<a class="navbar-item" href="#"><span class="tag is-warning is-small">Revisões</span></a>
						<a class="navbar-item" href="#"><span class="tag is-success is-small">Matrículas</span></a>
						<a class="navbar-item" href="#"><span class="tag is-light is-danger is-small">Ocorrências</span></a>
						<a class="navbar-item" href="#"><span class="tag is-dark is-small">Trancamentos</span></a>
						<a class="navbar-item" href="#"><span class="tag is-link is-small">Históricos</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="box content">
	<?php echo $Load->HeroMessage(LINK, 'Notificações', 'Informe os dados para '.$selected_type); ?>
	<hr/>
	<section class="info-tiles">
		<form action="" method="post">
			<div class="columns">
                <div class="column is-7">
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
          							<input class="input is-link" type="text" placeholder="Nome do Usuário" value="<?php echo $name_use; ?>">
          							<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
        							<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
        						</div>
        					</div>
                        </div>
                    </div>
                </div>
                <div class="column is-5">
                	<?php $Pages->LoadTablePage(substr(LINK, 1)); ?>
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

				$sql = 'INSERT INTO notifies (name_not, type_not, id_use, date_not, status_not) VALUES (:name_not, :type_not, '.$_SESSION['id'].', :date_not, 1)';
		        $stmt = $PDO->prepare($sql);
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