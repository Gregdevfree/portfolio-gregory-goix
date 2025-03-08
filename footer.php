<?php echo '<!-- Template utilisé : footer.php -->'; ?>
<?php
/**
 * Template name : footer
 *
 * @package Portfolio Grégory Goix
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Sécurité WordPress
?>
    <footer class="site-footer">
        <div class="container-footer">
            <nav class="footer-navigation">
                <?php
                if (has_nav_menu('footer-menu')) {
                    wp_nav_menu(array(
                        'theme_location'  => 'footer-menu',
                        'menu_class'      => 'footer-menu',
                        'container'       => false,
                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s<li class="copyright-item">TOUS DROITS RÉSERVÉS GRÉGORY GOIX</li></ul>',
                    ));
                } else {
                    echo '<ul class="footer-menu"><li class="copyright-item">TOUS DROITS RÉSERVÉS GRÉGORY GOIX</li></ul>';
                }
                ?>
            </nav>
        </div>
    </footer>

<?php get_template_part('assets/template_parts/contact_modal'); ?>
<?php wp_footer(); ?>
</body>
</html>