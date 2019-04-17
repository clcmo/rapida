<?php
	/**
	 * The header for our main pages.
	 *
	 * Displays all of the brand menu section
	 *
	 * @package Bulma by Milla
	 */
	include('header.php');
	session_start();
?>
<section class="hero is-fullheight">
    <div class="container has-text-centered">
        <?php echo $Navegation->HeroMenu(); ?>
    <div class="hero-body">