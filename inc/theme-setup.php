<?php
/**
 * Theme Setup Functions
 *
 * @package htnl
 */

defined('ABSPATH') || exit;

function htnl_setup()
{
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Navigation', 'giapremix'),
        'topbar' => esc_html__('Top Bar Links', 'giapremix'),
        'megamenu' => esc_html__('Mega Menu Categories & Links', 'giapremix'),
        'footer-1' => esc_html__('Footer Column 1', 'giapremix'),
        'footer-2' => esc_html__('Footer Column 2', 'giapremix'),
        'footer-3' => esc_html__('Footer Column 3', 'giapremix'),
        'footer-legal' => esc_html__('Footer Legal Links', 'giapremix'),
    ));

    // Switch default core markup for search form, comment form, etc. to output valid HTML5.
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
}
add_action('after_setup_theme', 'htnl_setup');
