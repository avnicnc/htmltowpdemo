<?php
/**
 * Header Template Part
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

// Topbar fields
$phone        = get_field( 'header_phone', 'option' );
$phone_link   = get_field( 'header_phone_link', 'option' );
$email        = get_field( 'header_email', 'option' );

// Main Nav & Logo
$logo_img          = get_field( 'header_logo', 'option' );
$search_placeholder= get_field( 'header_search_placeholder', 'option' );

// Mega Menu Banner
$megamenu_pill    = get_field( 'header_megamenu_pill', 'option' );
$megamenu_tagline = get_field( 'header_megamenu_tagline', 'option' );
$megamenu_btn_text= get_field( 'header_megamenu_btn_text', 'option' );
$megamenu_btn_url = get_field( 'header_megamenu_btn_url', 'option' );

// Fallbacks for empty option settings
if ( ! $phone ) {
    $phone = '0240-59 40 00';
    $phone_link = 'tel:0240-594000';
}
if ( ! $email ) {
    $email = 'info@giapremix.se';
}
if ( ! $search_placeholder ) {
    $search_placeholder = 'Rechercher des produits...';
}
?>

<header class="header-section">

    <!-- Top Bar -->
    <div class="header-section-topbar">
        <div class="container">
            <div class="header-section-topbar-wrapper">

                <!-- Left Links (Appearance -> Menus: Top Bar Links) -->
                <div class="header-section-topbar-links">
                    <?php
                    if ( has_nav_menu( 'topbar' ) ) {
                        wp_nav_menu( array(
                            'theme_location' => 'topbar',
                            'container'      => false,
                            'depth'          => 1,
                            'items_wrap'     => '%3$s',
                            'walker'         => new Giapremix_Topbar_Walker(),
                        ) );
                    } else {
                        ?>
                        <a href="#demande"><?php esc_html_e( 'Demande', 'giapremix' ); ?></a>
                        <span class="header-section-topbar-divider" aria-hidden="true"></span>
                        <a href="#centre-aide"><?php esc_html_e( "Centre d'aide", 'giapremix' ); ?></a>
                        <?php
                    }
                    ?>
                </div>

                <!-- Right Contact & Language -->
                <div class="header-section-topbar-contact">
                    <?php if ( $phone ) : ?>
                    <div class="header-section-topbar-item">
                        <span class="header-section-topbar-icon" aria-hidden="true">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/phone.svg' ); ?>" alt="" width="22" height="22">
                        </span>
                        <a href="<?php echo esc_url( $phone_link ? $phone_link : 'tel:' . preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
                    </div>
                    <?php endif; ?>

                    <?php if ( $email ) : ?>
                    <div class="header-section-topbar-item">
                        <span class="header-section-topbar-icon" aria-hidden="true">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/email.svg' ); ?>" alt="" width="22" height="22">
                        </span>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                    </div>
                    <?php endif; ?>

                    <!-- Language Switcher Component -->
                    <?php giapremix_language_switcher(); ?>

                </div>

            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <div class="header-section-navbar">
        <div class="container">
            <div class="header-section-navbar-wrapper">

                <!-- Brand Logo -->
                <div class="header-section-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'GIA Premix Startsida', 'htnl' ); ?>">
                        <?php if ( ! empty( $logo_img['ID'] ) ) : ?>
                            <?php echo htnl_render_image( $logo_img, 'full', array( 'alt' => get_bloginfo( 'name' ), 'width' => 285, 'height' => 39 ) ); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.svg' ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="285" height="39">
                        <?php endif; ?>
                    </a>
                </div>

                <!-- Desktop Main Navigation -->
                <nav class="header-section-nav" aria-label="<?php esc_attr_e( 'Huvudnavigation', 'htnl' ); ?>">
                    <!-- Products Mega Menu Trigger -->
                    <div class="header-section-nav-item" data-megamenu-item>
                        <button type="button" class="header-section-nav-link" data-megamenu-toggle aria-expanded="false" aria-haspopup="true">
                            <span><?php esc_html_e( 'Våra Produkter', 'htnl' ); ?></span>
                            <span class="header-section-nav-arrow" aria-hidden="true">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-down.svg' ); ?>" alt="" width="13" height="7">
                            </span>
                        </button>
                    </div>

                    <?php
                    if ( has_nav_menu( 'primary' ) ) {
                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'container'      => false,
                            'items_wrap'     => '%3$s',
                            'walker'         => new Htnl_Nav_Walker(),
                            'depth'          => 2,
                        ) );
                    } else {
                        ?>
                        <div class="header-section-nav-item"><a href="#foretaget" class="header-section-nav-link"><?php esc_html_e( 'Företaget', 'htnl' ); ?></a></div>
                        <div class="header-section-nav-item"><a href="#nyheter" class="header-section-nav-link"><?php esc_html_e( 'Nyheter', 'htnl' ); ?></a></div>
                        <div class="header-section-nav-item"><a href="#dokument" class="header-section-nav-link"><?php esc_html_e( 'Dokument', 'htnl' ); ?></a></div>
                        <div class="header-section-nav-item"><a href="#contact" class="header-section-nav-link"><?php esc_html_e( 'Contact', 'htnl' ); ?></a></div>
                        <?php
                    }
                    ?>
                </nav>

                <!-- Search Bar -->
                <div class="header-section-search">
                    <form class="header-section-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
                        <label for="desktop-search" class="sr-only"><?php esc_html_e( 'Rechercher des produits', 'htnl' ); ?></label>
                        <input type="search" id="desktop-search" name="s" class="header-section-search-input" placeholder="<?php echo esc_attr( $search_placeholder ); ?>" autocomplete="off">
                        <button type="submit" class="header-section-search-btn" aria-label="<?php esc_attr_e( 'Sök', 'htnl' ); ?>">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/search.svg' ); ?>" alt="" width="18" height="18">
                        </button>
                    </form>
                </div>

                <!-- Mobile Menu Hamburger Button -->
                <div class="header-section-mobile-language" data-mobile-language></div>
                <button type="button" class="header-section-toggle" data-mobile-toggle aria-label="<?php esc_attr_e( 'Växla mobilmeny', 'htnl' ); ?>" aria-expanded="false">
                    <span class="header-section-toggle-bar"></span>
                    <span class="header-section-toggle-bar"></span>
                    <span class="header-section-toggle-bar"></span>
                </button>

            </div>
        </div>

        <!-- Mega Menu Dropdown Panel -->
        <div class="header-section-megamenu" data-megamenu-panel role="region" aria-label="<?php esc_attr_e( 'Våra Produkter Megameny', 'htnl' ); ?>">
            <div class="header-section-megamenu-inner">

                <!-- 4 Category Columns (Appearance -> Menus: Mega Menu) -->
                <div class="header-section-megamenu-columns">

                    <?php
                    $megamenu_tree = array();
                    if ( has_nav_menu( 'megamenu' ) ) {
                        $locs = get_nav_menu_locations();
                        if ( ! empty( $locs['megamenu'] ) ) {
                            $raw_items = wp_get_nav_menu_items( $locs['megamenu'] );
                            if ( ! empty( $raw_items ) ) {
                                foreach ( $raw_items as $item ) {
                                    if ( 0 == $item->menu_item_parent ) {
                                        $megamenu_tree[ $item->ID ] = array(
                                            'item'     => $item,
                                            'children' => array(),
                                        );
                                    }
                                }
                                foreach ( $raw_items as $item ) {
                                    if ( $item->menu_item_parent && isset( $megamenu_tree[ $item->menu_item_parent ] ) ) {
                                        $megamenu_tree[ $item->menu_item_parent ]['children'][] = $item;
                                    }
                                }
                            }
                        }
                    }

                    $default_col_imgs = array(
                        'douches-exterieures.png',
                        'douches-securite.png',
                        'accessoires.png',
                        'yeux-visage.png',
                    );

                    if ( ! empty( $megamenu_tree ) ) :
                        $c_idx = 0;
                        foreach ( $megamenu_tree as $col ) :
                            if ( $c_idx > 0 ) :
                                ?>
                                <div class="header-section-megamenu-divider-v" aria-hidden="true"></div>
                                <?php
                            endif;
                            $col_img = isset( $default_col_imgs[ $c_idx ] ) ? $default_col_imgs[ $c_idx ] : 'douches-securite.png';
                            $custom_col_img = function_exists( 'get_field' ) ? get_field( 'menu_item_image', $col['item']->ID ) : null;
                            ?>
                            <div class="header-section-megamenu-col">
                                <a href="<?php echo esc_url( $col['item']->url ); ?>" class="header-section-megamenu-col-head">
                                    <h3><?php echo esc_html( $col['item']->title ); ?></h3>
                                    <span class="header-section-megamenu-col-arrow" aria-hidden="true">
                                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-right-stroke.svg' ); ?>" alt="" width="8" height="14">
                                    </span>
                                </a>
                                <?php if ( ! empty( $col['children'] ) ) : ?>
                                <div class="header-section-megamenu-list">
                                    <?php foreach ( $col['children'] as $child ) : ?>
                                        <a href="<?php echo esc_url( $child->url ); ?>"><?php echo esc_html( $child->title ); ?></a>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>

                                <div class="header-section-megamenu-image">
                                    <?php if ( ! empty( $custom_col_img['ID'] ) ) : ?>
                                        <?php echo htnl_render_image( $custom_col_img, 'medium', array( 'alt' => $col['item']->title, 'loading' => 'lazy' ) ); ?>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $col_img ); ?>" alt="<?php echo esc_attr( $col['item']->title ); ?>" loading="lazy">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php
                            $c_idx++;
                        endforeach;
                    else :
                        ?>
                        <!-- Default Static Fallback Columns -->
                        <div class="header-section-megamenu-col">
                            <a href="#douches-exterieures" class="header-section-megamenu-col-head">
                                <h3>Douches extérieures</h3>
                                <span class="header-section-megamenu-col-arrow" aria-hidden="true"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-right-stroke.svg' ); ?>" alt="" width="8" height="14"></span>
                            </a>
                            <div class="header-section-megamenu-list">
                                <a href="#douches-a-reservoir">Douches à réservoir</a>
                                <a href="#cabines-douche-securite">Cabines de douche de sécurité</a>
                                <a href="#douches-securite-antigel">Douches de sécurité antigel</a>
                                <a href="#douches-securite-isolees">Douches de sécurité isolées</a>
                            </div>
                            <div class="header-section-megamenu-image"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/douches-exterieures.png' ); ?>" alt="Douches extérieures" loading="lazy"></div>
                        </div>

                        <div class="header-section-megamenu-divider-v" aria-hidden="true"></div>

                        <div class="header-section-megamenu-col">
                            <a href="#douches-de-securite" class="header-section-megamenu-col-head">
                                <h3>Douches de sécurité</h3>
                                <span class="header-section-megamenu-col-arrow" aria-hidden="true"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-right-stroke.svg' ); ?>" alt="" width="8" height="14"></span>
                            </a>
                            <div class="header-section-megamenu-list">
                                <a href="#douches-combinees">Douches combinées</a>
                                <a href="#douchettes-a-main">Douchettes à main</a>
                                <a href="#douches-securite-corporelles">Douches de sécurité corporelles</a>
                                <a href="#douches-de-laboratoire">Douches de laboratoire</a>
                            </div>
                            <div class="header-section-megamenu-image"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/douches-securite.png' ); ?>" alt="Douches de sécurité" loading="lazy"></div>
                        </div>

                        <div class="header-section-megamenu-divider-v" aria-hidden="true"></div>

                        <div class="header-section-megamenu-col">
                            <a href="#accessoires" class="header-section-megamenu-col-head">
                                <h3>Accessoires</h3>
                                <span class="header-section-megamenu-col-arrow" aria-hidden="true"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-right-stroke.svg' ); ?>" alt="" width="8" height="14"></span>
                            </a>
                            <div class="header-section-megamenu-list">
                                <a href="#mitigeurs-de-securite">Mitigeurs de sécurité</a>
                                <a href="#pieces-detachees-accessoires">Pièces détachées et accessoires</a>
                            </div>
                            <div class="header-section-megamenu-image"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/accessoires.png' ); ?>" alt="Accessoires" loading="lazy"></div>
                        </div>

                        <div class="header-section-megamenu-divider-v" aria-hidden="true"></div>

                        <div class="header-section-megamenu-col">
                            <a href="#yeux-et-visage" class="header-section-megamenu-col-head">
                                <h3>Yeux et visage</h3>
                                <span class="header-section-megamenu-col-arrow" aria-hidden="true"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-right-stroke.svg' ); ?>" alt="" width="8" height="14"></span>
                            </a>
                            <div class="header-section-megamenu-list">
                                <a href="#douches-oculaires-faciales">Douches oculaires et faciales</a>
                                <a href="#spray-oculaire">Spray oculaire</a>
                            </div>
                            <div class="header-section-megamenu-image"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/yeux-visage.png' ); ?>" alt="Yeux et visage" loading="lazy"></div>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Horizontal Separator Line -->
                <div class="header-section-megamenu-divider-h" aria-hidden="true"></div>

                <!-- Bottom Bar -->
                <div class="header-section-megamenu-footer">
                    <div class="header-section-megamenu-footer-left">
                        <a href="<?php echo esc_url( $megamenu_btn_url ? $megamenu_btn_url : '#catalogue' ); ?>" class="header-section-megamenu-pill">
                            <?php echo esc_html( $megamenu_pill ? $megamenu_pill : 'CATALOGUE COMPLET' ); ?>
                        </a>
                        <p class="header-section-megamenu-tagline">
                            <?php echo esc_html( $megamenu_tagline ? $megamenu_tagline : "Découvrez notre gamme complète d'équipements de sécurité industrielle" ); ?>
                        </p>
                    </div>
                    <a href="<?php echo esc_url( $megamenu_btn_url ? $megamenu_btn_url : '#tous-les-produits' ); ?>" class="btn btn-yellow">
                        <span><?php echo esc_html( $megamenu_btn_text ? $megamenu_btn_text : 'Voir tous les produits' ); ?></span>
                        <span class="btn-icon" aria-hidden="true">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/btn-triangle.svg' ); ?>" alt="" width="14" height="12">
                        </span>
                    </a>
                </div>

            </div>
        </div>

    </div>

    <!-- Mobile Navigation Drawer -->
    <div class="header-section-mobile-drawer" data-mobile-drawer role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Mobilmeny', 'htnl' ); ?>">
        <!-- Mobile Drawer Header -->
        <div class="header-section-mobile-header">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'GIA Premix Startsida', 'htnl' ); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.svg' ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="200" height="28">
            </a>
            <button type="button" class="header-section-mobile-close" data-mobile-close aria-label="<?php esc_attr_e( 'Stäng meny', 'htnl' ); ?>">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <!-- Mobile Drawer Body -->
        <div class="header-section-mobile-body">
            <!-- Mobile Search Form -->
            <div class="header-section-mobile-search">
                <form class="header-section-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
                    <label for="mobile-search" class="sr-only"><?php esc_html_e( 'Rechercher', 'htnl' ); ?></label>
                    <input type="search" id="mobile-search" name="s" class="header-section-search-input" placeholder="<?php echo esc_attr( $search_placeholder ); ?>">
                    <button type="submit" class="header-section-search-btn" aria-label="<?php esc_attr_e( 'Sök', 'htnl' ); ?>">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/search.svg' ); ?>" alt="" width="18" height="18">
                    </button>
                </form>
            </div>

            <!-- Mobile Navigation List -->
            <nav class="header-section-mobile-nav" aria-label="<?php esc_attr_e( 'Mobil navigation', 'giapremix' ); ?>">
                <div class="header-section-mobile-accordion-item">
                    <button type="button" class="header-section-mobile-nav-link header-section-mobile-accordion-btn" data-mobile-accordion-btn aria-expanded="false">
                        <span><?php esc_html_e( 'Våra Produkter', 'giapremix' ); ?></span>
                        <span class="header-section-nav-arrow" aria-hidden="true">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-down.svg' ); ?>" alt="" width="13" height="7">
                        </span>
                    </button>
                    <div class="header-section-mobile-accordion-content">
                        <div class="header-section-mobile-accordion-list">
                            <?php if ( ! empty( $megamenu_tree ) ) : ?>
                                <?php foreach ( $megamenu_tree as $col ) : ?>
                                    <strong style="padding: 10px 0 6px 0; font-size: var(--font-size-sm); color: var(--color-primary); text-transform: uppercase;">
                                        <?php echo esc_html( $col['item']->title ); ?>
                                    </strong>
                                    <?php if ( ! empty( $col['children'] ) ) : ?>
                                        <?php foreach ( $col['children'] as $child ) : ?>
                                            <a href="<?php echo esc_url( $child->url ); ?>"><?php echo esc_html( $child->title ); ?></a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <strong style="padding: 6px 0; font-size: var(--font-size-sm); color: var(--color-primary); text-transform: uppercase;">Douches extérieures</strong>
                                <a href="#douches-a-reservoir">Douches à réservoir</a>
                                <a href="#cabines-douche-securite">Cabines de douche de sécurité</a>
                                <a href="#douches-securite-antigel">Douches de sécurité antigel</a>
                                <a href="#douches-securite-isolees">Douches de sécurité isolées</a>

                                <strong style="padding: 10px 0 6px 0; font-size: var(--font-size-sm); color: var(--color-primary); text-transform: uppercase;">Douches de sécurité</strong>
                                <a href="#douches-combinees">Douches combinées</a>
                                <a href="#douchettes-a-main">Douchettes à main</a>
                                <a href="#douches-securite-corporelles">Douches de sécurité corporelles</a>
                                <a href="#douches-de-laboratoire">Douches de laboratoire</a>

                                <strong style="padding: 10px 0 6px 0; font-size: var(--font-size-sm); color: var(--color-primary); text-transform: uppercase;">Accessoires</strong>
                                <a href="#mitigeurs-de-securite">Mitigeurs de sécurité</a>
                                <a href="#pieces-detachees-accessoires">Pièces détachées et accessoires</a>

                                <strong style="padding: 10px 0 6px 0; font-size: var(--font-size-sm); color: var(--color-primary); text-transform: uppercase;">Yeux et visage</strong>
                                <a href="#douches-oculaires-faciales">Douches oculaires et faciales</a>
                                <a href="#spray-oculaire">Spray oculaire</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'depth'          => 1,
                        'items_wrap'     => '%3$s',
                        'walker'         => new Giapremix_Nav_Walker(),
                    ) );
                } else {
                    ?>
                    <a href="#foretaget" class="header-section-mobile-nav-link">Företaget</a>
                    <a href="#nyheter" class="header-section-mobile-nav-link">Nyheter</a>
                    <a href="#dokument" class="header-section-mobile-nav-link">Dokument</a>
                    <a href="#contact" class="header-section-mobile-nav-link">Contact</a>
                    <?php
                }
                ?>
            </nav>
        </div>

        <!-- Mobile Drawer Footer Contact -->
        <div class="header-section-mobile-contact">
            <?php if ( $phone ) : ?>
            <a href="<?php echo esc_url( $phone_link ? $phone_link : 'tel:' . preg_replace( '/\s+/', '', $phone ) ); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/phone.svg' ); ?>" alt="" width="22" height="22">
                <span><?php echo esc_html( $phone ); ?></span>
            </a>
            <?php endif; ?>

            <?php if ( $email ) : ?>
            <a href="mailto:<?php echo esc_attr( $email ); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/email.svg' ); ?>" alt="" width="22" height="22">
                <span><?php echo esc_html( $email ); ?></span>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Mobile Drawer Backdrop -->
    <div class="header-section-mobile-backdrop" data-mobile-backdrop aria-hidden="true"></div>

</header>
