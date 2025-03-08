<?php echo '<!--template utilisé : page.php -->'; ?>
<?php
/**
 * Template for displaying all pages "Politique de Confidentialité et Mentions Légales"
 *
 * @package Portfolio Grégory Goix
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Sécurité WordPress
get_header(); 
?>
<div class="content-wrapper">
    <main id="primary" class="site-main">
        <?php
        /* Start the Loop */
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header><!-- .entry-header -->
                
                <div class="entry-content">
                    <?php
                    the_content();
                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'portfolio-gregory-goix' ),
                            'after'  => '</div>',
                        )
                    );
                    ?>
                </div><!-- .entry-content -->
                
                <?php if ( current_user_can( 'edit_posts' ) ) : ?>
                <footer class="entry-footer">
                    <?php edit_post_link( esc_html__( 'Edit', 'portfolio-gregory-goix' ), '<span class="edit-link">', '</span>' ); ?>
                </footer><!-- .entry-footer -->
                <?php endif; ?>
            </article><!-- #post-<?php the_ID(); ?> -->
            
            <?php
            // Affichage des commentaires si activés
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
        endwhile; // End of the loop.
        ?>
    </main><!-- #primary -->
</div><!-- .content-wrapper -->
<?php get_footer(); ?>