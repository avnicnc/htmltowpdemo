<?php
/**
 * Information Section Component (Information shortcuts)
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

// 1. Fetch Data
$section_id  = get_sub_field( 'section_id' );
$extra_class = get_sub_field( 'extra_class' );
$title       = get_sub_field( 'title' );
$title_tag   = get_sub_field( 'title_tag' );
$description = get_sub_field( 'description' );
$shortcuts   = get_sub_field( 'shortcuts' );

$is_preview  = isset( $is_preview ) ? $is_preview : false;
$admin_class = $is_preview ? ' admin-preview' : '';

$tag         = ! empty( $title_tag ) ? $title_tag : 'h2';
$id_attr     = ! empty( $section_id ) ? ' id="' . esc_attr( $section_id ) . '"' : '';
$css_classes = trim( 'information-section ' . $extra_class . $admin_class );

if ( empty( $title ) && empty( $shortcuts ) ) {
    return;
}
?>

<section<?php echo $id_attr; ?> class="<?php echo esc_attr( $css_classes ); ?>" aria-labelledby="information-title" lang="fr">
    <div class="container">
        <div class="information-section-shell">
            <div class="information-section-intro">
                <<?php echo esc_attr( $tag ); ?> id="information-title"><?php echo nl2br( esc_html( $title ) ); ?></<?php echo esc_attr( $tag ); ?>>
                <?php if ( ! empty( $description ) ) : ?>
                    <p><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>
            </div>

            <?php if ( ! empty( $shortcuts ) && is_array( $shortcuts ) ) : ?>
                <div class="information-section-grid">
                    <?php foreach ( $shortcuts as $item ) : 
                        $icon  = ! empty( $item['icon'] ) ? $item['icon'] : null;
                        $stitle= ! empty( $item['title'] ) ? $item['title'] : '';
                        $sub   = ! empty( $item['subtitle'] ) ? $item['subtitle'] : '';
                        $url   = ! empty( $item['url'] ) ? $item['url'] : '#';
                    ?>
                        <a class="information-section-card" href="<?php echo esc_url( $url ); ?>">
                            <?php if ( ! empty( $icon['ID'] ) ) : ?>
                                <span class="information-section-icon">
                                    <?php echo htnl_render_image( $icon, 'thumbnail', array( 'width' => 24, 'height' => 24, 'aria-hidden' => 'true' ) ); ?>
                                </span>
                            <?php endif; ?>

                            <span class="information-section-card-copy">
                                <?php if ( $stitle ) : ?>
                                    <strong><?php echo esc_html( $stitle ); ?></strong>
                                <?php endif; ?>
                                <?php if ( $sub ) : ?>
                                    <small><?php echo esc_html( $sub ); ?></small>
                                <?php endif; ?>
                            </span>

                            <img class="information-section-arrow" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-right-stroke.svg' ); ?>" alt="" width="8" height="14" aria-hidden="true">
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
