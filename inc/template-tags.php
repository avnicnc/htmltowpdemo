<?php
/**
 * Custom template tags for this theme
 *
 * @package htnl
 */

defined( 'ABSPATH' ) || exit;

/**
 * Render dynamic heading with tag validation
 */
function htnl_heading( $text, $tag = 'h2', $classes = '', $id = '', $highlight = '', $highlight_class = '' ) {
    if ( empty( $text ) ) {
        return '';
    }

    $allowed_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div', 'span' );
    $tag = in_array( strtolower( $tag ), $allowed_tags, true ) ? strtolower( $tag ) : 'h2';

    $class_attr = ! empty( $classes ) ? ' class="' . esc_attr( $classes ) . '"' : '';
    $id_attr    = ! empty( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

    $content = esc_html( $text );
    if ( ! empty( $highlight ) ) {
        $hl_span = '<span' . ( ! empty( $highlight_class ) ? ' class="' . esc_attr( $highlight_class ) . '"' : '' ) . '>' . esc_html( $highlight ) . '</span>';
        if ( strpos( $text, $highlight ) !== false ) {
            $content = str_replace( esc_html( $highlight ), $hl_span, $content );
        } else {
            $content .= ' ' . $hl_span;
        }
    }

    return sprintf( '<%1$s%2$s%3$s>%4$s</%1$s>', $tag, $id_attr, $class_attr, $content );
}

/**
 * Format copyright string with dynamic year
 */
function htnl_get_copyright( $text = '' ) {
    if ( empty( $text ) ) {
        $text = '© %year% GIA Premix. Tous droits réservés.';
    }
    return str_replace( '%year%', gmdate( 'Y' ), $text );
}

/**
 * Inline SVG helpers for shared theme icons
 */
function htnl_icon( $name ) {
    $icons = array(
        'arrow-down' => '<svg width="13" height="7" viewBox="0 0 13 7" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L6.5 6L12 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'arrow-right' => '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'btn-triangle' => '<svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.5 6L0.75 11.1962L0.75 0.803848L13.5 6Z" fill="currentColor"/></svg>',
    );

    return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/**
 * Render dedicated language switcher supporting Polylang, WPML, TranslatePress, or default multilingual options
 */
function giapremix_language_switcher() {
    $current_label = 'Svenska';
    $current_flag  = get_template_directory_uri() . '/assets/images/flag-svenska.png';
    $languages     = array();

    // 1. Polylang Integration
    if ( function_exists( 'pll_the_languages' ) ) {
        $raw_languages = pll_the_languages( array( 'raw' => 1 ) );
        if ( ! empty( $raw_languages ) && is_array( $raw_languages ) ) {
            foreach ( $raw_languages as $slug => $data ) {
                $is_active = ! empty( $data['current_lang'] );
                if ( $is_active ) {
                    $current_label = $data['name'];
                    if ( ! empty( $data['flag'] ) ) {
                        $current_flag = $data['flag'];
                    }
                }
                $languages[] = array(
                    'code'      => $slug,
                    'label'     => $data['name'],
                    'url'       => $data['url'],
                    'flag'      => ! empty( $data['flag'] ) ? $data['flag'] : '',
                    'is_active' => $is_active,
                );
            }
        }
    }
    // 2. WPML Integration
    elseif ( function_exists( 'icl_get_languages' ) ) {
        $raw_languages = icl_get_languages( 'skip_missing=0' );
        if ( ! empty( $raw_languages ) && is_array( $raw_languages ) ) {
            foreach ( $raw_languages as $slug => $data ) {
                $is_active = ! empty( $data['active'] );
                if ( $is_active ) {
                    $current_label = $data['native_name'];
                    if ( ! empty( $data['country_flag_url'] ) ) {
                        $current_flag = $data['country_flag_url'];
                    }
                }
                $languages[] = array(
                    'code'      => $slug,
                    'label'     => $data['native_name'],
                    'url'       => $data['url'],
                    'flag'      => ! empty( $data['country_flag_url'] ) ? $data['country_flag_url'] : '',
                    'is_active' => $is_active,
                );
            }
        }
    }

    // 3. Default Native Language Switcher Fallback
    if ( empty( $languages ) ) {
        $default_languages = array(
            'sv' => array(
                'code'      => 'sv',
                'label'     => 'Svenska',
                'url'       => '?lang=sv',
                'flag'      => get_template_directory_uri() . '/assets/images/flag-svenska.png',
                'is_active' => true,
            ),
            'en' => array(
                'code'      => 'en',
                'label'     => 'English',
                'url'       => '?lang=en',
                'flag'      => get_template_directory_uri() . '/assets/images/flag-english.png',
                'is_active' => false,
            ),
            'fi' => array(
                'code'      => 'fi',
                'label'     => 'Suomi',
                'url'       => '?lang=fi',
                'flag'      => get_template_directory_uri() . '/assets/images/flag-suomi.png',
                'is_active' => false,
            ),
        );

        if ( isset( $_GET['lang'] ) && isset( $default_languages[ sanitize_key( $_GET['lang'] ) ] ) ) {
            $selected = sanitize_key( $_GET['lang'] );
            foreach ( $default_languages as $k => &$item ) {
                $item['is_active'] = ( $k === $selected );
            }
            unset( $item );
            $current_label = $default_languages[ $selected ]['label'];
            $current_flag  = $default_languages[ $selected ]['flag'];
        }

        $languages = apply_filters( 'giapremix_available_languages', array_values( $default_languages ) );
    }
    ?>
    <div class="header-section-topbar-lang" data-lang-wrapper>
        <button type="button" class="header-section-topbar-lang-btn" data-lang-toggle aria-expanded="false" aria-label="<?php esc_attr_e( 'Byt språk', 'giapremix' ); ?>">
            <span class="header-section-topbar-flag" aria-hidden="true">
                <img src="<?php echo esc_url( $current_flag ); ?>" alt="<?php echo esc_attr( $current_label ); ?>" width="22" height="22">
            </span>
            <span data-lang-label><?php echo esc_html( $current_label ); ?></span>
            <span class="header-section-topbar-lang-arrow" aria-hidden="true">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-white.svg' ); ?>" alt="" width="13" height="7">
            </span>
        </button>
        <div class="header-section-topbar-lang-menu" role="menu">
            <?php foreach ( $languages as $lang ) : ?>
                <a href="<?php echo esc_url( $lang['url'] ); ?>" class="header-section-topbar-lang-item<?php echo ! empty( $lang['is_active'] ) ? ' is-active' : ''; ?>" role="menuitem">
                    <?php if ( ! empty( $lang['flag'] ) ) : ?>
                        <span class="lang-flag" aria-hidden="true">
                            <img src="<?php echo esc_url( $lang['flag'] ); ?>" alt="<?php echo esc_attr( $lang['label'] ); ?>" width="22" height="22">
                        </span>
                    <?php endif; ?>
                    <span><?php echo esc_html( $lang['label'] ); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

if ( ! function_exists( 'htnl_language_switcher' ) ) {
    function htnl_language_switcher() {
        giapremix_language_switcher();
    }
}

