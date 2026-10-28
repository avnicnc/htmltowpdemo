<?php
/**
 * Expertise Section Component (GIA Premix expertise / hazardous environments)
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

// 1. Fetch Data
$section_id  = get_sub_field( 'section_id' );
$extra_class = get_sub_field( 'extra_class' );
$image       = get_sub_field( 'image' );
$title       = get_sub_field( 'title' );
$highlight   = get_sub_field( 'title_highlight' );
$title_tag   = get_sub_field( 'title_tag' );
$description = get_sub_field( 'description' );
$btn_text    = get_sub_field( 'button_text' );
$btn_url     = get_sub_field( 'button_url' );

$is_preview  = isset( $is_preview ) ? $is_preview : false;
$admin_class = $is_preview ? ' admin-preview' : '';

$tag         = ! empty( $title_tag ) ? $title_tag : 'h2';
$id_attr     = ! empty( $section_id ) ? ' id="' . esc_attr( $section_id ) . '"' : '';
$css_classes = trim( 'about-expertise-section ' . $extra_class . $admin_class );

if ( empty( $title ) && empty( $image ) ) {
    return;
}
?>

<section<?php echo $id_attr; ?> class="<?php echo esc_attr( $css_classes ); ?>" aria-labelledby="about-expertise-title" lang="fr">
    <div class="container">
        <div class="about-expertise-section-panel">
            <div class="about-expertise-section-media">
                <?php if ( ! empty( $image['ID'] ) ) : ?>
                    <?php echo htnl_render_image( $image, 'large', array( 'loading' => 'lazy', 'alt' => $title ) ); ?>
                <?php endif; ?>
            </div>

            <div class="about-expertise-section-content">
                <<?php echo esc_attr( $tag ); ?> id="about-expertise-title">
                    <?php echo esc_html( $title ); ?>
                    <?php if ( ! empty( $highlight ) ) : ?>
                        <span><?php echo esc_html( $highlight ); ?></span>
                    <?php endif; ?>
                </<?php echo esc_attr( $tag ); ?>>

                <?php if ( ! empty( $description ) ) : ?>
                    <div class="about-expertise-section-copy">
                        <?php echo wp_kses_post( wpautop( $description ) ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $btn_text ) ) : ?>
                    <a class="btn btn-yellow" href="<?php echo esc_url( $btn_url ? $btn_url : '#produits' ); ?>">
                        <span><?php echo esc_html( $btn_text ); ?></span>
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-btn-triangle.svg' ); ?>" alt="" width="18" height="15" aria-hidden="true">
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
