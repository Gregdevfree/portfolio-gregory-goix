<?php get_header(); ?>

<div class="content-area">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                the_content();
            endwhile;
        else :
            echo '<p>Aucun contenu disponible.</p>';
        endif;
        ?>
    </div>
</div>


<?php get_footer(); ?>
