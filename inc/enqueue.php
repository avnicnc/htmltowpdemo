<?php
/**
 * Enqueue scripts and styles.
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

function htnl_scripts() {
    $theme_version = time(); // Cache busting during development per theme guide

    // Google Fonts: Montserrat
    wp_enqueue_style(
        'htnl-google-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    // CSS Load Order: variables -> reset -> base -> common -> style -> theme style.css
    wp_enqueue_style(
        'htnl-variables',
        get_template_directory_uri() . '/assets/css/variables.css',
        array(),
        $theme_version
    );

    wp_enqueue_style(
        'htnl-reset',
        get_template_directory_uri() . '/assets/css/reset.css',
        array( 'htnl-variables' ),
        $theme_version
    );

    wp_enqueue_style(
        'htnl-base',
        get_template_directory_uri() . '/assets/css/base.css',
        array( 'htnl-reset' ),
        $theme_version
    );

    wp_enqueue_style(
        'htnl-common',
        get_template_directory_uri() . '/assets/css/common.css',
        array( 'htnl-base' ),
        $theme_version
    );

    wp_enqueue_style(
        'htnl-main-style',
        get_template_directory_uri() . '/assets/css/style.css',
        array( 'htnl-common' ),
        $theme_version
    );

    wp_enqueue_style(
        'htnl-theme-style',
        get_stylesheet_uri(),
        array( 'htnl-main-style' ),
        $theme_version
    );

    // Main JavaScript
    wp_enqueue_script(
        'htnl-script',
        get_template_directory_uri() . '/assets/js/script.js',
        array(),
        $theme_version,
        true
    );

    // Localize script with AJAX URL and nonce for live search
    wp_localize_script(
        'htnl-script',
        'giapremix_ajax',
        array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'giapremix_search_nonce' ),
            'strings'  => array(
                'searching'  => esc_html__( 'Recherche en cours...', 'giapremix' ),
                'no_results' => esc_html__( 'Aucun résultat trouvé pour votre recherche', 'giapremix' ),
                'view_all'   => esc_html__( 'Voir tous les résultats', 'giapremix' ),
            ),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'htnl_scripts' );
