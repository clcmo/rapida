<?php
	include ('header-admin.php');
?>
<div class="columns">
    <div class="column is-4">
        <div class="tabs is-left"><?php echo $Load->MainNavegation(LINK, null); ?></div>
    </div>
</div>

<div class="box content">
    <?php echo $Load->HeroMessage(LINK, 'Olá, '.$_SESSION['name'], 'Tenha um bom dia!'); ?>
    <div class="columns">
        <div class="column is-6">
            <?php 
                include('load/table/notifies.php');
                include('load/table/classroom.php'); 
            ?>
        </div>
        <div class="column is-6">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">Busca de Disciplinas</p>
                    <a href="#" class="card-header-icon" aria-label="more options"><span class="icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span></a>
                </header>
                <div class="card-content">
                    <div class="content">
                        <div class="control has-icons-left has-icons-right">
                            <input class="input is-large" type="text" placeholder="">
                            <span class="icon is-medium is-left"><i class="fa fa-search"></i></span>
                            <span class="icon is-medium is-right"><i class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">Busca de Usuário</p>
                    <a href="#" class="card-header-icon" aria-label="more options"><span class="icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span></a>
                </header>
                <div class="card-content">
                    <div class="content">
                        <div class="control has-icons-left has-icons-right">
                            <input class="input is-large" type="text" placeholder="">
                            <span class="icon is-medium is-left"><i class="fa fa-search"></i></span>
                            <span class="icon is-medium is-right"><i class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('footer-admin.php'); ?>