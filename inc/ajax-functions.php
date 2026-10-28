<?php
/**
 * AJAX and Search Enhancement Functions
 *
 * @package giapremix
 */

defined( 'ABSPATH' ) || exit;

/**
 * Join postmeta table in search queries so ACF fields are searchable
 */
function giapremix_search_join( $join, $query ) {
    global $wpdb;
    if ( ( ! is_admin() || wp_doing_ajax() ) && $query->is_search() ) {
        $join .= " LEFT JOIN {$wpdb->postmeta} AS pm_search ON ({$wpdb->posts}.ID = pm_search.post_id) ";
    }
    return $join;
}
add_filter( 'posts_join', 'giapremix_search_join', 10, 2 );

/**
 * Extend WHERE clause to match ACF postmeta values
 */
function giapremix_search_where( $where, $query ) {
    global $wpdb;
    if ( ( ! is_admin() || wp_doing_ajax() ) && $query->is_search() ) {
        $search_term = $query->get( 's' );
        if ( ! empty( $search_term ) ) {
            $like = '%' . $wpdb->esc_like( $search_term ) . '%';
            $where = preg_replace(
                "/\({$wpdb->posts}\.post_title\s+LIKE\s*('[^']+')\)/",
                "({$wpdb->posts}.post_title LIKE $1) OR (pm_search.meta_value LIKE " . $wpdb->prepare( '%s', $like ) . ")",
                $where
            );
        }
    }
    return $where;
}
add_filter( 'posts_search', 'giapremix_search_where', 10, 2 );

/**
 * Prevent duplicate post rows when multiple meta rows match
 */
function giapremix_search_distinct( $distinct, $query ) {
    if ( ( ! is_admin() || wp_doing_ajax() ) && $query->is_search() ) {
        return 'DISTINCT';
    }
    return $distinct;
}
add_filter( 'posts_distinct', 'giapremix_search_distinct', 10, 2 );

/**
 * AJAX Live Search Handler
 */
add_action( 'wp_ajax_giapremix_live_search', 'giapremix_ajax_live_search' );
add_action( 'wp_ajax_nopriv_giapremix_live_search', 'giapremix_ajax_live_search' );

function giapremix_ajax_live_search() {
    if ( isset( $_REQUEST['nonce'] ) && ! empty( $_REQUEST['nonce'] ) ) {
        // Optional verification if provided
        check_ajax_referer( 'giapremix_search_nonce', 'nonce', false );
    }

    $keyword = isset( $_GET['term'] ) ? sanitize_text_field( wp_unslash( $_GET['term'] ) ) : '';

    if ( empty( $keyword ) || mb_strlen( $keyword ) < 2 ) {
        wp_send_json_success( array(
            'results' => array(),
            'total'   => 0,
        ) );
    }

    $args = array(
        'post_type'      => array( 'page', 'post' ),
        'post_status'    => 'publish',
        's'              => $keyword,
        'posts_per_page' => 6,
    );

    $search_query = new WP_Query( $args );
    $results      = array();

    if ( $search_query->have_posts() ) {
        while ( $search_query->have_posts() ) {
            $search_query->the_post();

            $thumb = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
            if ( ! $thumb ) {
                $thumb = get_template_directory_uri() . '/assets/images/douches-securite.png';
            }

            // Excerpt preparation
            $excerpt = get_the_excerpt();
            if ( empty( $excerpt ) ) {
                $excerpt = wp_trim_words( wp_strip_all_tags( get_the_content() ), 14 );
            } else {
                $excerpt = wp_trim_words( $excerpt, 14 );
            }

            $post_type_label = ( 'page' === get_post_type() ) ? __( 'Page', 'giapremix' ) : __( 'Article', 'giapremix' );

            $results[] = array(
                'title'     => get_the_title(),
                'url'       => get_permalink(),
                'excerpt'   => $excerpt,
                'thumbnail' => $thumb,
                'type'      => $post_type_label,
            );
        }
        wp_reset_postdata();
    }

    wp_send_json_success( array(
        'results'     => $results,
        'total'       => $search_query->found_posts,
        'all_url'     => home_url( '/?s=' . urlencode( $keyword ) ),
    ) );
}
