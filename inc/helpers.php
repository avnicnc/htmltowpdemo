<?php
/**
 * Generic helper utilities
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

/**
 * Extract Attachment ID safely from an ACF Image field value
 * (handles ID, Array, or Object formats)
 */
function htnl_get_image_id( $image ) {
    if ( empty( $image ) ) {
        return 0;
    }

    if ( is_numeric( $image ) ) {
        return (int) $image;
    }

    if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
        return (int) $image['ID'];
    }

    if ( is_object( $image ) && ! empty( $image->ID ) ) {
        return (int) $image->ID;
    }

    return 0;
}

/**
 * Render an ACF image securely using wp_get_attachment_image
 * Strictly adheres to rule: only renders if attachment ID exists
 */
function htnl_render_image( $image, $size = 'full', $attr = array() ) {
    $attachment_id = htnl_get_image_id( $image );
    if ( ! $attachment_id ) {
        return '';
    }

    return wp_get_attachment_image( $attachment_id, $size, false, $attr );
}

/**
 * Get image URL from ACF field
 */
function htnl_get_image_url( $image, $size = 'full' ) {
    $attachment_id = htnl_get_image_id( $image );
    if ( ! $attachment_id ) {
        return '';
    }

    $src = wp_get_attachment_image_src( $attachment_id, $size );
    return $src ? $src[0] : '';
}
