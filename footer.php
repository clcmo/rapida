	<?php
        switch($Login->IsLogged()){
        	case true:
        	?>
        				</div>
					</div>
				</section>
				<footer class="footer">
					<div class="container">
						<?php echo $Navegation->FooterMenu(); ?>
						<div class="content has-text-centered">
							<div class="columns is-mobile is-centered">
								<div class="field is-grouped is-grouped-multiline"><?php echo FOOTER; ?></div>
							</div>
						</div>
					</div>
				</footer>
        	<?php
        	break;

        	case false:
        	?>
        				</div>
						<div class="hero-foot">
							<div class="container">
								<div class="content has-text-centered"><?php echo FOOTER; ?></div>
							</div>
						</div>
					</div>
				</section>
				<?php
	       	break;
        }
    ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="<?php echo SERVER; ?>assets/js/cep.js"></script>
	<script src="<?php echo SERVER; ?>assets/js/cpf.js"></script>
	<script type="text/javascript">
	    function Cancel(){
	        location.reload();
	    }
	</script>
</div>