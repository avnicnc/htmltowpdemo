<?php
/**
 * Categories Section Component (Nos meilleures catégories)
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

// 1. Fetch Data
$section_id      = get_sub_field( 'section_id' );
$extra_class     = get_sub_field( 'extra_class' );
$title           = get_sub_field( 'title' );
$highlight       = get_sub_field( 'title_highlight' );
$title_tag       = get_sub_field( 'title_tag' );
$btn_text        = get_sub_field( 'button_text' );
$btn_url         = get_sub_field( 'button_url' );
$categories_list = get_sub_field( 'categories_list' );

$is_preview  = isset( $is_preview ) ? $is_preview : false;
$admin_class = $is_preview ? ' admin-preview' : '';

$tag         = ! empty( $title_tag ) ? $title_tag : 'h2';
$id_attr     = ! empty( $section_id ) ? ' id="' . esc_attr( $section_id ) . '"' : '';
$css_classes = trim( 'categories-section section-padding ' . $extra_class . $admin_class );

if ( empty( $title ) && empty( $categories_list ) ) {
    return;
}
?>

<section<?php echo $id_attr; ?> class="<?php echo esc_attr( $css_classes ); ?>" aria-labelledby="categories-title" lang="fr">
    <div class="container">
        <div class="categories-section-wrapper">
            <div class="categories-section-header flex-between">
                <<?php echo esc_attr( $tag ); ?> id="categories-title">
                    <?php echo esc_html( $title ); ?>
                    <?php if ( ! empty( $highlight ) ) : ?>
                        <span><?php echo esc_html( $highlight ); ?></span>
                    <?php endif; ?>
                </<?php echo esc_attr( $tag ); ?>>

                <?php if ( ! empty( $btn_text ) ) : ?>
                    <a class="btn btn-yellow" href="<?php echo esc_url( $btn_url ? $btn_url : '#produits' ); ?>">
                        <span><?php echo esc_html( $btn_text ); ?></span>
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-btn-triangle.svg' ); ?>" width="24" height="24" alt="" aria-hidden="true">
                    </a>
                <?php endif; ?>
            </div>

            <?php if ( ! empty( $categories_list ) && is_array( $categories_list ) ) : ?>
                <ul class="categories-section-grid">
                    <?php foreach ( $categories_list as $cat ) : 
                        $cat_img   = ! empty( $cat['image'] ) ? $cat['image'] : null;
                        $cat_label = ! empty( $cat['label'] ) ? $cat['label'] : '';
                        $cat_url   = ! empty( $cat['url'] ) ? $cat['url'] : '#';
                    ?>
                        <li class="categories-section-card flex-column flex-center flex-middle product-hover">
                            <a href="<?php echo esc_url( $cat_url ); ?>" style="color: inherit; text-decoration: none; display: flex; flex-direction: column; align-items: center; width: 100%;">
                                <div class="categories-section-media flex-center flex-middle product-hover-media">
                                    <?php if ( ! empty( $cat_img['ID'] ) ) : ?>
                                        <?php echo htnl_render_image( $cat_img, 'thumbnail', array( 'loading' => 'lazy', 'width' => 135, 'height' => 135, 'alt' => $cat_label ) ); ?>
                                    <?php endif; ?>
                                </div>
                                <?php if ( $cat_label ) : ?>
                                    <div class="categories-section-label">
                                        <p><?php echo esc_html( $cat_label ); ?></p>
                                    </div>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>
