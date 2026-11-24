<?php
/**
 * ACF Options Pages registrar
 *
 * @package ThreeDMed\Admin
 */

namespace ThreeDMed\Admin;

/**
 * Registers ACF options pages for site-wide settings
 */
class OptionsPage {

	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public function init() {
		\add_action( 'acf/init', array( $this, 'register_options_pages' ) );
	}

	/**
	 * Register all options pages
	 *
	 * @return void
	 */
	public function register_options_pages() {
		if ( ! \function_exists( 'acf_add_options_page' ) ) {
			return;
		}

		\acf_add_options_page(
			array(
				'page_title' => \__( '3Dmed General Settings', 'threedmed' ),
				'menu_title' => \__( '3Dmed General Settings', 'threedmed' ),
				'menu_slug'  => 'threedmed-general-settings',
				'capability' => 'manage_options',
				'icon_url'   => 'dashicons-admin-generic',
				'position'   => 80,
			)
		);

		\acf_add_options_page(
			array(
				'page_title' => \__( '3Dmed Email Settings', 'threedmed' ),
				'menu_title' => \__( '3Dmed Email Settings', 'threedmed' ),
				'menu_slug'  => 'threedmed-email-settings',
				'capability' => 'manage_options',
				'icon_url'   => 'dashicons-email-alt',
				'position'   => 81,
			)
		);

		\acf_add_options_page(
			array(
				'page_title' => \__( '3Dmed Invoice Settings', 'threedmed' ),
				'menu_title' => \__( '3Dmed Invoice Settings', 'threedmed' ),
				'menu_slug'  => 'threedmed-invoice-settings',
				'capability' => 'manage_options',
				'icon_url'   => 'dashicons-media-spreadsheet',
				'position'   => 82,
			)
		);
	}
}
