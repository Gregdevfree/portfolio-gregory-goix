<?php echo '<!-- Template utilisé : front-page.php -->'; ?>
<?php
/**
 * Template Name: Front Page
 *
 * @package Portfolio Grégory Goix
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Sécurité WordPress
global $post;
get_header(); 
?>
<div class="content-wrapper">
    <main id="primary" class="site-main">
        <div class="hero-overlay">
            <div id="hero-header" class="hero-header">
                <div class="hero-content">
                    <h1 class="hero-title">Développeur Web WordPress</h1>
                    <h2>Spécialiste Thèmes & Plugins<br>Découvrez ci-dessous le portfolio de mes projets</h2>
                    <p>(sites réalisés lors de ma formation chez OpenClassrooms)</p>
                </div>
            </div>
        </div>
        
        <!-- swiper projects -->
        <?php get_template_part( 'assets/template_parts/swiper_projects' ); ?>
        
        <!--Infinite Jury Comments-->
        <div class="title-jury-comments">
            <h2>Commentaires de mes jurys évaluateurs pros</h2>
        </div>
        <div class="marquee-container">
            <div class="marquee">
                <span>"Grégory a fait preuve de professionnalisme et a acquis les compétences évaluées. 
                    Félicitations! - Prestation orale fluide tout au long de la soutenance - 
                    Vous avez su présenter votre projet avec une posture professionnelle - 
                    La gestion de projet est bien maîtrisée. Bravo pour ce projet réussi! - 
                    Excellente prise en main des outils d’optimisation - 
                    Respect des critères techniques et des bonnes pratiques de performance et SEO -
                    Capacité à réduire le temps de chargement sans compromettre l’esthétique du site. 
                    L’étudiant a démontré une solide compréhension des enjeux liés à l’optimisation des performances et au référencement. 
                    Avec un score Lighthouse de 90, il dépasse les attentes de ce projet. 
                    Bravo pour ce travail de qualité!"
                </span>
            </div>
            <div class="marquee marquee-delay">
                <span>"Projet de bonne qualité répondant à toutes les exigences de la mission et bien présenté - 
                    Attention particulière apportée à la responsivité, aux techniques de green code, et aux détails de style - 
                    C'était un plaisir de discuter avec Grégory qui a réalisé un travail de qualité, très bonne énergie - 
                    Il a fait preuve de professionnalisme et a acquis les compétences évaluées - 
                    Bonne maîtrise des manipulations JavaScript et des animations CSS - 
                    Grégory a bien expliqué les choix techniques réalisés durant le projet. Félicitations!"
                </span>
            </div>
            <div class="marquee marquee-delay-2">
                <span>"La soutenance a été bien menée avec une présentation fluide et une démonstration fonctionnelle convaincante - 
                    Félicitations pour ce travail soigné et prometteur, et continuez à approfondir les concepts pour développer une expertise encore plus complète! - 
                    Code bien écrit, commenté, lisible et fonctionnel - Présentation bien structurée avec recontextualisation - 
                    Terminologie précise, explications détaillées et difficultés bien surmontées - 
                    Les compétences sont acquises, félicitations!"
                </span>
            </div>
        </div>

        <div class="title-about-me">
            <h2>À propos de moi</h2>
        </div>  
        <section id="a-propos-de-moi">
            <div class="thumbnail-gg">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gregory_goix.webp" alt="Grégory Goix" />
            </div>
            <div class="presentation">
                <p>Bonjour, je suis Grégory Goix. Après plusieurs années en tant que technico-commercial dans le domaine de l'étiquetage, 
                    j'ai acquis une solide expérience terrain, en contact direct avec les besoins spécifiques de mes clients.
                J'appréciais de pouvoir leur réaliser des applications métiers sur mesure en programmant des matériels livrés prêts à l'emploi 
                (hardware/software de marque SATO, et logiciel Nicelabel/Loftware).
                Devenir développeur Web WordPress représente le meilleur  moyen de retrouver ce type de satisfaction en créant des sites Internet. 
                J'ai donc repris le chemin des études pour suivre la formation diplômante d'OpenClassrooms.
                Je suis à votre disposition pour étudier votre projet, votre proposition. A bientôt !
                </p>
                <button type="button" class="btn-submit" id="contactBtn">Me contacter</button>
            </div>
        </section>
        <div class="skills">
            <h2>Mes compétences</h2>
        </div> 
        <!-- 3D Rotation Animation Logos Carousel -->
        <div class="box">
            <span style="--i:1;"><img src="<?php echo esc_url(home_url('/wp-content/uploads/2025/03/image1.webp')); ?>" alt="Image 1"></span>
            <span style="--i:2;"><img src="<?php echo esc_url(home_url('/wp-content/uploads/2025/03/image2.webp')); ?>" alt="Image 2"></span>
            <span style="--i:3;"><img src="<?php echo esc_url(home_url('/wp-content/uploads/2025/03/image3.webp')); ?>" alt="Image 3"></span>
            <span style="--i:4;"><img src="<?php echo esc_url(home_url('/wp-content/uploads/2025/03/image4.webp')); ?>" alt="Image 4"></span>
            <span style="--i:5;"><img src="<?php echo esc_url(home_url('/wp-content/uploads/2025/03/image5.webp')); ?>" alt="Image 5"></span>
            <span style="--i:6;"><img src="<?php echo esc_url(home_url('/wp-content/uploads/2025/03/image6.webp')); ?>" alt="Image 6"></span>
            <span style="--i:7;"><img src="<?php echo esc_url(home_url('/wp-content/uploads/2025/03/image7.webp')); ?>" alt="Image 7"></span>
            <span style="--i:8;"><img src="<?php echo esc_url(home_url('/wp-content/uploads/2025/03/image8.webp')); ?>" alt="Image 8"></span>
            <span style="--i:9;"><img src="<?php echo esc_url(home_url('/wp-content/uploads/2025/03/image9.webp')); ?>" alt="Image 9"></span>
            <span style="--i:10;"><img src="<?php echo esc_url(home_url('/wp-content/uploads/2025/03/image10.webp')); ?>" alt="Image 10"></span>
        </div>        
        <div class="contact-section">
            
            <?php
            $pdf_url = wp_get_attachment_url(360); // 360=l'ID du PDF depuis la médiathèque WordPress
            if ($pdf_url) :
            ?>
                <a href="<?php echo esc_url($pdf_url); ?>" target="_blank" class="open-pdf-btn">
                    Mon C.V.
                </a>
            <?php endif; ?>
            
            <?php
            $image_id = 66; // =l'ID réel de l'image dans la médiathèque WordPress
            $image_url = wp_get_attachment_image_url($image_id, 'full');
            if ($image_url) : ?>
            <div class="linkedin-container">
                <h3 class="linkedin-text">cliquez ou scannez</h3>
                    <a href="https://www.linkedin.com/in/gr%C3%A9gory-goix-421495a7" target="_blank" rel="noopener noreferrer" class="linkedin-button">
                        <img src="<?php echo esc_url($image_url); ?>" alt="LinkedIn" class="linkedin-image">
                    </a>
            </div>
            <?php endif; ?> 
        </div>
    </main>
</div>
<?php get_footer(); ?>