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
    public function __construct(CustomerRepository $customerRepository) {
        $this->customerRepository = $customerRepository;
    }

    public function register ($data) {
        // validate required fields
        $requiredFields = ['company_name', 'short_name', 'vat_number', 'street', 'postal_code', 'city', 'country', 'email', 'phone', 'password'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return [
                    'success' => false,
                    'message' => \sprintf(__('Missing required field: %s', 'threedmed'), $field),
                ];
            }
        }

        // Check if email not already used
        if (\email_exists($data['email'])) {
            return [
                'success' => false,
                'message' => \__('Email already exists.', 'threedmed'),
            ];
        }

        // Create WP user with wp_create_user
        $userId = \wp_create_user($data['email'], $data['password'], $data['email']);
        if (\is_wp_error($userId)) {
            return [
                'success' => false,
                'message' => \__('Failed to create user.', 'threedmed'),
            ];
        }

        // Create a new customer post using this->repository->create()
        $data['post_title'] = $data['company_name']; // Set post title to company name
        $customer_id = $this->customerRepository->create($data);

        if(\is_wp_error($customer_id)) {
            // Rollback user creation if customer post creation fails
            \wp_delete_user($userId);
            return [
                'success' => false,
                'message' => \__('Failed to create customer post.', 'threedmed'),
            ];
        }

        // Link them - update_user_meta($user_id, 'id_podjetja', $customer_id)
        \update_user_meta($userId, 'id_podjetja', $customer_id);

        // Set user role to 3dmed_stranka
        $user = new \WP_User($userId);
        $user->set_role('3dmed_stranka');

        // return success / error array
        return [
            'success' => true,
            'message' => \__('Customer registered successfully.', 'threedmed'),
            'user_id' => $userId,
            'customer_post_id' => $customer_id,
        ];
        
    }
}