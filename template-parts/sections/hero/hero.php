<?php
/**
 * Hero Section Component
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

// 1. Fetch Data
$section_id  = get_sub_field( 'section_id' );
$extra_class = get_sub_field( 'extra_class' );
$slides      = get_sub_field( 'slides' );

$is_preview  = isset( $is_preview ) ? $is_preview : false;
$admin_class = $is_preview ? ' admin-preview' : '';

$id_attr = ! empty( $section_id ) ? ' id="' . esc_attr( $section_id ) . '"' : '';
$css_classes = trim( 'hero-section ' . $extra_class . $admin_class );

if ( empty( $slides ) || ! is_array( $slides ) ) {
    return;
}
?>

<section<?php echo $id_attr; ?> class="<?php echo esc_attr( $css_classes ); ?>" aria-label="<?php esc_attr_e( 'Hero Banner', 'htnl' ); ?>">
    <div class="hero-section-slider">
        <?php foreach ( $slides as $i => $slide ) : 
            $is_active = ( 0 === $i );
            $slide_class = 'hero-section-slide' . ( $is_active ? ' is-active' : '' ) . ( ! empty( $slide['is_dark_variant'] ) ? ' hero-section-slide-dark' : '' );
            $bg_image    = ! empty( $slide['background_image'] ) ? $slide['background_image'] : null;
            $heading     = ! empty( $slide['heading'] ) ? $slide['heading'] : '';
            $highlight   = ! empty( $slide['heading_highlight'] ) ? $slide['heading_highlight'] : '';
            $tag         = ! empty( $slide['heading_tag'] ) ? $slide['heading_tag'] : 'h1';
            $description = ! empty( $slide['description'] ) ? $slide['description'] : '';
            $btn1_text   = ! empty( $slide['button_1_text'] ) ? $slide['button_1_text'] : '';
            $btn1_url    = ! empty( $slide['button_1_url'] ) ? $slide['button_1_url'] : '';
            $btn2_text   = ! empty( $slide['button_2_text'] ) ? $slide['button_2_text'] : '';
            $btn2_url    = ! empty( $slide['button_2_url'] ) ? $slide['button_2_url'] : '';
            $standards   = ! empty( $slide['standards'] ) && is_array( $slide['standards'] ) ? $slide['standards'] : array();
        ?>
            <div class="<?php echo esc_attr( $slide_class ); ?>" data-hero-slide aria-hidden="<?php echo $is_active ? 'false' : 'true'; ?>">
                <div class="hero-section-bg">
                    <?php if ( ! empty( $bg_image['ID'] ) ) : ?>
                        <?php echo htnl_render_image( $bg_image, 'full', array( 'loading' => $is_active ? 'eager' : 'lazy', 'alt' => $heading ) ); ?>
                    <?php endif; ?>
                    <div class="hero-section-bg-overlay"></div>
                </div>

                <div class="container hero-section-container">
                    <div class="hero-section-content">
                        <div class="hero-section-text">
                            <div class="hero-section-title">
                                <?php if ( $heading ) : ?>
                                    <<?php echo esc_attr( $tag ); ?>>
                                        <?php echo nl2br( esc_html( $heading ) ); ?>
                                        <?php if ( $highlight ) : ?>
                                            <span class="hero-section-title-highlight"><?php echo esc_html( $highlight ); ?></span>
                                        <?php endif; ?>
                                    </<?php echo esc_attr( $tag ); ?>>
                                <?php endif; ?>
                            </div>

                            <?php if ( $description ) : ?>
                                <div class="hero-section-desc">
                                    <p><?php echo esc_html( $description ); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ( $btn1_text || $btn2_text ) : ?>
                            <div class="hero-section-actions">
                                <?php if ( $btn1_text ) : ?>
                                    <a href="<?php echo esc_url( $btn1_url ? $btn1_url : '#' ); ?>" class="btn btn-yellow">
                                        <span><?php echo esc_html( $btn1_text ); ?></span>
                                        <span class="btn-icon" aria-hidden="true">
                                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/btn-triangle.svg' ); ?>" alt="" width="14" height="12">
                                        </span>
                                    </a>
                                <?php endif; ?>

                                <?php if ( $btn2_text ) : ?>
                                    <a href="<?php echo esc_url( $btn2_url ? $btn2_url : '#' ); ?>" class="btn btn-white">
                                        <span><?php echo esc_html( $btn2_text ); ?></span>
                                        <span class="btn-icon" aria-hidden="true">
                                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/btn-triangle-yellow.svg' ); ?>" alt="" width="14" height="12">
                                        </span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $standards ) ) : ?>
                            <div class="hero-section-standards">
                                <?php foreach ( $standards as $std_idx => $std ) : ?>
                                    <?php if ( $std_idx > 0 ) : ?>
                                        <div class="hero-section-standard-divider" aria-hidden="true"></div>
                                    <?php endif; ?>
                                    <div class="hero-section-standard-item">
                                        <?php if ( ! empty( $std['icon']['ID'] ) ) : ?>
                                            <span class="hero-section-standard-icon">
                                                <?php echo htnl_render_image( $std['icon'], 'thumbnail', array( 'width' => 35, 'height' => 35 ) ); ?>
                                            </span>
                                        <?php endif; ?>
                                        <div class="hero-section-standard-text">
                                            <?php if ( ! empty( $std['code'] ) ) : ?>
                                                <span class="hero-section-standard-code"><?php echo esc_html( $std['code'] ); ?></span>
                                            <?php endif; ?>
                                            <?php if ( ! empty( $std['description'] ) ) : ?>
                                                <span class="hero-section-standard-desc"><?php echo esc_html( $std['description'] ); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ( count( $slides ) > 1 ) : ?>
        <div class="hero-section-controls">
            <div class="container">
                <div class="hero-section-pagination" role="tablist" aria-label="<?php esc_attr_e( 'Slider navigation', 'htnl' ); ?>">
                    <?php foreach ( $slides as $i => $slide ) : ?>
                        <button type="button" class="hero-section-dot<?php echo ( 0 === $i ) ? ' is-active' : ''; ?>" data-hero-dot role="tab" aria-selected="<?php echo ( 0 === $i ) ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Slide %d', 'htnl' ), $i + 1 ) ); ?>"></button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
