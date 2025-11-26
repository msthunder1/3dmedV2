<?php
/**
 * Theme Bootstrap
 *
 * Initializes the theme, sets up autoloading, and registers core functionality.
 *
 * @package ThreeDMed
 * @version 2.0.0
 */

namespace ThreeDMed;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Theme constants.
define( 'THREEDMED_VERSION', '2.0.0' );
define( 'THREEDMED_PATH', get_template_directory() );
define( 'THREEDMED_URL', get_template_directory_uri() );

// Composer autoloader.
require_once THREEDMED_PATH . '/vendor/autoload.php';

/**
 * Initialize the theme
 *
 * @return void
 */
function init() {
    // Create dependency injection container.
    $container = new Container();

    // Register services in container.
    register_services( $container );

    // Initialize theme features.
    setup_theme_support();
    
    // Store container globally.
    $GLOBALS['threedmed_container'] = $container;
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\init' );

/**
 * Register services in the container
 *
 * @param Container $container DI container.
 * @return void
 */
function register_services( Container $container ) {
    // Assets.
    $container->register( 'script_enqueuer', function() {
        return new Assets\ScriptEnqueuer();
    });
    
    $container->register( 'style_enqueuer', function() {
        return new Assets\StyleEnqueuer();
    });

    // Initialize asset loading.
    $container->get( 'script_enqueuer' )->init();
    $container->get( 'style_enqueuer' )->init();

    // TODO: Register other services (CPTs, repositories, services, etc.)
}

/**
 * Setup theme support
 *
 * @return void
 */
function setup_theme_support() {
    // Post thumbnails.
    add_theme_support( 'post-thumbnails' );

    // Custom image sizes.
    add_image_size( 'threedmed-largest', 1800, 9999 );
    add_image_size( 'threedmed-laptop', 1480, 9999 );
    add_image_size( 'threedmed-tablet', 1024, 9999 );
    add_image_size( 'threedmed-small', 768, 9999 );
    add_image_size( 'threedmed-smaller', 479, 9999 );
    add_image_size( 'threedmed-tiny', 250, 9999 );
    add_image_size( 'threedmed-tiniest', 75, 9999 );

    // Register navigation menus.
    register_nav_menus([
        'header-menu' => __( 'Header Menu', 'threedmed' ),
    ]);

    // Load text domain for translations.
    load_theme_textdomain( 'threedmed', THREEDMED_PATH . '/languages' );
}

/**
 * Get the DI container
 *
 * @return Container
 */
function container() {
    return $GLOBALS['threedmed_container'];
}

/**
 * Remove admin bar for all users
 */
add_filter( 'show_admin_bar', '__return_false' );