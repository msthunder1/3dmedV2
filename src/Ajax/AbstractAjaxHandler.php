<?php
/**
 * Abstract class for handling AJAX requests
 *
 * @package ThreeDMed\Ajax
 */

namespace ThreeDMed\Ajax;

abstract class AbstractAjaxHandler {

	/**
	 * The action name for the AJAX request
	 *
	 * @var string
	 */
	protected $action;

	/**
	 * The nonce action for security verification
	 *
	 * @var string
	 */
	protected $nonce_action;

	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public function init() {
		// For logged-in users
		\add_action( 'wp_ajax_' . $this->action, array( $this, 'handle' ) );
		// For non-logged-in users
		\add_action( 'wp_ajax_nopriv_' . $this->action, array( $this, 'handle' ) );
	}

	/**
	 * Verify the nonce for security
	 *
	 * @return bool
	 */
	protected function verify_nonce() {
		$nonce = $_POST['nonce'] ?? '';
		return \wp_verify_nonce( $nonce, $this->nonce_action );
	}

	/**
	 * Send a success response
	 *
	 * @param array $data The data to send
	 * @return void
	 */
	protected function send_success( $data = array() ) {
		\wp_send_json_success( $data );
	}

	/**
	 * Send an error response
	 *
	 * @param string $data The error message
	 * @return void
	 */
	protected function send_error( $data ) {
		if ( is_string( $data ) ) {
			\wp_send_json_error( array( 'message' => $data ) );
		} else {
			\wp_send_json_error( $data );
		}
	}

	/**
	 * Handle the AJAX request
	 *
	 * @return void
	 */
	abstract public function handle();
}
