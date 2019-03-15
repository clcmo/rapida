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
<section class="hero is-info is-fullheight">
    <div class="container has-text-centered">
        <?php echo $Load->HeroMenu(); ?>
    <div class="hero-body">