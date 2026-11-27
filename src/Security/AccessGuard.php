<?php
/**
 * Stands at the door and decides who gets in
 *
 * @package ThreeDMed\Security
 */

namespace ThreeDMed\Security;

use ThreeDMed\Services\AccessService;

/**
 * Redirects visitors who may not view a protected page to the login page or home page based on their access level.
 */
class AccessGuard {

	/**
	 * @var AccessService Answers who the user is
	 */
	private $access_service;

	/**
	 * @var array
	 */
	private $rules;

	/**
	 * Constructor
	 *
	 * @param AccessService $access_service Answers who the user is
	 * @param array $rules Page slug => allowed roles
	 */
	public function __construct( AccessService $access_service, array $rules ) {
		$this->access_service = $access_service;
		$this->rules          = $rules;
	}

	/**
	 * Initialize the access guard by hooking into WordPress actions.
	 */
	public function init() {
		\add_action( 'template_redirect', array( $this, 'check_access' ) );
	}

	/**
	 * Check if the current user has access based on roles.
	 *
	 * @return void
	 */
	public function check_access() {
		$page = \get_queried_object();

		if ( ! $page instanceof \WP_Post ) {
			return;
		}

		$slug = $page->post_name;

		if ( ! isset( $this->rules[ $slug ] ) ) {
			return;
		}

		if ( ! $this->access_service->is_logged_in() ) {
			\wp_safe_redirect( \home_url( '/login/' ) );
			exit;
		}

		if ( ! $this->access_service->has_role( $this->rules[ $slug ] ) ) {
			\wp_safe_redirect( \home_url() );
			exit;
		}
	}
}
