<?php
/**
 * Template-part : contact_modal.php
 * 
 * @package Portfolio Grégory Goix
 */
 if ( ! defined( 'ABSPATH' ) ) exit; // Sécurité WordPress
?>

<div id="contactModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Me contacter</h2> 
            <p>Mon E-Mail: contact@gregory-goix.fr</p>
        </div>    
        <div class="modal-body">
            <?php echo do_shortcode('[contact-form-7 id="e232a57" title="formulaire_de_contact"]'); ?>
        </div>
    </div>
</div>
