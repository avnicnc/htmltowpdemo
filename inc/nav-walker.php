<?php
/**
 * Custom Navigation Walkers for GIA Premix Theme
 *
 * @package giapremix
 */

defined( 'ABSPATH' ) || exit;

/**
 * Primary Desktop / Mobile Navigation Walker
 */
class Giapremix_Nav_Walker extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "$indent</ul>\n";
    }

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $menu_item = $data_object;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
        
        $item_class = 'header-section-nav-item';
        if ( in_array( 'current-menu-item', $classes, true ) ) {
            $item_class .= ' is-active';
        }

        $output .= $indent . '<div class="' . esc_attr( $item_class ) . '">';

        $atts = array();
        $atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
        $atts['target'] = ! empty( $menu_item->target )     ? $menu_item->target     : '';
        $atts['rel']    = ! empty( $menu_item->xfn )        ? $menu_item->xfn        : '';
        $atts['href']   = ! empty( $menu_item->url )        ? $menu_item->url        : '';
        $atts['class']  = 'header-section-nav-link';

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

        $item_output = ( isset( $args->before ) ) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . $title . ( isset( $args->link_after ) ? $args->link_after : '' );
        $item_output .= '</a>';
        $item_output .= ( isset( $args->after ) ) ? $args->after : '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        $output .= "</div>\n";
    }
}

// Backwards compatibility alias
if ( ! class_exists( 'Htnl_Nav_Walker' ) ) {
    class_alias( 'Giapremix_Nav_Walker', 'Htnl_Nav_Walker' );
}

/**
 * Topbar Links Walker (Renders links with divider)
 */
class Giapremix_Topbar_Walker extends Walker_Nav_Menu {
    private $item_index = 0;

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $menu_item = $data_object;
        if ( $this->item_index > 0 ) {
            $output .= '<span class="header-section-topbar-divider" aria-hidden="true"></span>';
        }
        $this->item_index++;

        $url   = ! empty( $menu_item->url ) ? $menu_item->url : '#';
        $title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );
        $target = ! empty( $menu_item->target ) ? ' target="' . esc_attr( $menu_item->target ) . '"' : '';

        $output .= '<a href="' . esc_url( $url ) . '"' . $target . '>' . esc_html( $title ) . '</a>';
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        // Flat list
    }
}

/**
 * Footer Column Walker (Handles parent h3 + child ul list)
 */
class Giapremix_Footer_Column_Walker extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= "<ul>\n";
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= "</ul>\n";
    }

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $menu_item = $data_object;
        $title     = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );
        $url       = ! empty( $menu_item->url ) ? $menu_item->url : '#';

        if ( 0 === $depth ) {
            // Parent section heading
            $output .= '<h3>' . esc_html( $title ) . "</h3>\n";
        } else {
            // Child list item
            $output .= '<li><a href="' . esc_url( $url ) . '">' . esc_html( $title ) . '</a></li>' . "\n";
        }
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        // No closing tag needed for parent
    }
}

/**
 * Flat Simple Links Walker (e.g. for Legal Links in Bottom Bar)
 */
class Giapremix_Simple_Links_Walker extends Walker_Nav_Menu {
    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $menu_item = $data_object;
        $title     = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );
        $url       = ! empty( $menu_item->url ) ? $menu_item->url : '#';
        $target    = ! empty( $menu_item->target ) ? ' target="' . esc_attr( $menu_item->target ) . '"' : '';

        $output .= '<a href="' . esc_url( $url ) . '"' . $target . '>' . esc_html( $title ) . '</a>';
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        // Flat links
    }
}

/**
 * Fallback callback if no menu assigned
 */
function giapremix_nav_fallback() {
    if ( current_user_can( 'edit_theme_options' ) ) {
        echo '<div class="header-section-nav-item"><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" class="header-section-nav-link">' . esc_html__( 'Assign a Menu', 'giapremix' ) . '</a></div>';
    }
}
