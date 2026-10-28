<?php
/**
 * htnl Theme Functions and Definitions
 *
 * Bootstrapper file requiring core theme logic from /inc/ directory.
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

// Core Setup
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/template-functions.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/helpers.php';

// ACF & Nav
require_once get_template_directory() . '/inc/acf-options.php';
require_once get_template_directory() . '/inc/acf-autosync.php';
require_once get_template_directory() . '/inc/nav-walker.php';

// Search & AJAX
require_once get_template_directory() . '/inc/ajax-functions.php';

