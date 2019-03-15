<?php
/**
 * The header for our admin pages.
 *
 * Displays all of the brand menu and user section
 *
 * @package Milla Meets Bulma
 */
include('header.php');
session_start();
?>
<section class="hero is-info is-medium is-white">
    <div class="container has-text-centered">
        <?php echo $Load->HeroMenu(); ?>
    </div>
</section>
<section class="section">
    <div class="container">