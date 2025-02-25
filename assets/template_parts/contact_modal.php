<?php
/**
 * Template-part : contact_modal.php
 * 
 * @package Nathalie Mota
 */
?>

<div id="contactModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Contact header.png" alt="en tête du formulaire de contact"> 
        </div>    
        <div class="modal-body">
            <?php echo do_shortcode('[contact-form-7 id="2269a40" title="formulaire_de_contact"]'); ?>
        </div>
    </div>
</div>
