<?php
/**
 * Additional features and theme modifiers
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

// 1. Disable Gutenberg Editor site-wide
add_filter( 'use_block_editor_for_post', '__return_false', 10 );

// 2. Disable Block Widgets
add_filter( 'use_widgets_block_editor', '__return_false' );

// 3. Enable SVG Upload Support safely
function htnl_mime_types( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'htnl_mime_types' );

// Fix SVG display in media library
function htnl_fix_svg_display() {
    echo '<style>
        .attachment-266x266, .thumbnail img[src$=".svg"] {
            width: 100% !important;
            height: auto !important;
        }
    </style>';
}
add_action( 'admin_head', 'htnl_fix_svg_display' );

// 4. Disable Comments Site-Wide
function htnl_disable_comments_post_types_support() {
    $post_types = get_post_types();
    foreach ( $post_types as $post_type ) {
        if ( post_type_supports( $post_type, 'comments' ) ) {
            remove_post_type_support( $post_type, 'comments' );
            remove_post_type_support( $post_type, 'trackbacks' );
        }
    }
}
add_action( 'admin_init', 'htnl_disable_comments_post_types_support' );

// Close comments on the front-end
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );

// Hide existing comments
add_filter( 'comments_array', '__return_empty_array', 10, 2 );

// Remove comments page and icon in admin menu
function htnl_disable_comments_admin_menu() {
    remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'htnl_disable_comments_admin_menu' );

// Redirect any user trying to access comments page directly
function htnl_disable_comments_admin_redirect() {
    global $pagenow;
    if ( 'edit-comments.php' === $pagenow ) {
        wp_safe_redirect( admin_url() );
        exit;
    }
}
add_action( 'admin_init', 'htnl_disable_comments_admin_redirect' );

// Remove comments links from admin bar
function htnl_disable_comments_admin_bar() {
    global $wp_admin_bar;
    if ( is_admin_bar_showing() && $wp_admin_bar ) {
        $wp_admin_bar->remove_node( 'comments' );
    }
}
add_action( 'wp_before_admin_bar_render', 'htnl_disable_comments_admin_bar' );
