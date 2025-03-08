<?php
/**
 * Template name : theme for 404 error page
  *
 * @package Portfolio Grégory Goix
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Sécurité WordPress

get_header(); ?>

<div class="container-404">
    <h1>Oups ! ERREUR 404 - Page introuvable</h1>
    <p>La page que vous cherchez n'existe pas ou a été déplacée.</p>
    <a href="<?php echo home_url(); ?>" class="btn-404">Retour à l'accueil</a>
</div>

<meta http-equiv="refresh" content="5;URL=<?php echo home_url(); ?>">

<?php get_footer(); ?>