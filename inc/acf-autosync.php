<?php
/**
 * ACF JSON Auto-Sync & Automatic Field Group Importer
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

// Configure ACF JSON Save point
add_filter( 'acf/settings/save_json', 'htnl_acf_json_save_point' );
function htnl_acf_json_save_point( $path ) {
    return get_template_directory() . '/acf-json';
}

// Configure ACF JSON Load point
add_filter( 'acf/settings/load_json', 'htnl_acf_json_load_point' );
function htnl_acf_json_load_point( $paths ) {
    unset( $paths[0] );
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
}

// Automatic Importer on admin_init
add_action( 'admin_init', 'htnl_acf_auto_import_field_groups' );
function htnl_acf_auto_import_field_groups() {
    if ( ! current_user_can( 'manage_options' ) || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
        return;
    }

    if ( ! function_exists( 'acf_get_field_groups' ) || ! function_exists( 'acf_import_field_group' ) ) {
        return;
    }

    $json_dir = get_template_directory() . '/acf-json';
    if ( ! is_dir( $json_dir ) ) {
        return;
    }

    $json_files = glob( $json_dir . '/*.json' );
    if ( empty( $json_files ) ) {
        return;
    }

    $db_field_groups = acf_get_field_groups();
    $db_groups_by_key = array();
    foreach ( $db_field_groups as $group ) {
        $db_groups_by_key[ $group['key'] ] = $group;
    }

    foreach ( $json_files as $file ) {
        $file_content = file_get_contents( $file );
        $json = json_decode( $file_content, true );
        if ( ! is_array( $json ) || empty( $json['key'] ) ) {
            continue;
        }

        $group_key = $json['key'];
        $file_modified = isset( $json['modified'] ) ? (int) $json['modified'] : filemtime( $file );

        // If not in DB, import it. If in DB but file is newer, sync it.
        $needs_import = false;
        if ( ! isset( $db_groups_by_key[ $group_key ] ) ) {
            $needs_import = true;
        } else {
            $db_group = $db_groups_by_key[ $group_key ];
            $db_modified = isset( $db_group['modified'] ) ? (int) $db_group['modified'] : 0;
            if ( $file_modified > $db_modified ) {
                $needs_import = true;
            }
        }

        if ( $needs_import ) {
            acf_import_field_group( $json );
        }
    }
}
