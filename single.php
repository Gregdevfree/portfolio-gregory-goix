<?php echo '<!--template utilisé : single.php -->'; ?>
<?php
/**
 * Template name : theme for displaying all single posts -->Projects
  *
 * @package Portfolio Grégory Goix
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Sécurité WordPress

get_header(); ?>

<main class="single-post-container">
    <?php 
    if ( have_posts() ) : 
        while ( have_posts() ) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
            <h1 class="post-title"><?php the_title(); ?></h1>

            <div class="post-meta">
                <span class="post-date"><?php echo get_the_date(); ?></span>
                <span class="post-author">Par <?php the_author(); ?></span>
            </div>

            <div class="post-thumbnail">
                <?php if ( has_post_thumbnail() ) {
                    the_post_thumbnail('large');
                } ?>
            </div>

            <div class="post-content">
                <?php the_content(); ?>
            </div>

            <div class="post-navigation">
                <?php previous_post_link('%link', '← Projet précédent'); ?>
                <?php next_post_link('%link', 'Projet suivant →'); ?>
            </div>
        </article>

    <?php 
        endwhile; 
    endif; 
    ?>
</main>

<?php get_footer(); ?>