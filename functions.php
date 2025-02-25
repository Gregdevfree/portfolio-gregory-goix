<?php
/**
 * Functions and definitions for my theme.
 *
 * @package portfolio-gregory-goix
 */

// Enqueue custom scripts and styles
function nathalie_mota_enqueue_scripts_and_styles() {
    // Enqueue the main stylesheet
    wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css', array(), '2.0', 'all');
    wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
    wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);

    // Enqueue jQuery (WordPress l'inclut par défaut, mais il faut s'assurer qu'il est bien chargé)
    wp_enqueue_script('jquery');

    // Enqueue the custom JavaScript file
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery', 'select2'), '1.0', true);

    // Enqueue the lightbox JavaScript file
    wp_enqueue_script('lightbox-script', get_template_directory_uri() . '/assets/js/lightbox.js', array('jquery'), '1.0', true);

    // Localize script to pass AJAX URL
    wp_localize_script('custom-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_scripts_and_styles');

// Ajout de la prise en charge des menus dans l'administration et du logo personnalisé dans le thème
function nathalie_mota_setup() {
    // Ajouter la prise en charge des menus
    add_theme_support('menus');

    add_theme_support('post-thumbnails');

    register_nav_menus(array(
        'header-menu' => __('Menu Principal', 'nathalie-mota'),
        'footer-menu' => __('Menu Footer', 'nathalie-mota'),
    ));

    // Activer la prise en charge du logo personnalisé
    add_theme_support('custom-logo', array(
        'height' => 14,
        'width' => 216,
        'flex-height' => true,
        'flex-width' => true,
    ));
}
add_action('after_setup_theme', 'nathalie_mota_setup');

// Forcer l'utilisation de WebP via le thème
function replace_images_with_webp($content) {
    return preg_replace('/\.(jpg|jpeg|png)/i', '.webp', $content);
}
add_filter('the_content', 'replace_images_with_webp');

// Fonction pour récupérer les photos apparentées
function get_related_photos($post_id, $taxonomy, $limit = 2) {
    $terms = wp_get_post_terms($post_id, $taxonomy, array('fields' => 'ids'));

    if (empty($terms)) {
        return new WP_Query();
    }

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => $limit,
        'post__not_in'   => array($post_id),
        'tax_query'      => array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'term_id',
                'terms'    => $terms,
            ),
        ),
    );

    return new WP_Query($args);
}

// Fonction pour récupérer une image aléatoire depuis les articles de type "photo" avec la taxonomie "formats" => "paysage"
function get_random_photo() {
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 1,
        'orderby'        => 'rand',
        'tax_query'      => array(
            array(
                'taxonomy' => 'formats',
                'field'    => 'slug',
                'terms'    => 'paysage', // Ajout du filtre sur la taxonomie
            ),
        ),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $query->the_post();
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

        wp_send_json_success(array('image' => $image_url));
    } else {
        wp_send_json_success(array('image' => get_template_directory_uri() . '/assets/images/hero-poster-motaphoto.jpeg')); // Image par défaut
    }

    wp_die();
}

// Enregistrer les actions AJAX pour les utilisateurs connectés et non connectés
add_action('wp_ajax_get_random_photo', 'get_random_photo');
add_action('wp_ajax_nopriv_get_random_photo', 'get_random_photo');

// Fonction pour charger plus de photos avec AJAX
function load_more_photos() {
    $paged = isset($_POST['page']) ? $_POST['page'] : 1;

    $gallery_args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'paged'          => $paged,
    );

    $gallery_query = new WP_Query($gallery_args);

    if ($gallery_query->have_posts()) :
        while ($gallery_query->have_posts()) : $gallery_query->the_post();
            set_query_var('photo', get_post());
            get_template_part('assets/template_parts/photo_block');
        endwhile;
    else :
        echo ''; // Renvoie une réponse vide s'il n'y a plus de photos
    endif;
    wp_reset_postdata();

    wp_die();
}

// Ajout des actions AJAX pour les utilisateurs connectés et non connectés
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

// Add AJAX action for filtering and sorting photos
function filter_and_sort_photos() {
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $sort = isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : 'DESC';

    $gallery_args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => $sort,
    );

    // Add category filter if selected
    if (!empty($category)) {
        $gallery_args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    // Add format filter if selected
    if (!empty($format)) {
        $gallery_args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    // If multiple tax_query conditions, set relation to AND
    if (count($gallery_args['tax_query']) > 1) {
        $gallery_args['tax_query']['relation'] = 'AND';
    }

    $gallery_query = new WP_Query($gallery_args);

    ob_start();
    if ($gallery_query->have_posts()) :
        while ($gallery_query->have_posts()) : $gallery_query->the_post();
            set_query_var('photo', get_post());
            get_template_part('assets/template_parts/photo_block');
        endwhile;
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;
    wp_reset_postdata();

    $response = ob_get_clean();
    wp_send_json_success($response);
    wp_die();
}
add_action('wp_ajax_filter_and_sort_photos', 'filter_and_sort_photos');
add_action('wp_ajax_nopriv_filter_and_sort_photos', 'filter_and_sort_photos');

// Function to get dynamic filter options for dropdowns
function get_gallery_filter_options() {
    // Récupérer toutes les catégories, même sans posts (hide_empty = false)
    $categories = get_terms(array(
        'taxonomy' => 'categorie',
        'hide_empty' => false,
    ));

    // Récupérer tous les formats, même sans posts (hide_empty = false)
    $formats = get_terms(array(
        'taxonomy' => 'format',
        'hide_empty' => false,
    ));

    wp_send_json_success(array(
        'categories' => $categories,
        'formats' => $formats,
    ));
}
add_action('wp_ajax_get_gallery_filter_options', 'get_gallery_filter_options');
add_action('wp_ajax_nopriv_get_gallery_filter_options', 'get_gallery_filter_options');