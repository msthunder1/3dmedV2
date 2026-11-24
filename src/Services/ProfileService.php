<?php
/**
 * Profile service class
 *
 * @package ThreeDMed
 */

namespace ThreeDMed\Services;

use ThreeDMed\Repositories\CustomerRepository;
use ThreeDMed\Validators\Validator;

class ProfileService {

	/**
	 * @var \ThreeDMed\Repositories\CustomerRepository
	 */
	protected $customer_repository;

	/**
	 * Constructor
	 *
	 * @param \ThreeDMed\Repositories\CustomerRepository $customer_repository
	 */
	public function __construct( CustomerRepository $customer_repository ) {
		$this->customer_repository = $customer_repository;
	}

	/**
	 * Get the profile data for a given user ID
	 *
	 * @param int $user_id The user ID
	 * @return array|null The profile data or null if not found
	 */
	public function get_profile_data( $user_id ) {
		$user = \get_user_by( 'id', $user_id );
		if ( ! $user ) {
			return null;
		}

		$customer = \get_field( 'id_podjetja', 'user_' . $user_id );
		if ( ! $customer ) {
			return null;
		}
		$customer_id = is_object( $customer ) ? $customer->ID : (int) $customer;

		return array(
			// Representative data (WP user + meta)
			'rep_first_name' => $user->first_name,
			'rep_last_name'  => $user->last_name,
			'rep_email'      => $user->user_email,
			'rep_phone'      => \get_field( 'telefon', 'user_' . $user_id ),

			// Company data (ACF on customer post)
			'customer_id'    => $customer_id,
			'company_name'   => \get_field( 'ime_podjetja', $customer_id ),
			'short_name'     => \get_field( 'kratko_ime', $customer_id ),
			'vat_number'     => \get_field( 'davcna_stevilka', $customer_id ),
			'vat_liable'     => ! empty( \get_field( 'zavezanec_za_ddv', $customer_id ) ),
			'street'         => \get_field( 'naslov', $customer_id ),
			'postal_code'    => \get_field( 'postna_stevilka', $customer_id ),
			'city'           => \get_field( 'kraj', $customer_id ),
			'country'        => \get_field( 'drzava', $customer_id ),
			'company_email'  => \get_field( 'email_podjetja', $customer_id ),
			'company_phone'  => \get_field( 'telefon_podjetja', $customer_id ),
		);
	}

	/**
	 * Update profile for a user
	 *
	 * @param int   $user_id The user ID
	 * @param array $data The profile data to update
	 * @return array Result with success + errors/message
	 */
	public function update_profile( $user_id, $data ) {

		// Validate
		$validator = new Validator();
		$errors = $validator
			->required( 'company_name', $data['company_name'] ?? null, \__( 'Company name is required.', 'threedmed' ) )
			->required( 'vat_number', $data['vat_number'] ?? null, \__( 'VAT number is required.', 'threedmed' ) )
			->required( 'street', $data['street'] ?? null, \__( 'Street is required.', 'threedmed' ) )
			->required( 'postal_code', $data['postal_code'] ?? null, \__( 'Postal code is required.', 'threedmed' ) )
			->required( 'city', $data['city'] ?? null, \__( 'City is required.', 'threedmed' ) )
			->required( 'country', $data['country'] ?? null, \__( 'Country is required.', 'threedmed' ) )
			->required( 'company_email', $data['company_email'] ?? null, \__( 'Company email is required.', 'threedmed' ) )
			->email( 'company_email', $data['company_email'] ?? null, \__( 'Company email is not valid.', 'threedmed' ) )
			->required( 'rep_first_name', $data['rep_first_name'] ?? null, \__( 'First name is required.', 'threedmed' ) )
			->required( 'rep_last_name', $data['rep_last_name'] ?? null, \__( 'Last name is required.', 'threedmed' ) )
			// ->required( 'rep_email', $data['rep_email'] ?? null, \__( 'Email is required.', 'threedmed' ) )
			->getErrors();

		// Password change (optional - only validate if provided)
		if ( ! empty( $data['password'] ) ) {
			$errors = $validator
				->minLength( 'password', $data['password'], 8, \__( 'Password must be at least 8 characters.', 'threedmed' ) )
				->matches( 'password_confirm', $data['password'], $data['password_confirm'] ?? '', \__( 'Password confirmation does not match.', 'threedmed' ) )
				->getErrors();
		}

		if ( ! empty( $errors ) ) {
			return array(
				'success' => false,
				'errors'  => $errors,
			);
		}

		// Get customer ID for this user
		$customer = \get_field( 'id_podjetja', 'user_' . $user_id );
		if ( ! $customer ) {
			return array(
				'success' => false,
				'errors'  => array( 'general' => \__( 'Customer record not found for this user.', 'threedmed' ) ),
			);
		}
		$customer_id = is_object( $customer ) ? $customer->ID : (int) $customer;

		// Update representative (WP user)
		$user_data = array(
			'ID'         => $user_id,
			'first_name' => $data['rep_first_name'],
			'last_name'  => $data['rep_last_name'],
		);

		if ( ! empty( $data['password'] ) ) {
			$user_data['user_pass'] = $data['password'];
		}

		$result = \wp_update_user( $user_data );

		if ( \is_wp_error( $result ) ) {
			return array(
				'success' => false,
				'errors'  => array( 'general' => \__( 'Failed to update user.', 'threedmed' ) ),
			);
		}

		// Update user meta (phone)
		\update_field( 'telefon', $data['rep_phone'], 'user_' . $user_id );

		// Update customer post via repository
		$data['user_id'] = $user_id;

		$meta = $this->customer_repository->map_data_to_meta_public( $data );
		foreach ( $meta as $key => $value ) {
			\update_field( $key, $value, $customer_id );
		}

		// Update the post title if company name changed
		\wp_update_post(
			array(
				'ID'         => $customer_id,
				'post_title' => $data['company_name'],
			)
		);

		return array(
			'success' => true,
			'message' => \__( 'Profile updated successfully.', 'threedmed' ),
		);
	}
}
