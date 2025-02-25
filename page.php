<?php
/**
 * The template for displaying all pages
 *
 * @package portfolio-gregory-goix
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
    the_post();
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php
            the_content();

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'nathalie-mota' ),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->

        <footer class="entry-footer">
            <?php edit_post_link( esc_html__( 'Edit', 'nathalie-mota' ), '<span class="edit-link">', '</span>' ); ?>
        </footer><!-- .entry-footer -->
    </article><!-- #post-<?php the_ID(); ?> -->
    <?php

    // If comments are open or there is at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) {
        comments_template();
    }
endwhile; // End of the loop.

get_footer();