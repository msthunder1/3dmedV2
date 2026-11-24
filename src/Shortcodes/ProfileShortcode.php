<?php
/**
 * Profile shortcde
 *
 * @package ThreeDMed\Shortcodes
 */

namespace ThreeDMed\Shortcodes;

use ThreeDMed\Services\ProfileService;

class ProfileShortcode extends AbstractShortcode {

	/**
	 * Shrtcode tag
	 *
	 * @var string
	 */
	protected $tag = 'threedmed_profile';

	/**
	 * @var ProfileService
	 */
	private $profile_service;

	/**
	 * Constructor
	 *
	 * @param ProfileService $profile_service
	 */
	public function __construct( ProfileService $profile_service ) {
		$this->profile_service = $profile_service;
	}

	/**
	 * Render the profile form
	 *
	 * @param array $atts Shortcode attributes
	 * @return string HTML output
	 */
	public function render( $atts = array() ) {
		\ob_start();

		if ( ! is_user_logged_in() ) {
			include \get_template_directory() . '/templates/profile/not-logged-in.php';
		} else {
			$profile = $this->profile_service->get_profile_data( \get_current_user_id() );
			include \get_template_directory() . '/templates/profile/edit.php';
		}

		return \ob_get_clean();
	}
}
