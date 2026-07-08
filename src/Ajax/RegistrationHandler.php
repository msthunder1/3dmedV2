<?php
/**
 * Registration AJAX handler
 *
 * @package ThreeDMed\Ajax
 */

namespace ThreeDMed\Ajax;

use ThreeDMed\Services\CustomerService;

class RegistrationHandler extends AbstractAjaxHandler {

    /**
     * @var CustomerService
     */
    private $customer_service;

    /**
     * The action name for the AJAX request
     * 
     * @var string
     */
    protected $action = 'threedmed_registration';

    /**
     * The nonce action for security verification
     *
     * @var string
     */
    protected $nonce_action = 'threedmed_registration';

    /**
     * Constructor
     *
     * @param \ThreeDMed\Services\CustomerService $customer_service
     */
    public function __construct( CustomerService $customer_service ) {
        $this->customer_service = $customer_service;
    }

    /**
     * Handle registration request
     *
     * @return void
     */
    public function handle() {
        if( ! $this->verify_nonce() ) {
            $this->send_error( \__( 'Security check failed.', 'threedmed' ) );
        }

        $data = [
            'company_name' => \sanitize_text_field( $_POST['company_name'] ?? '' ),
            'short_name' => \sanitize_text_field( $_POST['short_name'] ?? '' ),
            'vat_number' => \sanitize_text_field( $_POST['vat_number'] ?? ''),
            'vat_liable' => !empty( $_POST['vat_liable'] ),
            'street' => \sanitize_text_field( $_POST['street'] ?? '' ),
            'postal_code' => \sanitize_text_field( $_POST['postal_code'] ?? '' ),
            'city' => \sanitize_text_field( $_POST['city'] ?? '' ),
            'country' => \sanitize_text_field( $_POST['country'] ?? '' ),
            'company_email' => \sanitize_email( $_POST['company_email'] ?? '' ),
            'company_phone' => \sanitize_text_field( $_POST['company_phone'] ?? '' ),
            'rep_first_name' => \sanitize_text_field( $_POST['rep_first_name'] ?? '' ),
            'rep_last_name' => \sanitize_text_field( $_POST['rep_last_name'] ?? '' ),
            'rep_email' => \sanitize_email( $_POST['rep_email'] ?? '' ),
            'rep_phone' => \sanitize_text_field( $_POST['rep_phone'] ?? '' ),
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? '',
            'terms_accepted' => !empty( $_POST['terms_accepted'] ),
        ];

        /**
         * Delegate to service
         */
        $result = $this->customer_service->register( $data );

        if( $result['success'] ) {
            $this->send_success( [ 
                'message' => $result['message'],
            ] );
        } else {
            $this->send_error( $result['message'] );
        }
    }
}