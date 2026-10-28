<?php
/**
 * The template for displaying search results pages
 *
 * @package giapremix
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main search-results-page">

    <!-- Search Hero Banner -->
    <section class="search-header-section">
        <div class="container">
            <span class="search-badge"><?php esc_html_e( 'Recherche GIA Premix', 'giapremix' ); ?></span>
            <h1 class="search-title">
                <?php
                /* translators: %s: search query. */
                printf( esc_html__( 'Résultats pour : « %s »', 'giapremix' ), '<span class="search-query-term">' . esc_html( get_search_query() ) . '</span>' );
                ?>
            </h1>
            <p class="search-count">
                <?php
                global $wp_query;
                printf(
                    esc_html( _n( '%d résultat trouvé', '%d résultats trouvés', (int) $wp_query->found_posts, 'giapremix' ) ),
                    (int) $wp_query->found_posts
                );
                ?>
            </p>

            <form role="search" method="get" class="search-page-bar" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input type="search" name="s" class="search-page-input" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Affiner votre recherche...', 'giapremix' ); ?>" required autocomplete="off">
                <button type="submit" class="btn btn-yellow search-page-submit">
                    <span><?php esc_html_e( 'Rechercher', 'giapremix' ); ?></span>
                    <span class="btn-icon" aria-hidden="true">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/btn-triangle.svg' ); ?>" alt="" width="14" height="12">
                    </span>
                </button>
            </form>
        </div>
    </section>

    <!-- Search Results Body -->
    <section class="search-results-section">
        <div class="container">
            <?php if ( have_posts() ) : ?>
                <div class="search-results-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/content', 'search' );
                    endwhile;
                    ?>
                </div>

                <div class="search-pagination">
                    <?php
                    the_posts_pagination( array(
                        'prev_text' => '&larr; ' . esc_html__( 'Précédent', 'giapremix' ),
                        'next_text' => esc_html__( 'Suivant', 'giapremix' ) . ' &rarr;',
                    ) );
                    ?>
                </div>
            <?php else : ?>
                <?php get_template_part( 'template-parts/content', 'none' ); ?>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php
get_footer();
