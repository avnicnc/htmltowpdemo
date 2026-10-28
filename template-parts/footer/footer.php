<?php
/**
 * Footer Template Part
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

// Fetch footer options
$contact_items = get_field( 'footer_contact_items', 'option' );
$footer_logo   = get_field( 'footer_logo', 'option' );
$intro_title   = get_field( 'footer_intro_title', 'option' );
$intro_desc    = get_field( 'footer_intro_desc', 'option' );
$quote_text    = get_field( 'footer_quote_text', 'option' );
$quote_url     = get_field( 'footer_quote_url', 'option' );

$copyright_raw = get_field( 'footer_copyright', 'option' );
$copyright     = htnl_get_copyright( $copyright_raw );
$social_links  = get_field( 'footer_social_links', 'option' );

// Fallbacks
if ( ! $intro_title ) {
    $intro_title = "Besoin d'aide pour choisir la bonne solution de sécurité ?";
}
if ( ! $intro_desc ) {
    $intro_desc = "Nos experts sont à votre disposition pour vous accompagner dans le choix des produits, vous fournir des conseils techniques et proposer des solutions personnalisées adaptées à vos besoins spécifiques.";
}
if ( ! $quote_text ) {
    $quote_text = 'Obtenir un devis';
}
if ( ! $quote_url ) {
    $quote_url = '#kontakt';
}
?>

<footer class="footer-section" lang="fr">
    <!-- Contact Strip -->
    <div class="footer-section-contact">
        <div class="container footer-section-contact-grid">
            <?php if ( ! empty( $contact_items ) && is_array( $contact_items ) ) : ?>
                <?php foreach ( $contact_items as $idx => $item ) : ?>
                    <?php if ( $idx > 0 ) : ?>
                        <span class="footer-section-contact-divider" aria-hidden="true"></span>
                    <?php endif; ?>
                    <?php if ( ! empty( $item['url'] ) ) : ?>
                        <a href="<?php echo esc_url( $item['url'] ); ?>">
                    <?php else : ?>
                        <div>
                    <?php endif; ?>
                        <span class="footer-section-contact-icon" aria-hidden="true">
                            <?php if ( ! empty( $item['icon']['ID'] ) ) : ?>
                                <?php echo htnl_render_image( $item['icon'], 'thumbnail', array( 'width' => 24, 'height' => 24 ) ); ?>
                            <?php elseif ( ! empty( $item['icon_svg'] ) ) : ?>
                                <?php echo $item['icon_svg']; // SVG markup ?>
                            <?php endif; ?>
                        </span>
                        <span>
                            <strong><?php echo esc_html( $item['title'] ); ?></strong>
                            <small><?php echo esc_html( $item['subtitle'] ); ?></small>
                        </span>
                    <?php if ( ! empty( $item['url'] ) ) : ?>
                        </a>
                    <?php else : ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <!-- Default Static Contact Items -->
                <a href="#kontakt">
                    <span class="footer-section-contact-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 13v-2a8 8 0 0 1 16 0v2M4 12H2v7h5v-7H4Zm16 0h2v7h-5v-7h3Zm0 7c0 3-4 3-7 3"/></svg>
                    </span>
                    <span><strong>Service client</strong><small>Nous sommes là pour vous aider</small></span>
                </a>
                <span class="footer-section-contact-divider" aria-hidden="true"></span>
                <a href="tel:+464048580">
                    <span class="footer-section-contact-icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/phone.svg' ); ?>" width="24" height="24" alt=""></span>
                    <span><strong>Appelez-nous</strong><small>+46 40-485 80</small></span>
                </a>
                <span class="footer-section-contact-divider" aria-hidden="true"></span>
                <a href="mailto:info@giapremix.se">
                    <span class="footer-section-contact-icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/email.svg' ); ?>" width="24" height="24" alt=""></span>
                    <span><strong>Entrer en contact</strong><small>info@giapremix.se</small></span>
                </a>
                <span class="footer-section-contact-divider" aria-hidden="true"></span>
                <div>
                    <span class="footer-section-contact-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a8 8 0 0 0-8 8c0 6 8 12 8 12s8-6 8-12a8 8 0 0 0-8-8Zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/></svg>
                    </span>
                    <span><strong>Adresse</strong><small>Scheelevägen 17, 223 70 Lund, Sweden</small></span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main Footer Background -->
    <div class="footer-section-main-background">
        <div class="container footer-section-main">
            <div class="footer-section-intro">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'GIA Premix — accueil', 'htnl' ); ?>">
                    <?php if ( ! empty( $footer_logo['ID'] ) ) : ?>
                        <?php echo htnl_render_image( $footer_logo, 'full', array( 'class' => 'footer-section-logo', 'width' => 300, 'height' => 62, 'alt' => get_bloginfo( 'name' ) ) ); ?>
                    <?php else : ?>
                        <img class="footer-section-logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.svg' ); ?>" width="300" height="62" alt="<?php bloginfo( 'name' ); ?>">
                    <?php endif; ?>
                </a>
                <h2><?php echo esc_html( $intro_title ); ?></h2>
                <p><?php echo esc_html( $intro_desc ); ?></p>
                <a class="btn btn-yellow" href="<?php echo esc_url( $quote_url ); ?>">
                    <span><?php echo esc_html( $quote_text ); ?></span>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/btn-triangle.svg' ); ?>" width="24" height="24" alt="" aria-hidden="true">
                </a>
            </div>

            <!-- Footer Columns Nav (Appearance -> Menus) -->
            <nav class="footer-section-links" aria-label="<?php esc_attr_e( 'Navigation de pied de page', 'giapremix' ); ?>">
                <!-- Column 1 (Appearance -> Menus: Footer Column 1) -->
                <div>
                    <?php
                    if ( has_nav_menu( 'footer-1' ) ) {
                        wp_nav_menu( array(
                            'theme_location' => 'footer-1',
                            'container'      => false,
                            'depth'          => 2,
                            'items_wrap'     => '%3$s',
                            'walker'         => new Giapremix_Footer_Column_Walker(),
                        ) );
                    } else {
                        ?>
                        <h3><?php esc_html_e( 'Pour usage extérieur', 'giapremix' ); ?></h3>
                        <ul>
                            <li><a href="#produkter">Douche de sécurité à l'extérieur</a></li>
                            <li><a href="#produkter">Soins sous la douche</a></li>
                            <li><a href="#produkter">Douches de sécurité hors gel</a></li>
                            <li><a href="#produkter">Douches de sécurité isolées</a></li>
                        </ul>
                        <h3><?php esc_html_e( 'L’entreprise', 'giapremix' ); ?></h3>
                        <ul>
                            <li><a href="#dokument">Document</a></li>
                            <li><a href="#kontakt">Contactez-nous</a></li>
                            <li><a href="#magicad">Produits dans MagiCAD</a></li>
                            <li><a href="#finlande">GIA Prémélange Finlande</a></li>
                        </ul>
                        <?php
                    }
                    ?>
                </div>

                <!-- Column 2 (Appearance -> Menus: Footer Column 2) -->
                <div>
                    <?php
                    if ( has_nav_menu( 'footer-2' ) ) {
                        wp_nav_menu( array(
                            'theme_location' => 'footer-2',
                            'container'      => false,
                            'depth'          => 2,
                            'items_wrap'     => '%3$s',
                            'walker'         => new Giapremix_Footer_Column_Walker(),
                        ) );
                    } else {
                        ?>
                        <h3><?php esc_html_e( 'Douches de sécurité', 'giapremix' ); ?></h3>
                        <ul>
                            <li><a href="#produkter">Douches de sécurité combinées</a></li>
                            <li><a href="#produkter">Douchettes</a></li>
                            <li><a href="#produkter">Douches corporelles</a></li>
                            <li><a href="#produkter">Douches de sécurité pour laboratoire</a></li>
                        </ul>
                        <h3><?php esc_html_e( 'Accessoires', 'giapremix' ); ?></h3>
                        <ul>
                            <li><a href="#produkter">Mélangeur de protection</a></li>
                            <li><a href="#produkter">Accessoires de douche de secours</a></li>
                        </ul>
                        <?php
                    }
                    ?>
                </div>

                <!-- Column 3 (Appearance -> Menus: Footer Column 3) -->
                <div>
                    <?php
                    if ( has_nav_menu( 'footer-3' ) ) {
                        wp_nav_menu( array(
                            'theme_location' => 'footer-3',
                            'container'      => false,
                            'depth'          => 2,
                            'items_wrap'     => '%3$s',
                            'walker'         => new Giapremix_Footer_Column_Walker(),
                        ) );
                    } else {
                        ?>
                        <h3><?php esc_html_e( 'Yeux et visage', 'giapremix' ); ?></h3>
                        <ul>
                            <li><a href="#produkter">Douches oculaires et faciales</a></li>
                            <li><a href="#produkter">Spray oculaire</a></li>
                        </ul>
                        <?php
                    }
                    ?>
                    <div class="footer-section-socials" aria-label="<?php esc_attr_e( 'Réseaux sociaux', 'giapremix' ); ?>">
                        <?php if ( ! empty( $social_links ) && is_array( $social_links ) ) : ?>
                            <?php foreach ( $social_links as $social ) :
                                $url      = ! empty( $social['url'] ) ? $social['url'] : '';
                                $label    = ! empty( $social['label'] ) ? $social['label'] : 'Social';
                                $platform = ! empty( $social['platform'] ) ? strtolower( $social['platform'] ) : '';
                                $icon_img = ! empty( $social['icon_image'] ) ? $social['icon_image'] : null;

                                // Auto-detect platform if not explicitly set
                                if ( ! $platform ) {
                                    $search_str = strtolower( $label . ' ' . $url );
                                    if ( strpos( $search_str, 'facebook' ) !== false || strpos( $search_str, 'fb' ) !== false ) {
                                        $platform = 'facebook';
                                    } elseif ( strpos( $search_str, 'instagram' ) !== false || strpos( $search_str, 'insta' ) !== false ) {
                                        $platform = 'instagram';
                                    } elseif ( strpos( $search_str, 'linkedin' ) !== false ) {
                                        $platform = 'linkedin';
                                    } else {
                                        $platform = 'custom';
                                    }
                                }

                                // Inner icon markup
                                $inner_icon = '';
                                if ( ! empty( $icon_img['ID'] ) ) {
                                    $inner_icon = htnl_render_image( $icon_img, 'thumbnail', array( 'width' => 20, 'height' => 20, 'alt' => $label ) );
                                } elseif ( 'facebook' === $platform ) {
                                    $inner_icon = 'f';
                                } elseif ( 'instagram' === $platform ) {
                                    $inner_icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"></circle></svg>';
                                } elseif ( 'linkedin' === $platform ) {
                                    $inner_icon = 'in';
                                } else {
                                    $inner_icon = esc_html( mb_substr( $label, 0, 2 ) );
                                }

                                if ( ! empty( $url ) ) :
                                    ?>
                                    <a href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( $label ); ?>" target="_blank" rel="noopener noreferrer">
                                        <?php echo $inner_icon; ?>
                                    </a>
                                <?php else : ?>
                                    <span aria-label="<?php echo esc_attr( $label ); ?>">
                                        <?php echo $inner_icon; ?>
                                    </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <span aria-label="Facebook">f</span>
                            <span aria-label="Instagram">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"></circle></svg>
                            </span>
                            <span aria-label="LinkedIn">in</span>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="footer-section-bottom">
        <div class="container">
            <small><?php echo esc_html( $copyright ); ?></small>
            <div>
                <?php
                if ( has_nav_menu( 'footer-legal' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer-legal',
                        'container'      => false,
                        'depth'          => 1,
                        'items_wrap'     => '%3$s',
                        'walker'         => new Giapremix_Simple_Links_Walker(),
                    ) );
                } else {
                    ?>
                    <a href="#privacy"><?php esc_html_e( 'Politique de confidentialité', 'giapremix' ); ?></a>
                    <a href="#terms"><?php esc_html_e( 'Conditions générales', 'giapremix' ); ?></a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</footer>
