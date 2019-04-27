<?php
	include('header-admin.php');
	$link = isset($_GET['id']) ? substr(LINK, 0, 8): LINK;
	include('load/pages'.$link.'.php');
?>
<div class="columns">
    <div class="column is-3">
        <div class="tabs is-left"><?php echo $Navegation->MainNavegation($link); ?></div>
    </div>
</div>
<div class="box content">
	<?php echo $Navegation->HeroMessage(ucfirst('perfil'), 'Informe os dados para '.$selected_type); ?>
	<hr/>
	<section class="info-tiles">
		<form action="#" method="post">
			<div class="columns">
                <div class="column is-6">
					<p class="title is-small">Dados do <?php echo ucfirst($type); ?></p>
					<div class="columns">
						<div class="column">
							<div class="field">
  								<label class="label">Nome</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $name_use; ?>" value="<?php echo $name_use; ?>" name="name_use">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                        <div class="column">
                        	<div class="field">
  								<label class="label">E-mail</label>
								<div class="control has-icons-left has-icons-right">
									<input class="input is-link" type="text" placeholder="<?php echo $email; ?>" name="email" value="<?php echo $email; ?>">
									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
								<p class="help is-success"></p>
							</div>
                        </div>
                    </div>
					<div class="columns">
						<div class="column">
							<div class="field">
  								<label class="label">Senha</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="password" value="" placeholder="" name="password">
  									<span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                        <div class="column">
                        	<div class="field">
  								<label class="label"><?php echo ucfirst($string); ?></label>
  								<?php echo $input; ?>
							</div>
                        </div>
                    </div>
                    <div class="columns">
                    	<div class="column">
							<div class="field">
  								<label class="label">Data de Nascimento</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="date" placeholder="<?php echo $birthday_date; ?>" value="<?php echo $birthday_date; ?>" name="birthday_date">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    	<div class="column">
							<div class="field">
  								<label class="label">RG</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $rg; ?>" value="<?php echo $rg; ?>" name="rg">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                        	<div class="field">
  								<label class="label">CPF</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $cpf; ?>" value="<?php echo $cpf; ?>" name="cpf">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                        <div class="column">
                        	<div class="field">
  								<label class="label">Telefone</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $phone; ?>" value="<?php echo $phone; ?>" name="phone">
  									<span class="icon is-small is-left"><i class="fas fa-mobile"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    </div>
                    <hr />
                    <p class="title is-small">Dados Residenciais do <?php echo ucfirst($type); ?></p>
                    <div class="columns">
						<div class="column">
							<div class="field">
  								<label class="label">CEP</label>
								<div class="control has-icons-left has-icons-right">
									<input class="input is-link" type="text" placeholder="<?php echo $cep; ?>" value="<?php echo $cep; ?>" name="cep">
									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
								<p class="help is-success"></p>
							</div>
                        </div>
                        <div class="column">
                        	<div class="field">
  								<label class="label">Endereço</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $address; ?>" value="<?php echo $address; ?>" name="address">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    </div>
					<div class="columns">
						<div class="column">
							<div class="field">
  								<label class="label">Número</label>
								<div class="control has-icons-left has-icons-right">
									<input class="input is-link" type="number" placeholder="<?php echo $number; ?>" value="<?php echo $number; ?>" name="number">
									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
								<p class="help is-success"></p>
							</div>
                        </div>
                        <div class="column">
                        	<div class="field">
  								<label class="label">Bairro</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $neighborhood; ?>" value="<?php echo $neighborhood; ?>" name="neighborhood">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    </div>
                    <div class="columns">
                    	<div class="column">
							<div class="field">
  								<label class="label">Cidade</label>
								<div class="control has-icons-left has-icons-right">
									<input class="input is-link" type="text" placeholder="<?php echo $city; ?>" value="<?php echo $city; ?>" name="city">
									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
								<p class="help is-success"></p>
							</div>
                        </div>
                        <div class="column">
                        	<div class="field">
  								<label class="label">Estado</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $state; ?>" value="<?php echo $state; ?>" name="state">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    </div>
                </div>
				<div class="column is-6">
					<div class="columns">
						<div class="column is-6">
							<!--Mudar para Gravatar-->
							<label class="label">Foto</label>
							<div class="field">
		  						<div class="file is-centered is-boxed is-link has-name is-small">
		    						<label class="file-label">
		      							<input class="file-input" type="file" name="photo">
		      							<span class="file-cta">
		        							<span class="file-icon"><i class="fas fa-upload"></i></span>
		        							<span class="file-label">Carregar Foto…</span>
		      							</span>
		      							<span class="file-name">Carregar Foto…</span>
		    						</label>
		    					</div>
		  					</div>
						</div>
						<div class="column is-4">
							<figure class="image is-128x128"><img class="is-rounded" src="<?php echo $photo; ?>"></figure>
		  				</div>
		  			</div>
		  			<hr/>
		  			<?php echo $data; ?>
					<hr/>
					<?php $Pages->LoadTablePage('users'); ?>
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
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="assets/js/cep.js"></script>
<script src="assets/js/cpf.js"></script>
<script type="text/javascript">
    function Nova(){
        location.reload();
    }
</script>
</div>
<?php
	if(isset($_POST['save']) || isset($_POST['edit'])){

	}

	if(isset($_POST['save'])){} elseif(isset($_POST['edit'])){}

	include('footer-admin.php');
?>