<?php
/**
 * Login shortcode class for rendering the login form.
 *
 * @package ThreeDMed\Shortcodes
 */

namespace ThreeDMed\Shortcodes;

class LoginShortcode extends AbstractShortcode {

	/**
	 * Shortcode tag for the login form
	 *
	 * @var string
	 */
	protected $tag = 'login_form';

	/**
	 * Render the login form
	 *
	 * @param array $atts Shortcode attributes
	 * @return string
	 */
	public function render( $atts = array() ) {
		// Start output buffering
		\ob_start();

		if ( \is_user_logged_in() ) {
			// If the user is logged in, display the user dashboard
			include \get_template_directory() . '/templates/parts/user-dashboard.php';
		} else {
			// If the user is not logged in, display the login form
			include \get_template_directory() . '/templates/forms/login.php';
		}

		// Return the buffered content
		return \ob_get_clean();
	}
}
