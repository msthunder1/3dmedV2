<?php
/**
 * Profile update AJAX handler
 *
 * @package ThreeDMed\Ajax
 */

namespace ThreeDMed\Ajax;

use ThreeDMed\Services\ProfileService;

/**
 *  Handles the AJAX request that updates a customer profile information
 */
class ProfileUpdateHandler extends AbstractAjaxHandler {

	/**
	 * @var ProfileService
	 */
	private $profile_service;

	/**
	 * The action name for the AJAX request
	 *
	 * @var string
	 */
	protected $action = 'threedmed_profile_update';

	/**
	 * The nonce action for security verification
	 *
	 * @var string
	 */
	protected $nonce_action = 'threedmed_profile_update';

	/**
	 * Constructor
	 *
	 * @param \ThreeDMed\Services\ProfileService $profile_service
	 */
	public function __construct( ProfileService $profile_service ) {
		$this->profile_service = $profile_service;
	}

	/**
	 * Handle profile update request
	 *
	 * @return void
	 */
	public function handle() {
		if ( ! $this->verify_nonce() ) {
			$this->send_error(
				array(
					'errors' => array( 'general' => \__( 'Security check failed.', 'threedmed' ) ),
				)
			);
		}

		if ( ! \is_user_logged_in() ) {
			$this->send_error(
				array(
					'errors' => array( 'general' => \__( 'You must be logged in to update your profile.', 'threedmed' ) ),
				)
			);
		}

		$data = array(
			'rep_first_name'   => \sanitize_text_field( $_POST['rep_first_name'] ?? '' ),
			'rep_last_name'    => \sanitize_text_field( $_POST['rep_last_name'] ?? '' ),
			'rep_email'        => \sanitize_email( $_POST['rep_email'] ?? '' ),
			'rep_phone'        => \sanitize_text_field( $_POST['rep_phone'] ?? '' ),
			'company_name'     => \sanitize_text_field( $_POST['company_name'] ?? '' ),
			'short_name'       => \sanitize_text_field( $_POST['short_name'] ?? '' ),
			'vat_number'       => \sanitize_text_field( $_POST['vat_number'] ?? '' ),
			'vat_liable'       => ! empty( $_POST['vat_liable'] ),
			'street'           => \sanitize_text_field( $_POST['street'] ?? '' ),
			'postal_code'      => \sanitize_text_field( $_POST['postal_code'] ?? '' ),
			'city'             => \sanitize_text_field( $_POST['city'] ?? '' ),
			'country'          => \sanitize_text_field( $_POST['country'] ?? '' ),
			'company_email'    => \sanitize_email( $_POST['company_email'] ?? '' ),
			'company_phone'    => \sanitize_text_field( $_POST['company_phone'] ?? '' ),
			'password'         => $_POST['password'] ?? '',
			'password_confirm' => $_POST['password_confirm'] ?? '',
		);

		/**
		 * Delegate the update to the profile service
		 */
		$result = $this->profile_service->update_profile( \get_current_user_id(), $data );

		if ( $result['success'] ) {
			$this->send_success(
				array(
					'message' => $result['message'] ?? \__( 'Profile updated successfully.', 'threedmed' ),
				)
			);
		} else {
			$this->send_error(
				array(
					'errors' => $result['errors'] ?? \__( 'Failed to update profile.', 'threedmed' ),
				)
			);
		}
	}
}
