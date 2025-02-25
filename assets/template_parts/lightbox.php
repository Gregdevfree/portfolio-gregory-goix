<?php
// Template-part : lightbox.php
?>

<div id="lightbox" class="lightbox-overlay" style="display: none;">
    <div class="lightbox-content">
        <span class="lightbox-close" id="lightbox-close">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/ferme_menu.png" alt="Fermer">
        </span>
        <a href="#" class="lightbox-prev" id="lightbox-prev">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/petite_fleche_gauche.png" alt="Précédente">
            <span>Précédente</span>
        </a>
        <div class="lightbox-image-container">
            <img id="lightbox-image" src="" alt="">
        </div>
        <a href="#" class="lightbox-next" id="lightbox-next">
            <span>Suivante</span>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/petite_fleche_droite.png" alt="Suivante">
        </a>
        <div class="lightbox-details">
            <div class="lightbox-title" id="lightbox-title"></div>
            <div class="lightbox-category" id="lightbox-category"></div>
        </div>
    </div>
</div>
