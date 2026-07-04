<?php
/**
 * Main template file
 *
 * @package ThreeDMed
 */

get_header();
?>

<div class="container">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            get_template_part( 'templates/parts/content', get_post_type() );
        endwhile;
    else :
        get_template_part( 'templates/parts/content', 'none' );
    endif;
    ?>
</div>

<?php
get_footer();