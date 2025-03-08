<?php echo '<!--template utilisé : swiper_projects.php -->'; ?>
<?php
/**
 * Template-part : swiper_projects.php
 * 
 * @package Portfolio Grégory Goix
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Sécurité WordPress
?>

<div class="swiper mySwiper">
  <div class="swiper-wrapper">
    <?php
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,  // Affiche tous les articles
        'orderby' => 'date',
        'order' => 'DESC'
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            ?>
            <div class="swiper-slide">
                <a href="<?php the_permalink(); ?>" class="slide-content">
                    <?php 
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('full size');  
                    } else {
                        // Image par défaut si aucune image n'est définie
                        echo '<img src="' . get_template_directory_uri() . '/assets/images/default-image.png" alt="Image par défaut">';
                    }
                    ?>
                    <h3><?php the_title(); ?></h3>
                </a>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>
  </div>
  <!-- Flèches de navigation -->
  <div class="swiper-button-next"></div>
  <div class="swiper-button-prev"></div>
  <!-- Pagination -->
  <div class="swiper-pagination"></div>
</div>
