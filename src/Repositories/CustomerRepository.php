<?php
/**
 * Customer repository class
 *
 * @package ThreeDMed\Repositories
 */

namespace ThreeDMed\Repositories;

class CustomerRepository extends AbstractRepository {

	/**
	 * The post type associated with this repository
	 *
	 * @var string
	 */
	protected $post_type = 'stranke';

	/**
	 * Map data to post meta fields
	 *
	 * @param array $data The data to map to post meta
	 * @return array
	 */
	protected function mapDataToMeta( $data ) {
		return array(
			'ime_podjetja'     => $data['company_name'] ?? '',
			'kratko_ime'       => $data['short_name'] ?? '',
			'davcna_stevilka'  => $data['vat_number'] ?? '',
			'zavezanec_za_ddv' => ! empty( $data['vat_liable'] ) ? array( '1' ) : array(),
			'naslov'           => $data['street'] ?? '',
			'postna_stevilka'  => $data['postal_code'] ?? '',
			'kraj'             => $data['city'] ?? '',
			'drzava'           => $data['country'] ?? '',
			'email_podjetja'   => $data['company_email'] ?? '',
			'telefon_podjetja' => $data['company_phone'] ?? '',
			'zastopnik'        => $data['user_id'] ?? null,
			'pogoji_uporabe'   => ! empty( $data['terms_accepted'] ) ? array( '1' ) : array(),
		);
	}

	/**
	 * Find a customer by email
	 *
	 * @param string $email The email address to search for
	 * @return \WP_Post|null The found customer post or null if not found
	 */
	public function findByEmail( $email ) {
		$args = array(
			'post_type'      => $this->post_type,
			'meta_query'     => array(
				array(
					'key'     => 'email_podjetja',
					'value'   => $email,
					'compare' => '=',
				),
			),
			'posts_per_page' => 1,
		);

		$query = new \WP_Query( $args );
		return ! empty( $query->posts ) ? $query->posts[0] : null;
	}

	/**
	 * Public wrapper fr mapping data to post meta fields
	 *
	 * @param array $data
	 * @return array
	 */
	public function map_data_to_meta_public( $data ) {
		return $this->mapDataToMeta( $data );
	}
}
