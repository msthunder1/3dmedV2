<?php
/**
 * Customer service class
 *
 * @package ThreeDMed\Services
 */

namespace ThreeDMed\Services;

use ThreeDMed\Repositories\CustomerRepository;
use ThreeDMed\Validators\Validator;

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
	 * @return array Result with success status and errors/data
	 */
	public function register( $data ) {

		// Validate all fields
		$validator = new Validator();

		$errors = $validator
			->required( 'company_name', $data['company_name'] ?? null, \__( 'Company name is required.', 'threedmed' ) )
			->required( 'vat_number', $data['vat_number'] ?? null, \__( 'VAT number is required.', 'threedmed' ) )
			->required( 'street', $data['street'] ?? null, \__( 'Street is required.', 'threedmed' ) )
			->required( 'postal_code', $data['postal_code'] ?? null, \__( 'Postal code is required.', 'threedmed' ) )
			->pattern( 'postal_code', $data['postal_code'] ?? '', '/^\d{4}$/', \__( 'Postal code must be 4 digits.', 'threedmed' ) )
			->required( 'city', $data['city'] ?? null, \__( 'City is required.', 'threedmed' ) )
			->required( 'country', $data['country'] ?? null, \__( 'Country is required.', 'threedmed' ) )
			->required( 'company_email', $data['company_email'] ?? null, \__( 'Company email is required.', 'threedmed' ) )
			->email( 'company_email', $data['company_email'] ?? null, \__( 'Company email must be a valid email address.', 'threedmed' ) )
			->required( 'company_phone', $data['company_phone'] ?? null, \__( 'Company phone is required.', 'threedmed' ) )
			->pattern( 'company_phone', $data['company_phone'] ?? '', '/^[\d\s\+\-\(\)]+$/', \__( 'Phone must contain only numbers and +, -, spaces, parentheses.', 'threedmed' ) )
			->required( 'rep_first_name', $data['rep_first_name'] ?? null, \__( "Representative's first name is required.", 'threedmed' ) )
			->required( 'rep_last_name', $data['rep_last_name'] ?? null, \__( "Representative's last name is required.", 'threedmed' ) )
			->required( 'rep_email', $data['rep_email'] ?? null, \__( "Representative's email is required.", 'threedmed' ) )
			->email( 'rep_email', $data['rep_email'] ?? null, \__( "Representative's email must be a valid email address.", 'threedmed' ) )
			->required( 'rep_phone', $data['rep_phone'] ?? null, \__( "Representative's phone is required.", 'threedmed' ) )
			->pattern( 'rep_phone', $data['rep_phone'] ?? '', '/^[\d\s\+\-\(\)]+$/', \__( 'Phone must contain only numbers and +, -, spaces, parentheses.', 'threedmed' ) )
			->required( 'password', $data['password'] ?? null, \__( 'Password is required.', 'threedmed' ) )
			->minLength( 'password', $data['password'] ?? null, 8, \__( 'Password must be at least 8 characters.', 'threedmed' ) )
			->required( 'password_confirm', $data['password_confirm'] ?? null, \__( 'Password confirmation is required.', 'threedmed' ) )
			->matches( 'password_confirm', $data['password'] ?? '', $data['password_confirm'] ?? '', \__( 'Passwords do not match.', 'threedmed' ) )
			->checked( 'terms_accepted', $data['terms_accepted'] ?? false, \__( 'You must accept the terms of use.', 'threedmed' ) )
			->getErrors();

		if ( ! empty( $errors ) ) {
			return array(
				'success' => false,
				'errors'  => $errors,
			);
		}

		// Check representative email not already used
		if ( \email_exists( $data['rep_email'] ) ) {
			return array(
				'success' => false,
				'errors'  => array( 'rep_email' => \__( 'This representative email is already registered.', 'threedmed' ) ),
			);
		}

		// Create WP user for representative
		$user_id = \wp_insert_user(
			array(
				'user_login' => $data['rep_email'],
				'user_email' => $data['rep_email'],
				'user_pass'  => $data['password'],
				'first_name' => $data['rep_first_name'],
				'last_name'  => $data['rep_last_name'],
				'role'       => '3dmed_stranka',
			)
		);

		if ( \is_wp_error( $user_id ) ) {
			return array(
				'success' => false,
				'errors'  => array( 'general' => \__( 'Failed to create user.', 'threedmed' ) ),
			);
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

			return array(
				'success' => false,
				'errors'  => array( 'general' => \__( 'Failed to create customer.', 'threedmed' ) ),
			);
		}

		// Link user to customer post
		\update_field( 'id_podjetja', $customer_id, 'user_' . $user_id );

		return array(
			'success'     => true,
			'message'     => \__( 'Registration successful.', 'threedmed' ),
			'user_id'     => $user_id,
			'customer_id' => $customer_id,
		);
	}
}
