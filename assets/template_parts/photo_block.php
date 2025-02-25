<?php
/**
 * Template-part : photo block for displaying all single photos posts and all related-photos
 * 
 * @package Nathalie Mota
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Sécurité WordPress

if ( isset( $photo ) && $photo instanceof WP_Post ) :
    $photo_id = $photo->ID;
    $photo_title = get_the_title( $photo_id );
    $photo_permalink = get_permalink( $photo_id );
    $photo_thumbnail = get_the_post_thumbnail( $photo_id, 'medium_large' );
    $photo_reference = get_field('reference', $photo_id);
    $photo_categories = wp_get_post_terms( $photo_id, 'categorie' ); // Récupérer les termes de la taxonomie personnalisée 'categorie'
    $photo_category = $photo_categories ? $photo_categories[0]->name : 'Aucune catégorie'; // Récupérer le nom de la première catégorie
    $photo_url = get_the_post_thumbnail_url( $photo_id, 'full' ); // Récupérer l'URL de l'image
    ?>
    <article class="related-photo-block">
        <a href="<?php echo esc_url( $photo_permalink ); ?>" class="photo-block-link">
            <div class="photo-block-image">
                <?php echo $photo_thumbnail ? $photo_thumbnail : '<p>Aucune image</p>'; ?>
                <div class="thumbnail-overlay">
                    <a href="<?php echo esc_url( $photo_permalink ); ?>" class="overlay-link overlay-link-eye">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon_eye.png" alt="Voir le détail de la photo">
                    </a>
                    <a href="#" class="overlay-link overlay-link-fullscreen" data-photo-id="<?php echo esc_attr($photo_id); ?>" data-photo-url="<?php echo esc_url($photo_url); ?>" data-photo-title="<?php echo esc_attr($photo_title); ?>" data-photo-category="<?php echo esc_attr($photo_category); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon_fullscreen.png" alt="Voir la photo en plein écran">
                    </a>
                    <div class="photo-info">
                        <div class="photo-info-left">
                            <p><?php echo esc_html($photo_title); ?></p>
                        </div>
                        <div class="photo-info-right">
                            <p><?php echo esc_html($photo_category); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </article>
<?php endif; ?>
