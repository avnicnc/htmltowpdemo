<?php
/**
 * ACF Options Pages Registration
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

add_action( 'acf/init', 'htnl_register_acf_options_pages' );

function htnl_register_acf_options_pages() {
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    // Main Theme Settings
    acf_add_options_page( array(
        'page_title' => esc_html__( 'Theme Settings', 'htnl' ),
        'menu_title' => esc_html__( 'Theme Settings', 'htnl' ),
        'menu_slug'  => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect'   => true,
        'icon_url'   => 'dashicons-admin-generic',
        'position'   => 59,
    ) );

    // Header Settings Subpage
    acf_add_options_sub_page( array(
        'page_title'  => esc_html__( 'Header Settings', 'htnl' ),
        'menu_title'  => esc_html__( 'Header', 'htnl' ),
        'parent_slug' => 'theme-general-settings',
        'menu_slug'   => 'header-settings',
    ) );

    // Footer Settings Subpage
    acf_add_options_sub_page( array(
        'page_title'  => esc_html__( 'Footer Settings', 'htnl' ),
        'menu_title'  => esc_html__( 'Footer', 'htnl' ),
        'parent_slug' => 'theme-general-settings',
        'menu_slug'   => 'footer-settings',
    ) );
}
