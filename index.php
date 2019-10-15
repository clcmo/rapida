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
                        <h1 class="title is-logo is-large">bem vindos</h1>
                        <h2 class="subtitle">você já pode entrar na Rápida. Basta informar seu e-mail abaixo: </h2>
                        <form action="" method="post">
                            <div class="box">
                                <div class="field is-grouped">
                                    <p class="control is-expanded"><input class="input" type="email" name="email" placeholder="Insira seu e-mail"></p>
                                    <p class="control"><input class="button is-info" type="submit" name="send" value="Entrar" /></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div><?php
        break;
    }

    if(isset($_POST['send'])) {
        # Resgata variáveis do formulário
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        $stmt = $PDO->prepare(
            $Tables->SelectFrom(null, 'users 
                WHERE email = :email 
                AND status_use = 1', 0, 1));
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($users) <= 0) {
            $Load->Link('signup?email='.$email);
        } else {
            # Redireciona para a página de Login
            $Load->Link('login?email='.$email);    
        }           
    }
    include('footer.php');