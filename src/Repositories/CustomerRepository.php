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
        return [
            // ACF field name       => Form data key
            'ime_podjetja'          => $data['company_name'] ?? '',
            'kratko_ime'            => $data['short_name'] ?? '',
            'davcna_stevilka'       => $data['vat_number'] ?? '',
            'zavezanec_za_ddv'      => ! empty( $data['vat_liable'] ),
            'ulica_in_hisna_stevilka' => $data['street'] ?? '',
            'postna_stevilka'       => $data['postal_code'] ?? '',
            'mesto'                 => $data['city'] ?? '',
            'drzava'                => $data['country'] ?? '',
            'email_podjetja'        => $data['company_email'] ?? '',
            'telefon_podjetja'      => $data['company_phone'] ?? '',
            'zastopnik'             => $data['user_id'] ?? null,
        ];
    }

    /**
     * Find a customer by email
     * 
     * @param string $email The email address to search for
     * @return \WP_Post|null The found customer post or null if not found
     */
    public function findByEmail($email) {
        $args = [
            'post_type'      => $this->post_type,
            'meta_query'     => [
                [
                    'key'     => 'email_podjetja',
                    'value'   => $email,
                    'compare' => '=',
                ],
            ],
            'posts_per_page' => 1,
        ];

        $query = new \WP_Query($args);
        return !empty($query->posts) ? $query->posts[0] : null;
    }
}