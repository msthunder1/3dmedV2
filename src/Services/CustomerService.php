<?php
/**
 * Customer service class
 *
 * @package ThreeDMed\Services
 */

namespace ThreeDMed\Services;

use ThreeDMed\Repositories\CustomerRepository;

class CustomerService {

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * Constructor - dependency injection of the CustomerRepository
     *
     * @param CustomerRepository $customerRepository
     */
    public function __construct( CustomerRepository $customerRepository ) {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Register a new customer (creates WP user for representative + customer post + links them)
     *
     * @param array $data Registration data
     * @return array Result with success status and message
     */
    public function register( $data ) {

        // Validate required fields
        $required_fields = [
            'company_name',
            'vat_number',
            'street',
            'postal_code',
            'city',
            'country',
            'company_email',
            'company_phone',
            'rep_first_name',
            'rep_last_name',
            'rep_email',
            'rep_phone',
            'password',
            'password_confirm',
        ];

        foreach ( $required_fields as $field ) {
            if ( empty( $data[ $field ] ) ) {
                return [
                    'success' => false,
                    'message' => \sprintf(
                        \__( 'Missing required field: %s', 'threedmed' ),
                        $field
                    ),
                ];
            }
        }

        // Check terms accepted
        if ( empty( $data['terms_accepted'] ) ) {
            return [
                'success' => false,
                'message' => \__( 'You must accept the terms of use.', 'threedmed' ),
            ];
        }

        // Check passwords match
        if ( $data['password'] !== $data['password_confirm'] ) {
            return [
                'success' => false,
                'message' => \__( 'Passwords do not match.', 'threedmed' ),
            ];
        }

        // Check representative email not already used
        if ( \email_exists( $data['rep_email'] ) ) {
            return [
                'success' => false,
                'message' => \__( 'This representative email is already registered.', 'threedmed' ),
            ];
        }

        // Create WP user for representative
        $user_id = \wp_insert_user( [
            'user_login' => $data['rep_email'],
            'user_email' => $data['rep_email'],
            'user_pass'  => $data['password'],
            'first_name' => $data['rep_first_name'],
            'last_name'  => $data['rep_last_name'],
            'role'       => '3dmed_stranka',
        ] );

        if ( \is_wp_error( $user_id ) ) {
            return [
                'success' => false,
                'message' => \__( 'Failed to create user.', 'threedmed' ),
            ];
        }

        // Save representative meta (phone, company name display)
        \update_field( 'telefon', $data['rep_phone'], 'user_' . $user_id );
        \update_field( 'podjetje', $data['company_name'], 'user_' . $user_id );

        // Add user_id to data so repository can save `zastopnik` field on customer
        $data['user_id']    = $user_id;
        $data['post_title'] = $data['company_name'];

        // Create customer post
        $customer_id = $this->customerRepository->create( $data );

        if ( \is_wp_error( $customer_id ) ) {
            // Rollback: delete the user we just created
            \wp_delete_user( $user_id );

            return [
                'success' => false,
                'message' => \__( 'Failed to create customer.', 'threedmed' ),
            ];
        }

        // Link user to customer post
        \update_field( 'id_podjetja', $customer_id, 'user_' . $user_id );

        return [
            'success'     => true,
            'message'     => \__( 'Registration successful.', 'threedmed' ),
            'user_id'     => $user_id,
            'customer_id' => $customer_id,
        ];
    }
}