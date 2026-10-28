<?php
/**
 * Products Section Component (Carrousel de solutions de sécurité industrielle)
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

// 1. Fetch Data
$section_id    = get_sub_field( 'section_id' );
$extra_class   = get_sub_field( 'extra_class' );
$title         = get_sub_field( 'title' );
$highlight     = get_sub_field( 'title_highlight' );
$title_tag     = get_sub_field( 'title_tag' );
$btn_text      = get_sub_field( 'button_text' );
$btn_url       = get_sub_field( 'button_url' );
$products_list = get_sub_field( 'products_list' );

$is_preview  = isset( $is_preview ) ? $is_preview : false;
$admin_class = $is_preview ? ' admin-preview' : '';

$tag         = ! empty( $title_tag ) ? $title_tag : 'h2';
$id_attr     = ! empty( $section_id ) ? ' id="' . esc_attr( $section_id ) . '"' : ' id="produits"';
$css_classes = trim( 'products-section ' . $extra_class . $admin_class );

if ( empty( $title ) && empty( $products_list ) ) {
    return;
}
?>

<section<?php echo $id_attr; ?> class="<?php echo esc_attr( $css_classes ); ?>" aria-label="<?php echo esc_attr( $title ); ?>">
    <div class="container">
        <!-- Top Content Header -->
        <div class="products-section-header">
            <<?php echo esc_attr( $tag ); ?> class="products-section-title">
                <?php echo esc_html( $title ); ?>
                <?php if ( ! empty( $highlight ) ) : ?>
                    <span class="products-section-title-highlight"><?php echo esc_html( $highlight ); ?></span>
                <?php endif; ?>
            </<?php echo esc_attr( $tag ); ?>>

            <?php if ( ! empty( $btn_text ) ) : ?>
                <a href="<?php echo esc_url( $btn_url ? $btn_url : '#tous-les-produits' ); ?>" class="btn btn-yellow">
                    <span><?php echo esc_html( $btn_text ); ?></span>
                    <span class="btn-icon" aria-hidden="true">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-btn-triangle.svg' ); ?>" alt="" width="14" height="10">
                    </span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Product Carousel Slider -->
    <?php if ( ! empty( $products_list ) && is_array( $products_list ) ) : ?>
        <div class="products-section-slider-wrapper has-scroll-right">
            <div class="products-section-track" tabindex="0" role="region" aria-label="<?php esc_attr_e( 'Carrousel des produits de sécurité', 'htnl' ); ?>">
                <?php foreach ( $products_list as $idx => $prod ) : 
                    $card_class = 'products-section-card' . ( ! empty( $prod['is_active'] ) ? ' is-active' : '' );
                    $card_title = ! empty( $prod['title'] ) ? $prod['title'] : '';
                    $card_img   = ! empty( $prod['image'] ) ? $prod['image'] : null;
                    $detail_img = ! empty( $prod['detail_image'] ) ? $prod['detail_image'] : $card_img;
                    $detail_url = $detail_img ? htnl_get_image_url( $detail_img, 'large' ) : '';
                ?>
                    <article class="<?php echo esc_attr( $card_class ); ?>">
                        <div class="products-section-card-image-wrap">
                            <?php if ( ! empty( $card_img['ID'] ) ) : ?>
                                <?php echo htnl_render_image( $card_img, 'medium', array( 'class' => 'products-section-card-img', 'loading' => 'lazy', 'alt' => $card_title ) ); ?>
                            <?php endif; ?>

                            <button type="button" class="products-section-card-action" data-modal-open data-product-img="<?php echo esc_url( $detail_url ); ?>" data-product-title="<?php echo esc_attr( $card_title ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Aperçu rapide: %s', 'htnl' ), $card_title ) ); ?>">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <g transform="translate(0, 4.35165)">
                                        <path d="M23.8475 7.18155C23.6331 6.88825 18.5245 0 11.9999 0C5.47529 0 0.366469 6.88825 0.152297 7.18126C-0.0507657 7.45952 -0.0507657 7.83691 0.152297 8.11516C0.366469 8.40845 5.47529 15.2967 11.9999 15.2967C18.5245 15.2967 23.6331 8.40841 23.8475 8.11539C24.0508 7.83719 24.0508 7.45951 23.8475 7.18155ZM11.9999 13.7143C7.19383 13.7143 3.03127 9.14243 1.79907 7.64781C3.02968 6.15189 7.18351 1.58241 11.9999 1.58241C16.8057 1.58241 20.968 6.15348 22.2007 7.64889C20.9701 9.14477 16.8162 13.7143 11.9999 13.7143Z" fill="currentColor"/>
                                        <path transform="translate(7.2527, 2.901)" d="M4.74727 0C2.12968 0 0 2.12968 0 4.74727C0 7.36487 2.12968 9.49455 4.74727 9.49455C7.36487 9.49455 9.49455 7.36487 9.49455 4.74727C9.49455 2.12968 7.36487 0 4.74727 0ZM4.74727 7.91209C3.00211 7.91209 1.58246 6.49239 1.58246 4.74727C1.58246 3.00216 3.00216 1.58246 4.74727 1.58246C6.49239 1.58246 7.91209 3.00216 7.91209 4.74727C7.91209 6.49239 6.49243 7.91209 4.74727 7.91209Z" fill="currentColor"/>
                                    </g>
                                </svg>
                            </button>
                        </div>
                        <?php if ( $card_title ) : ?>
                            <h3 class="products-section-card-title"><?php echo esc_html( $card_title ); ?></h3>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Right edge fade gradient mask -->
            <div class="products-section-fade-right" aria-hidden="true"></div>
        </div>

        <!-- Controls -->
        <div class="container">
            <div class="products-section-controls">
                <div class="products-section-progress" aria-hidden="true">
                    <div class="products-section-progress-thumb"></div>
                </div>

                <div class="products-section-nav" role="toolbar" aria-label="<?php esc_attr_e( 'Contrôles du carrousel', 'htnl' ); ?>">
                    <button type="button" class="products-section-nav-btn is-prev" data-products-prev aria-label="<?php esc_attr_e( 'Produits précédents', 'htnl' ); ?>" disabled>
                        <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M7.7 1.5L1.8 7.4C1.4 7.8 1.4 8.4 1.8 8.8L7.7 14.7C8.1 15.1 8.7 15.1 9.1 14.7C9.5 14.3 9.5 13.7 9.1 13.3L3.9 8.1L9.1 2.9C9.5 2.5 9.5 1.9 9.1 1.5C8.7 1.1 8.1 1.1 7.7 1.5Z" fill="currentColor"/>
                        </svg>
                    </button>
                    <button type="button" class="products-section-nav-btn is-next" data-products-next aria-label="<?php esc_attr_e( 'Produits suivants', 'htnl' ); ?>">
                        <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M7.7 1.5L1.8 7.4C1.4 7.8 1.4 8.4 1.8 8.8L7.7 14.7C8.1 15.1 8.7 15.1 9.1 14.7C9.5 14.3 9.5 13.7 9.1 13.3L3.9 8.1L9.1 2.9C9.5 2.5 9.5 1.9 9.1 1.5C8.7 1.1 8.1 1.1 7.7 1.5Z" fill="currentColor"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Product Quick View Modal -->
        <div class="products-modal" id="product-quickview-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="products-modal-title">
            <div class="products-modal-backdrop" data-modal-close></div>
            <div class="products-modal-dialog">
                <button type="button" class="products-modal-close" data-modal-close aria-label="<?php esc_attr_e( 'Fermer la vue rapide', 'htnl' ); ?>">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/modal-close.svg' ); ?>" alt="" width="50" height="50">
                </button>
                <div class="products-modal-body">
                    <div class="products-modal-img-wrap">
                        <img src="" alt="<?php esc_attr_e( 'Aperçu du produit', 'htnl' ); ?>" class="products-modal-img" id="products-modal-image">
                    </div>
                    <h3 class="products-modal-title sr-only" id="products-modal-title"><?php esc_html_e( 'Aperçu du produit', 'htnl' ); ?></h3>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
