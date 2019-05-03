<?php
    require_once('functions/main.php');
    session_start();
?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?php echo DESC; ?>">
        <meta name="author" content="<?php echo AUTHOR; ?>">
        <title><?php echo TITLE_HEAD; ?></title>
        <!-- Favicon -->
        <link href="<?php echo SERVER; ?>assets/brand/favicon.ico" rel="icon" type="image/png">
        <!-- Theme CSS -->
        <link type="text/css" href="<?php echo SERVER; ?>assets/style.css" rel="stylesheet">
        <link type="text/css" href="<?php echo SERVER; ?>assets/node_modules/bulma-pageloader/dist/css/bulma-pageloader.min.css" rel="stylesheet">
        <link type="text/css" href="<?php echo SERVER; ?>assets/node_modules/bulma-pageloader/src/sass/index.sass" rel="stylesheet">
        <!-- JS -->
        <script src="assets/js/change.js"></script>
        <script src="assets/js/cep.js"></script>
        <script src="assets/js/cpf.js"></script>
    </head>
    <body>
        <?php
            switch($Login->IsLogged()){
                case true:
                    $section_class = 'is-medium';
                    $class = '
                        </section>
                        <section class="section">
                            <div class="container">';
                break;
                case false:
                    $section_class = 'is-fullheight';
                    $class = '<div class="hero-body">';
                break;
            }
        ?>    
        <section class="hero <?php echo $section_class; ?>">
            <div class="container has-text-centered"><?php echo $Navegation->HeroMenu(); ?></div>
        <?php 
            echo $class;
            #include('load/pages/main.php');