<?php
/**
 * Functions and definitions for my theme.
 *
 * @package Portfolio Grégory Goix
 */
 if ( ! defined( 'ABSPATH' ) ) exit; // Sécurité WordPress

// Enqueue custom scripts and styles
function portfolio_gregory_goix_enqueue_scripts_and_styles() {
    // CSS
    wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css', array(), '2.0', 'all');
    wp_enqueue_style('swiper-style', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.2.4', 'all');
    
    // JS
    wp_enqueue_script('jquery');
    wp_enqueue_script('swiper-script', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array('jquery'), '11.2.4', true);
    wp_enqueue_script('custom-swiper', get_template_directory_uri() . '/assets/js/swiper-init.js', array('swiper-script'), null, true);
    
    // Autres scripts
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery', 'swiper-script'), '1.0', true);
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'portfolio_gregory_goix_enqueue_scripts_and_styles');

// Ajout de la prise en charge des menus et du logo personnalisé
function portfolio_gregory_goix_setup() {
    // Ajouter la prise en charge des images mises en avant
    add_theme_support('post-thumbnails');

    // Enregistrer les menus
    register_nav_menus(array(
        'header-menu' => __('Menu Principal', 'portfolio-gregory-goix'),
        'footer-menu' => __('Menu Footer', 'portfolio-gregory-goix'),
    ));

    // Activer la prise en charge du logo personnalisé
    add_theme_support('custom-logo', array(
        'height' => 14,
        'width' => 216,
        'flex-height' => true,
        'flex-width' => true,
    ));
}
add_action('after_setup_theme', 'portfolio_gregory_goix_setup');

// Forcer l'utilisation de WebP via le thème avec vérification d'existence
function replace_images_with_webp($content) {
    return preg_replace_callback('/\.(jpg|jpeg|png)/i', function ($matches) {
        $webp_path = str_replace($matches[0], '.webp', $matches[0]);
        if (file_exists(get_template_directory() . $webp_path)) {
            return $webp_path;
        }
        return $matches[0]; // Garde l'extension originale si le fichier WebP n'existe pas
    }, $content);
}
add_filter('the_content', 'replace_images_with_webp');
