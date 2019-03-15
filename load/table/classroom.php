<?php
    $name_page = 'classroom';
    $script = $name_page.', courses WHERE '.$name_page.'.id_cou = courses.id_cou';
    $button_title = 'Ver Alunos';
    $type_table = $Tables->Found_Item('type', 'courses');
    include('main.php');