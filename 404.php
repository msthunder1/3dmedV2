<?php
/**
 * 404 error template
 *
 * @package ThreeDMed
 */

get_header();
?>

<div class="container">
    <section class="error-404">
        <h1><?php esc_html_e( 'Page not found', 'threedmed' ); ?></h1>
        <p><?php esc_html_e( 'The page you are looking for does not exist.', 'threedmed' ); ?></p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php esc_html_e( 'Return to homepage', 'threedmed' ); ?>
        </a>
    </section>
</div>

<?php
get_footer();