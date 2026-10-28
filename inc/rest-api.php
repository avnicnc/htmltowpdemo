<?php
/**
 * Headless Custom REST API Endpoints
 *
 * Provides endpoints for menus (including ACF image fields) and search
 * for the Next.js headless frontend.
 *
 * @package giapremix
 */

defined( 'ABSPATH' ) || exit;

add_action( 'rest_api_init', 'giapremix_register_headless_endpoints' );

function giapremix_register_headless_endpoints() {
    // Menu endpoint
    register_rest_route( 'giapremix/v1', '/menu', array(
        'methods'             => 'GET',
        'callback'            => 'giapremix_rest_get_menu',
        'permission_callback' => '__return_true',
    ) );

    // Global layout endpoint (combining header, footer, menu in 1 call)
    register_rest_route( 'giapremix/v1', '/layout', array(
        'methods'             => 'GET',
        'callback'            => 'giapremix_rest_get_layout',
        'permission_callback' => '__return_true',
    ) );

    // Search endpoint (searches post title, content, and ACF postmeta)
    register_rest_route( 'giapremix/v1', 'search', array(
        'methods'             => 'GET',
        'callback'            => 'giapremix_rest_search',
        'permission_callback' => '__return_true',
        'args'                => array(
            'term' => array(
                'required'          => true,
                'sanitize_callback' => 'sanitize_text_field',
            ),
        ),
    ) );

    // Page endpoint returning full resolved ACF flexible sections
    register_rest_route( 'giapremix/v1', '/page', array(
        'methods'             => 'GET',
        'callback'            => 'giapremix_rest_get_page',
        'permission_callback' => '__return_true',
        'args'                => array(
            'slug' => array(
                'required'          => false,
                'default'           => 'home',
                'sanitize_callback' => 'sanitize_title',
            ),
        ),
    ) );
}

/**
 * Enable CORS on all giapremix REST routes
 */
add_action( 'rest_pre_serve_request', function( $served, $result, $request, $server ) {
    header( 'Access-Control-Allow-Origin: *' );
    header( 'Access-Control-Allow-Methods: GET, OPTIONS' );
    header( 'Access-Control-Allow-Headers: Authorization, Content-Type, X-WP-Wpnonce' );
    return $served;
}, 10, 4 );

/**
 * Get formatted primary navigation menu with ACF image fields
 */
function giapremix_rest_get_menu() {
    $locations = get_nav_menu_locations();
    $menu_id   = isset( $locations['primary'] ) ? $locations['primary'] : null;

    if ( ! $menu_id ) {
        // Fallback to first available menu if primary location not assigned
        $menus = wp_get_nav_menus();
        if ( ! empty( $menus ) ) {
            $menu_id = $menus[0]->term_id;
        }
    }

    if ( ! $menu_id ) {
        return rest_ensure_response( array( 'items' => array() ) );
    }

    $raw_items = wp_get_nav_menu_items( $menu_id );
    if ( empty( $raw_items ) ) {
        return rest_ensure_response( array( 'items' => array() ) );
    }

    $items_by_id = array();
    $tree        = array();

    foreach ( $raw_items as $item ) {
        $img_id = get_field( 'menu_item_image', $item->ID );
        $image_url = '';
        if ( $img_id ) {
            $image_url = is_numeric( $img_id ) ? wp_get_attachment_image_url( $img_id, 'medium' ) : ( is_array( $img_id ) ? ( $img_id['url'] ?? '' ) : $img_id );
        }

        $items_by_id[ $item->ID ] = array(
            'id'       => $item->ID,
            'title'    => $item->title,
            'url'      => $item->url,
            'target'   => $item->target ?: '_self',
            'parent'   => (int) $item->menu_item_parent,
            'order'    => (int) $item->menu_order,
            'image'    => $image_url,
            'children' => array(),
        );
    }

    foreach ( $items_by_id as $id => &$item ) {
        if ( $item['parent'] && isset( $items_by_id[ $item['parent'] ] ) ) {
            $items_by_id[ $item['parent'] ]['children'][] = &$item;
        } else {
            $tree[] = &$item;
        }
    }

    return rest_ensure_response( array(
        'menu_id' => $menu_id,
        'items'   => $tree,
    ) );
}

/**
 * Get complete layout data (header options, footer options, menu)
 */
function giapremix_rest_get_layout() {
    $menu_response = giapremix_rest_get_menu();
    $menu_data     = $menu_response->get_data();

    $header_options = function_exists( 'get_fields' ) ? get_fields( 'header_options' ) : array();
    $footer_options = function_exists( 'get_fields' ) ? get_fields( 'footer_options' ) : array();

    // Format header options images
    if ( ! empty( $header_options['header_logo'] ) && is_numeric( $header_options['header_logo'] ) ) {
        $header_options['header_logo_url'] = wp_get_attachment_image_url( $header_options['header_logo'], 'full' );
    }

    return rest_ensure_response( array(
        'header' => $header_options ?: array(),
        'footer' => $footer_options ?: array(),
        'menu'   => $menu_data['items'] ?? array(),
    ) );
}

/**
 * Headless search endpoint matching post title, content, and ACF postmeta
 */
function giapremix_rest_search( $request ) {
    $term = $request->get_param( 'term' );
    if ( empty( $term ) || mb_strlen( $term ) < 2 ) {
        return rest_ensure_response( array(
            'results' => array(),
            'total'   => 0,
        ) );
    }

    $args = array(
        'post_type'      => array( 'page', 'post' ),
        'post_status'    => 'publish',
        's'              => $term,
        'posts_per_page' => 12,
    );

    $query   = new WP_Query( $args );
    $results = array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();

            $thumb = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
            if ( ! $thumb ) {
                $thumb = get_template_directory_uri() . '/assets/images/douches-securite.png';
            }

            $excerpt = get_the_excerpt();
            if ( empty( $excerpt ) ) {
                $excerpt = wp_trim_words( wp_strip_all_tags( get_the_content() ), 16 );
            } else {
                $excerpt = wp_trim_words( $excerpt, 16 );
            }

            $results[] = array(
                'id'        => get_the_ID(),
                'title'     => get_the_title(),
                'slug'      => get_post_field( 'post_name', get_the_ID() ),
                'type'      => get_post_type(),
                'type_label'=> 'page' === get_post_type() ? 'Page' : 'Article',
                'excerpt'   => $excerpt,
                'thumbnail' => $thumb,
                'date'      => get_the_date( 'c' ),
            );
        }
        wp_reset_postdata();
    }

    return rest_ensure_response( array(
        'results' => $results,
        'total'   => $query->found_posts,
    ) );
}

/**
 * Get single page data with fully resolved ACF Flexible Content sections
 */
function giapremix_rest_get_page( $request ) {
    $slug = $request->get_param( 'slug' ) ?: 'home';

    $page = null;
    if ( 'home' === $slug ) {
        $front_id = get_option( 'page_on_front' );
        if ( $front_id ) {
            $page = get_post( $front_id );
        }
    }

    if ( ! $page ) {
        $page = get_page_by_path( $slug );
    }

    if ( ! $page ) {
        // Try fallback query by post_name
        $query = new WP_Query( array(
            'post_type'      => array( 'page', 'post' ),
            'name'           => $slug,
            'posts_per_page' => 1,
        ) );
        if ( $query->have_posts() ) {
            $page = $query->posts[0];
        }
    }

    if ( ! $page ) {
        return new WP_Error( 'rest_page_not_found', __( 'Page introuvable', 'giapremix' ), array( 'status' => 404 ) );
    }

    $post_id  = $page->ID;
    $sections = function_exists( 'get_field' ) ? get_field( 'sections', $post_id ) : array();

    return rest_ensure_response( array(
        'id'       => $post_id,
        'title'    => get_the_title( $post_id ),
        'slug'     => $page->post_name,
        'status'   => $page->post_status,
        'sections' => is_array( $sections ) ? $sections : array(),
    ) );
}

