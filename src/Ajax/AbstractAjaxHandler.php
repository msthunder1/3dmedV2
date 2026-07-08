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
        \add_action( 'wp_ajax_' . $this->action, [ $this, 'handle_request' ] );
        // For non-logged-in users
        \add_action( 'wp_ajax_nopriv_' . $this->action, [ $this, 'handle_request' ] );
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
    protected function send_success($data = []) {
        \wp_send_json_success($data);
    }

    /**
     * Send an error response
     *
     * @param string $message The error message
     * @return void
     */
    protected function send_error ($message) {
        \wp_send_json_error( [ 'message' => $message ] );
    }

    /**
     * Handle the AJAX request
     *
     * @return void
     */
    abstract public function handle();
}