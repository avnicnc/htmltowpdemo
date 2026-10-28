<?php
/**
 * FAQ Section Component
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
$description = get_sub_field( 'description' );
$btn_text    = get_sub_field( 'button_text' );
$btn_url     = get_sub_field( 'button_url' );
$faq_list    = get_sub_field( 'faq_list' );

$is_preview  = isset( $is_preview ) ? $is_preview : false;
$admin_class = $is_preview ? ' admin-preview' : '';

$tag         = ! empty( $title_tag ) ? $title_tag : 'h2';
$id_attr     = ! empty( $section_id ) ? ' id="' . esc_attr( $section_id ) . '"' : '';
$css_classes = trim( 'faq-section ' . $extra_class . $admin_class );

if ( empty( $title ) && empty( $faq_list ) ) {
    return;
}
?>

<section<?php echo $id_attr; ?> class="<?php echo esc_attr( $css_classes ); ?>" aria-labelledby="faq-title" lang="fr">
    <div class="container faq-section-layout">
        <div class="faq-section-intro">
            <<?php echo esc_attr( $tag ); ?> id="faq-title">
                <?php echo nl2br( esc_html( $title ) ); ?>
                <?php if ( ! empty( $highlight ) ) : ?>
                    <span><?php echo esc_html( $highlight ); ?></span>
                <?php endif; ?>
            </<?php echo esc_attr( $tag ); ?>>

            <?php if ( ! empty( $description ) ) : ?>
                <p><?php echo esc_html( $description ); ?></p>
            <?php endif; ?>

            <?php if ( ! empty( $btn_text ) ) : ?>
                <a class="btn btn-yellow" href="<?php echo esc_url( $btn_url ? $btn_url : '#kontakt' ); ?>">
                    <span><?php echo esc_html( $btn_text ); ?></span>
                    <img class="faq-section-contact-icon" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/btn-triangle.svg' ); ?>" width="24" height="24" alt="" aria-hidden="true">
                </a>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $faq_list ) && is_array( $faq_list ) ) : ?>
            <div class="faq-section-list">
                <?php foreach ( $faq_list as $i => $faq ) : 
                    $num     = ! empty( $faq['number'] ) ? $faq['number'] : sprintf( '%02d', $i + 1 );
                    $q       = ! empty( $faq['question'] ) ? $faq['question'] : '';
                    $a       = ! empty( $faq['answer'] ) ? $faq['answer'] : '';
                    $is_open = ! empty( $faq['is_open'] ) || ( 0 === $i );
                ?>
                    <details class="faq-section-item" name="safety-faq"<?php echo $is_open ? ' open' : ''; ?>>
                        <summary>
                            <span class="faq-section-number"><?php echo esc_html( $num ); ?></span>
                            <span><?php echo esc_html( $q ); ?></span>
                            <span class="faq-section-chevron" aria-hidden="true"></span>
                        </summary>
                        <div class="faq-section-answer">
                            <?php echo wp_kses_post( wpautop( $a ) ); ?>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
