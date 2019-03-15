<?php
	/**
	 * The profile for our theme.
	 *
	 * Displays all of the brand menu section
	 *
	 * @package Bulma by Milla
	 */
	include('header-admin.php');
	include('load/profile.php');
?>
<div class="columns">
    <div class="column is-4">
        <div class="tabs is-left"><?php echo $Load->MainNavegation(LINK, 'Perfil'); ?></div>
    </div>
</div>

<div class="box content">
	<?php echo $Load->HeroMessage(LINK, $name_use, $type.' desde '.$year); ?>
	<hr />
	<section class="info-tiles">
		<form action="#" method="post">
			<div class="columns">
                <div class="column is-7">
					<p class="title is-small">Dados do <?php echo ucfirst($type); ?></p>
					<div class="columns">
						<div class="column">
							<div class="field">
  								<label class="label">Nome</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $name_use; ?>" name="name_use">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                        <div class="column">
                        	<div class="field">
  								<label class="label">E-mail</label>
								<div class="control has-icons-left has-icons-right">
									<input class="input is-link" type="text" placeholder="<?php echo $email; ?>" value="" name="email">
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
  									<input class="input is-link" type="password" placeholder="" name="senha">
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
  									<input class="input is-link" type="date" placeholder="<?php echo $data_nasc; ?>" name="data_nasc" value="<?php echo $data_nasc; ?>">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    	<div class="column">
							<div class="field">
  								<label class="label">RG</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="" name="rg">
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
  									<input class="input is-link" type="text" placeholder="" name="cpf">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                        <div class="column">
                        	<div class="field">
  								<label class="label">Telefone</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="" name="telefone">
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
									<input class="input is-link" type="text" placeholder="<?php echo $cep_res; ?>" value="" name="cep_res">
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
  									<input class="input is-link" type="text" placeholder="<?php echo $end_res; ?>" name="end_res">
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
									<input class="input is-link" type="number" placeholder="<?php echo $num_res; ?>" value="" name="num_res">
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
  									<input class="input is-link" type="text" placeholder="<?php echo $bai_res; ?>" name="bai_res">
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
									<input class="input is-link" type="text" placeholder="<?php echo $cid_res; ?>" value="" name="cid_res">
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
  									<input class="input is-link" type="text" placeholder="<?php echo $uf; ?>" name="uf">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    </div>
                </div>
				<div class="column is-5">
					<div class="columns">
						<div class="column is-6">
							<label class="label">Foto</label>
							<div class="field">
		  						<div class="file is-centered is-boxed is-link has-name is-small">
		    						<label class="file-label">
		      							<input class="file-input" type="file" name="foto">
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
					<p class="title is-small">Informações</p>
					<p><strong>Login: </strong>@<a href="profile?id=<?php echo $id; ?>"><?php echo $login; ?></a></p>
					<p><strong><?php echo $type; ?></strong> da área de <?php echo $area; ?></p>
					<p><strong>Data do Cadastro:</strong> <?php echo $signup_date; ?>
					<hr/>
					<?php echo $data; ?>
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="assets/js/cep.js"></script>
<script src="assets/js/cpf.js"></script>
<script type="text/javascript">
    function Nova(){
        location.reload();
    }
</script>
<?php
	if(isset($_POST['save'])) {

	}
	include('footer-admin.php');
?>