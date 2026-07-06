<?php
/**
 * Theme Header
 *
 * @package ThreeDMed
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>

    <body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

        <div class="site-wrapper">

        <header class="site-header" role="banner">
            <div class="site-header__inner">

                <div class="site-header__logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                </div>

                <?php get_template_part( 'templates/parts/logged-in-bar' ); ?>

                <nav class="site-header__nav" role="navigation" aria-label="<?php esc_attr_e( 'Main Menu', 'threedmed' ); ?>">
                    <?php
                    wp_nav_menu( [
                        'theme_location' => 'header-menu',
                        'menu_class'     => 'main-nav',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ] );
                    ?>
                </nav>

            </div>
        </header>

        <main id="main" class="site-main container" role="main">