<?php
/**
 * Template part for displaying results in search pages
 *
 * @package giapremix
 */

defined( 'ABSPATH' ) || exit;

$post_type = get_post_type();
$post_type_label = ( 'page' === $post_type ) ? __( 'Page', 'giapremix' ) : __( 'Article', 'giapremix' );
$thumb = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result-card' ); ?>>
    <?php if ( $thumb ) : ?>
        <a href="<?php the_permalink(); ?>" class="search-result-thumb" tabindex="-1" aria-hidden="true">
            <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
        </a>
    <?php endif; ?>

    <div class="search-result-content">
        <div class="search-result-meta">
            <span class="search-result-badge"><?php echo esc_html( $post_type_label ); ?></span>
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
        </div>

        <h2 class="search-result-title">
            <a href="<?php the_permalink(); ?>">
                <?php
                $title = get_the_title();
                $keys = explode( ' ', get_search_query() );
                $title = preg_replace( '/(' . implode( '|', array_map( 'preg_quote', array_filter( $keys ) ) ) . ')/iu', '<mark class="search-highlight">$0</mark>', esc_html( $title ) );
                echo $title;
                ?>
            </a>
        </h2>

        <div class="search-result-excerpt">
            <?php
            $excerpt = get_the_excerpt();
            if ( empty( $excerpt ) ) {
                $excerpt = wp_trim_words( wp_strip_all_tags( get_the_content() ), 24 );
            }
            $keys = explode( ' ', get_search_query() );
            $highlighted = preg_replace( '/(' . implode( '|', array_map( 'preg_quote', array_filter( $keys ) ) ) . ')/iu', '<mark class="search-highlight">$0</mark>', esc_html( $excerpt ) );
            echo '<p>' . $highlighted . '</p>';
            ?>
        </div>

        <a href="<?php the_permalink(); ?>" class="search-result-link">
            <span><?php esc_html_e( 'Voir le contenu', 'giapremix' ); ?></span>
            <span class="search-result-arrow" aria-hidden="true">&rarr;</span>
        </a>
    </div>
</article>
