<?php echo '<!-- Template utilisé : header.php -->'; ?>
<?php
/**
 * Template name : header
  *
 * @package Portfolio Grégory Goix
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Sécurité WordPress
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <title aria-label="Titre de la page"><?php echo wp_get_document_title(); ?></title>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="site-header">
        <div class="container-header">
            <!-- Afficher le logo -->
            <div class="site-logo">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<a href="' . home_url() . '" class="gregory-goix">' . get_bloginfo('name') . '</a>';
                }
                ?>
            </div>
            
            <!-- Hamburger Menu -->
            <div class="hamburger-menu" id="hamburger-menu">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>

            <!-- Menu de navigation -->
            <nav class="main-navigation" aria-label="Menu principal">
                <?php
                if (has_nav_menu('header-menu')) {
                    wp_nav_menu(array(
                        'theme_location' => 'header-menu',  // Emplacement du menu déclaré dans functions.php
                        'menu_class' => 'menu',             // Classe CSS attribuée à la liste <ul>
                        'container' => false,               // Désactive le conteneur <div> par défaut
                    ));
                }
                ?>
            </nav>
        </div>
        <!-- Menu toggle -->
        <div class="menu-toggle" id="menu-toggle">
            <?php
            if (has_nav_menu('header-menu')) {
                wp_nav_menu(array(
                    'theme_location' => 'header-menu',  // Utilise le même menu que dans le main-navigation
                    'container' => false,               // Pas de conteneur div
                    'menu_class' => 'menu-toggle-list',  // Classe CSS pour personnaliser les liens
                    'items_wrap' => '<ul>%3$s</ul>',    // Assurez-vous que les éléments sont dans une <ul>
                ));
            }
            ?>
        </div>
    </header>
    <main class="site-main">

