<?php
/**
 * Theme Footer
 *
 * @package ThreeDMed
 */
?>
    </main><!-- #main -->

    <footer class="site-footer" role="contentinfo">
        <div class="site-footer__top">
            <div class="site-footer__columns">

                <?php if ( is_active_sidebar( 'footer_column_1' ) ) : ?>
                    <div class="site-footer__column">
                        <?php dynamic_sidebar( 'footer_column_1' ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer_column_2' ) ) : ?>
                    <div class="site-footer__column">
                        <?php dynamic_sidebar( 'footer_column_2' ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer_column_3' ) ) : ?>
                    <div class="site-footer__column">
                        <?php dynamic_sidebar( 'footer_column_3' ); ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <div class="site-footer__bottom">
            <?php if ( is_active_sidebar( 'footer_bottom' ) ) : ?>
                <div class="site-footer__bottom-content">
                    <?php dynamic_sidebar( 'footer_bottom' ); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="site-footer__copyright">
            <?php
            printf(
                /* translators: 1: current year, 2: site name */
                esc_html__( '© %1$s %2$s. All rights reserved.', 'threedmed' ),
                esc_html( date_i18n( 'Y' ) ),
                esc_html( get_bloginfo( 'name' ) )
            );
            ?>
        </div>

    </footer>

</div><!-- .site-wrapper -->

<?php wp_footer(); ?>

</body>
</html>