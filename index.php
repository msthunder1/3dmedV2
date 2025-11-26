<?php
/**
 * Fallback template
 *
 * This file is required by WordPress but should rarely be used.
 * Specific templates should handle most requests.
 *
 * @package ThreeDMed
 */

get_header();
?>

<main id="main" class="site-main">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
    else :
        echo '<p>' . esc_html__( 'No content found.', 'threedmed' ) . '</p>';
    endif;
    ?>
</main>

<?php
get_footer();