<?php
/**
 * News Section Component (Latest news & updates)
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

// 1. Fetch Data
$section_id  = get_sub_field( 'section_id' );
$extra_class = get_sub_field( 'extra_class' );
$title       = get_sub_field( 'title' );
$highlight   = get_sub_field( 'title_highlight' );
$title_tag   = get_sub_field( 'title_tag' );
$btn_text    = get_sub_field( 'button_text' );
$btn_url     = get_sub_field( 'button_url' );
$news_list   = get_sub_field( 'news_list' );

$is_preview  = isset( $is_preview ) ? $is_preview : false;
$admin_class = $is_preview ? ' admin-preview' : '';

$tag         = ! empty( $title_tag ) ? $title_tag : 'h2';
$id_attr     = ! empty( $section_id ) ? ' id="' . esc_attr( $section_id ) . '"' : '';
$css_classes = trim( 'latest-news-section ' . $extra_class . $admin_class );

if ( empty( $title ) && empty( $news_list ) ) {
    return;
}
?>

<section<?php echo $id_attr; ?> class="<?php echo esc_attr( $css_classes ); ?>" aria-labelledby="latest-news-title" lang="fr">
    <div class="container">
        <div class="latest-news-section-header">
            <<?php echo esc_attr( $tag ); ?> id="latest-news-title" class="latest-news-section-title">
                <?php echo esc_html( $title ); ?>
                <?php if ( ! empty( $highlight ) ) : ?>
                    <span><?php echo esc_html( $highlight ); ?></span>
                <?php endif; ?>
            </<?php echo esc_attr( $tag ); ?>>

            <?php if ( ! empty( $btn_text ) ) : ?>
                <a class="btn btn-yellow" href="<?php echo esc_url( $btn_url ? $btn_url : '#news' ); ?>">
                    <span><?php echo esc_html( $btn_text ); ?></span>
                    <span class="btn-icon" aria-hidden="true">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-btn-triangle.svg' ); ?>" alt="" width="14" height="10">
                    </span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if ( ! empty( $news_list ) && is_array( $news_list ) ) : ?>
        <div class="latest-news-section-slider-wrapper has-scroll-right">
            <div class="latest-news-section-track" tabindex="0" role="region" aria-label="<?php esc_attr_e( 'Dernières nouvelles et mises à jour', 'htnl' ); ?>">
                <?php foreach ( $news_list as $item ) : 
                    $card_img    = ! empty( $item['image'] ) ? $item['image'] : null;
                    $card_cat    = ! empty( $item['category'] ) ? $item['category'] : '';
                    $card_date   = ! empty( $item['date'] ) ? $item['date'] : '';
                    $card_title  = ! empty( $item['title'] ) ? $item['title'] : '';
                    $card_desc   = ! empty( $item['excerpt'] ) ? $item['excerpt'] : '';
                    $card_url    = ! empty( $item['url'] ) ? $item['url'] : '#';
                ?>
                    <article class="latest-news-section-card">
                        <a class="latest-news-section-card-link" href="<?php echo esc_url( $card_url ); ?>">
                            <div class="latest-news-section-media">
                                <?php if ( ! empty( $card_img['ID'] ) ) : ?>
                                    <?php echo htnl_render_image( $card_img, 'medium', array( 'loading' => 'lazy', 'alt' => $card_title ) ); ?>
                                <?php endif; ?>

                                <?php if ( $card_cat ) : ?>
                                    <span class="latest-news-section-category"><?php echo esc_html( $card_cat ); ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="latest-news-section-content">
                                <?php if ( $card_date ) : ?>
                                    <div class="latest-news-section-meta">
                                        <time><?php echo esc_html( $card_date ); ?></time>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $card_title ) : ?>
                                    <h3><?php echo nl2br( esc_html( $card_title ) ); ?></h3>
                                <?php endif; ?>

                                <?php if ( $card_desc ) : ?>
                                    <p><?php echo esc_html( $card_desc ); ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="latest-news-section-fade-right" aria-hidden="true"></div>
        </div>

        <div class="container">
            <div class="latest-news-section-controls">
                <div class="latest-news-section-progress" aria-hidden="true">
                    <div class="latest-news-section-progress-thumb"></div>
                </div>
                <div class="latest-news-section-nav" role="toolbar" aria-label="<?php esc_attr_e( 'Commandes du carrousel d’actualités', 'htnl' ); ?>">
                    <button type="button" class="latest-news-section-nav-btn is-prev" data-news-prev aria-label="<?php esc_attr_e( 'Actualités précédentes', 'htnl' ); ?>" disabled>
                        <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M7.7 1.5L1.8 7.4C1.4 7.8 1.4 8.4 1.8 8.8L7.7 14.7C8.1 15.1 8.7 15.1 9.1 14.7C9.5 14.3 9.5 13.7 9.1 13.3L3.9 8.1L9.1 2.9C9.5 2.5 9.5 1.9 9.1 1.5C8.7 1.1 8.1 1.1 7.7 1.5Z" fill="currentColor"/>
                        </svg>
                    </button>
                    <button type="button" class="latest-news-section-nav-btn is-next" data-news-next aria-label="<?php esc_attr_e( 'Actualités suivantes', 'htnl' ); ?>">
                        <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M7.7 1.5L1.8 7.4C1.4 7.8 1.4 8.4 1.8 8.8L7.7 14.7C8.1 15.1 8.7 15.1 9.1 14.7C9.5 14.3 9.5 13.7 9.1 13.3L3.9 8.1L9.1 2.9C9.5 2.5 9.5 1.9 9.1 1.5C8.7 1.1 8.1 1.1 7.7 1.5Z" fill="currentColor"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
