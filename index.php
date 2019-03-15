<?php
    /**
     * The landing page for our theme.
     *
     * Displays all of the brand menu content and index
     *
     * @package Bulma by Milla
     */
    include('header-index.php');
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
        </div>
<?php include('footer-index.php'); ?>