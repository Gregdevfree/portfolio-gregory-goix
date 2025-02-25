<?php
/**
 * Template name : single photo for displaying all photos posts
  *
 * @package portfolio-gregory-goix
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Sécurité WordPress

get_header(); // Inclure l'en-tête du site

// Démarrer la boucle WordPress
if( have_posts() ) : while( have_posts() ) : the_post(); 
    // Récupérer les valeurs des champs personnalisés
    $reference = esc_html(get_post_meta(get_the_ID(), 'reference', true));
    $type = esc_html(get_post_meta(get_the_ID(), 'type', true));
    
    // Récupérer les taxonomies
    $categories = get_the_terms(get_the_ID(), 'categorie');
    $formats = get_the_terms(get_the_ID(), 'format');
    
    // Formater les taxonomies en chaîne de caractères
    $categorie_names = $categories ? implode(', ', wp_list_pluck($categories, 'name')) : 'Non définie';
    $format_names = $formats ? implode(', ', wp_list_pluck($formats, 'name')) : 'Non défini';
?>

<div class="single-photo-page">
    <article class="photo-article">
        <div class="photo-desc-pict">
            <div class="photo-desc">
                <h2 class="desc-item photo-title"><?php the_title(); ?></h2>
                <p class="desc-item">RÉFÉRENCE : <?php echo $reference ?: 'Non définie'; ?></p>
                <p class="desc-item">CATÉGORIE : <?php echo esc_html($categorie_names); ?></p>
                <p class="desc-item">FORMAT : <?php echo esc_html($format_names); ?></p>
                <p class="desc-item">TYPE : <?php echo $type ?: 'Non défini'; ?></p>
                <p class="desc-item">ANNÉE : <?php echo get_the_date("Y"); ?></p>
            </div>
            <div class="photo-picture">
                <?php 
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail('large'); 
                } else {
                    echo '<p>Aucune image définie.</p>';
                }
                ?>
            </div>
        </div>
        <div class="photo-bottom">
            <div class="photo-bottom-left-contact">
                <p>Cette photo vous intéresse ?</p>
                <button type="button" class="btn-submit" id="contactBtn">Contact</button>
                <input type="hidden" id="photo-ref" value="<?php echo esc_attr($reference); ?>">
            </div>
            <div class="photo-bottom-right">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>
                <div class="photo-arrows">
                    <?php if ($prev_post): ?>
                        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="arrow" id="prev-arrow-left">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/fleche-gauche.png" alt="Précédent">
                            <div class="thumbnail-container">
                                <?php echo get_the_post_thumbnail($prev_post->ID, 'thumbnail'); ?>
                                <p><?php echo get_the_title($prev_post->ID); ?></p>
                            </div>
                        </a>
                    <?php else: ?>
                        <span class="arrow-disabled" id="prev-arrow">Aucune photo plus ancienne</span>
                    <?php endif; ?>

                    <?php if ($next_post): ?>
                        <a href="<?php echo get_permalink($next_post->ID); ?>" class="arrow" id="next-arrow-right">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/fleche-droite.png" alt="Suivant">
                            <div class="thumbnail-container">
                                <?php echo get_the_post_thumbnail($next_post->ID, 'thumbnail'); ?>
                                <p><?php echo get_the_title($next_post->ID); ?></p>
                            </div>
                        </a>
                    <?php else: ?>
                        <span class="arrow-disabled" id="next-arrow">Aucune photo plus récente</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </article>
    
    <div class="related-photos">
        <h3>VOUS AIMEREZ AUSSI</h3>
        <div class="related-photos-container">
            <?php
            // Récupérer les photos apparentées
            $related_photos = get_related_photos(get_the_ID(), 'categorie', 2);
            
            if ($related_photos->have_posts()) :
                while ($related_photos->have_posts()) : $related_photos->the_post();
                    set_query_var('photo', get_post()); // Passer la variable correctement
                    get_template_part('assets/template_parts/photo_block');
                endwhile;
            else:
                echo '<p>Aucune photo apparentée trouvée.</p>';
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>

<?php
    endwhile;
endif;
wp_reset_postdata();
get_footer(); // Inclure le pied de page du site
?>
