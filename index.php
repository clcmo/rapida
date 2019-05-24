<?php
    include('header.php');
    switch ($Login->IsLogged()) {
        case true:
            ?>
            <div class="columns">
                <div class="column">
                    <div class="tabs is-left"><?php echo $Navegation->MainNavegation($link); ?></div>
                    </div>
                </div>
                <div class="box content">
                    <?php echo $Navegation->HeroMessage(); ?>
                    <div class="columns">
                        <div class="column">
                            <?php echo $Pages->LoadTablePage('notifies'); echo $Pages->LoadTablePage('classroom'); ?>
                        </div>
                        <div class="column">
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
                </div><?php
        break;
        case false:
            ?>
            <div class="hero-body">
                <div class="container has-text-centered">
                    <div class="column is-6 is-offset-3">
                        <h1 class="title is-logo is-large">Estamos Chegando</h1>
                        <h2 class="subtitle">A Rápida está em desenvolvimento. Para saber planos e pacotes, insira seu e-mail e saiba antes de todo mundo.</h2>
                        <form action="" method="post">
                            <div class="box">
                                <div class="field is-grouped">
                                    <p class="control is-expanded"><input class="input" type="text" placeholder="Insira seu e-mail"></p>
                                    <p class="control"><input class="button is-info" type="submit" name="send" value="Me Informe" /></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div><?php
        break;
    } 
    include('footer.php');