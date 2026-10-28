<?php
/**
 * Main template fallback
 *
 * @package htnl
 */

get_header();
?>

<main class="site-main">
    <div class="container" style="padding: 60px 0;">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
