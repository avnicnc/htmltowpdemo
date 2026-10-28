<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package giapremix
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="no-results-card">
    <div class="no-results-icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            <line x1="8" y1="11" x2="14" y2="11"></line>
        </svg>
    </div>

    <h2 class="no-results-title"><?php esc_html_e( 'Aucun résultat trouvé', 'giapremix' ); ?></h2>
    <p class="no-results-desc">
        <?php esc_html_e( 'Désolé, aucun élément ne correspond à vos critères de recherche. Essayez d’utiliser d’autres mots-clés ou des termes plus généraux.', 'giapremix' ); ?>
    </p>

    <div class="no-results-actions">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
            <span><?php esc_html_e( 'Retour à l’accueil', 'giapremix' ); ?></span>
        </a>
    </div>
</div>
