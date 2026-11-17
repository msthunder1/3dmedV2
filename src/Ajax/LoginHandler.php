<?php
/**
 * LoginHandler class for handling user login via AJAX.
 *
 * @package ThreeDMed\Ajax
 */

namespace ThreeDMed\Ajax;

use ThreeDMed\Services\AuthService;

class LoginHandler extends AbstractAjaxHandler {

	/**
	 * @var AuthService
	 */
	private $auth_service;

	/**
	 * The action name for the AJAX request
	 *
	 * @var string
	 */
	protected $action = 'threedmed_login';

	/**
	 * The nonce action for security verification
	 *
	 * @var string
	 */
	protected $nonce_action = 'threedmed_login';

	/**
	 * Constructor
	 *
	 * @param \ThreeDMed\Services\AuthService $auth_service
	 */
	public function __construct( AuthService $auth_service ) {
		$this->auth_service = $auth_service;
	}

	/**
	 * Handle login request
	 *
	 * @return void
	 */
	public function handle() {
		if ( ! $this->verify_nonce() ) {
			$this->send_error( array( 'errors' => array( 'general' => \__( 'Security check failed.', 'threedmed' ) ) ) );
		}

		$email    = \sanitize_email( $_POST['email'] ?? '' );
		$password = $_POST['password'] ?? '';
		$remember = ! empty( $_POST['remember'] );

		$result = $this->auth_service->authenticate( $email, $password, $remember );

		if ( ! $result['success'] ) {
			$this->send_error( array( 'errors' => array( 'general' => \__( 'Invalid email or password.', 'threedmed' ) ) ) );
		}

		$this->send_success( array( 'redirect_url' => $result['redirect_url'] ) );
	}
}
