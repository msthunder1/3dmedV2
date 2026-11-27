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
	$container->register(
		'script_enqueuer',
		function () {
			return new Assets\ScriptEnqueuer();
		}
	);

	$container->register(
		'style_enqueuer',
		function () {
			return new Assets\StyleEnqueuer();
		}
	);

	// Initialize asset loading.
	$container->get( 'script_enqueuer' )->init();
	$container->get( 'style_enqueuer' )->init();

	// Custom Post Types
	$post_types = array(
		'status_post_type'         => CustomPostTypes\StatusPostType::class,
		'pricing_post_type'        => CustomPostTypes\PricingPostType::class,
		'customer_post_type'       => CustomPostTypes\CustomerPostType::class,
		'material_post_type'       => CustomPostTypes\MaterialPostType::class,
		'material_cnc_post_type'   => CustomPostTypes\MaterialCncPostType::class,
		'color_cnc_post_type'      => CustomPostTypes\ColorCncPostType::class,
		'seeder_post_type'         => CustomPostTypes\SeederPostType::class,
		'order_post_type'          => CustomPostTypes\OrderPostType::class,
		'invoice_post_type'        => CustomPostTypes\InvoicePostType::class,
		'email_template_post_type' => CustomPostTypes\EmailTemplatePostType::class,
	);

	foreach ( $post_types as $name => $class ) {
		$container->register(
			$name,
			function () use ( $class ) {
				return new $class();
			}
		);

		$container->get( $name )->register();
	}

	// Admin options pages
	$container->register(
		'options_page',
		function () {
			return new Admin\OptionsPage();
		}
	);

	$container->get( 'options_page' )->init();

	// Widget areas (sidebars) registration.
	$container->register(
		'sidebars',
		function () {
			return new Widgets\Sidebars();
		}
	);

	$container->get( 'sidebars' )->init();

	// Custom user roles.
	$container->register(
		'role_manager',
		function () {
			return new Roles\RoleManager();
		}
	);

	$container->get( 'role_manager' )->init();

	// Repositories
	$container->register(
		'customer_repository',
		function () {
			return new Repositories\CustomerRepository();
		}
	);

	// Services
	$container->register(
		'customer_service',
		function ( $c ) {
			return new Services\CustomerService( $c->get( 'customer_repository' ) );
		}
	);

	// Shortcodes
	$container->register(
		'registration_shortcode',
		function () {
			return new Shortcodes\RegistrationShortcode();
		}
	);

	$container->get( 'registration_shortcode' )->init();

	// Shortcodes - Login
	$container->register(
		'login_shortcode',
		function () {
			return new Shortcodes\LoginShortcode();
		}
	);

	$container->get( 'login_shortcode' )->init();

	// AJAX handlers
	$container->register(
		'registration_handler',
		function ( $c ) {
			return new Ajax\RegistrationHandler( $c->get( 'customer_service' ) );
		}
	);

	$container->get( 'registration_handler' )->init();

	// Auth service
	$container->register(
		'auth_service',
		function () {
			return new Services\AuthService();
		}
	);

	// Login AJAX handler
	$container->register(
		'login_handler',
		function ( $c ) {
			return new Ajax\LoginHandler( $c->get( 'auth_service' ) );
		}
	);

	$container->get( 'login_handler' )->init();

	// Services - Profile
	$container->register(
		'profile_service',
		function ( $c ) {
			return new Services\ProfileService( $c->get( 'customer_repository' ) );
		}
	);

	// Shortcodes - Profile
	$container->register(
		'profile_shortcode',
		function ( $c ) {
			return new Shortcodes\ProfileShortcode( $c->get( 'profile_service' ) );
		}
	);

	$container->get( 'profile_shortcode' )->init();

	// AJAX - Profile update handler
	$container->register(
		'profile_update_handler',
		function ( $c ) {
			return new Ajax\ProfileUpdateHandler( $c->get( 'profile_service' ) );
		}
	);

	$container->get( 'profile_update_handler' )->init();

	// Services - Access
	$container->register(
		'access_service',
		function () {
			return new Services\AccessService();
		}
	);

	// Security - Access guard
	$container->register(
		'access_guard',
		function ( $c ) {
			return new Security\AccessGuard(
				$c->get( 'access_service' ),
				array(
					'my-account' => array( 'administrator', '3dmed_stranka' ),
				),
				array(
					'registration',
				)
			);
		}
	);

	$container->get( 'access_guard' )->init();
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
	register_nav_menus(
		array(
			'header-menu' => __( 'Header Menu', 'threedmed' ),
		)
	);

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

/**
 * Check required plugins
 *
 * @return void
 */
function check_required_plugins() {
	if ( ! function_exists( 'get_field' ) ) {
		add_action(
			'admin_notices',
			function () {
				echo '<div class="notice notice-error"><p>';
				esc_html_e( '3D Med Theme requires Advanced Custom Fields plugin to be active.', 'threedmed' );
				echo '</p></div>';
			}
		);
	}
}
add_action( 'admin_init', __NAMESPACE__ . '\\check_required_plugins' );
