<?php
/**
 * The standard page template running the dynamic ACF Flexible Content loop
 *
 * @package htnl
 */

get_header();

if ( have_rows( 'sections' ) ) :
    while ( have_rows( 'sections' ) ) : the_row();
        $layout = get_row_layout();
        get_template_part( 'template-parts/sections/' . $layout . '/' . $layout );
    endwhile;
else :
    while ( have_posts() ) : the_post();
        ?>
        <div class="container" style="padding: 60px 0;">
            <h1><?php the_title(); ?></h1>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </div>
        <?php
    endwhile;
endif;

get_footer();
