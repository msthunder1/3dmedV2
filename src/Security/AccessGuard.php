<?php
/**
 * Stands at the door and decides who gets in
 *
 * @package ThreeDMed\Security
 */

namespace ThreeDMed\Security;

use ThreeDMed\Services\AccessService;

/**
 * Redirects visitors who may not view a protected page and the admin area to the login page or home page based on their access level.
 */
class AccessGuard {

	/**
	 * @var AccessService Answers who the user is
	 */
	private $access_service;

	/**
	 * @var array Page slug => allowed roles
	 */
	private $rules;

	/**
	 * @var array Slugs of pages that logged-in users should not see
	 */
	private $guest_only_pages;

	/**
	 * Constructor
	 *
	 * @param AccessService $access_service Answers who the user is
	 * @param array $rules Page slug => allowed roles
	 * @param array $guest_only_pages Slugs of pages that logged-in users should not see
	 */
	public function __construct( AccessService $access_service, array $rules, array $guest_only_pages = array() ) {
		$this->access_service   = $access_service;
		$this->rules            = $rules;
		$this->guest_only_pages = $guest_only_pages;
	}

	/**
	 * Initialize the access guard by hooking into WordPress actions.
	 */
	public function init() {
		\add_action( 'template_redirect', array( $this, 'check_access' ) );
		\add_action( 'admin_init', array( $this, 'block_admin_area' ) );
		\add_filter( 'logout_redirect', array( $this, 'redirect_after_logout' ) );
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

		if ( in_array( $slug, $this->guest_only_pages, true ) && $this->access_service->is_logged_in() ) {
			\wp_safe_redirect( \home_url() );
			exit;
		}

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

	/**
	 * Block access to the admin area for users who are not allowed.
	 *
	 * @return void
	 */
	public function block_admin_area() {

		if ( \wp_doing_ajax() ) {
			return;
		}

		if ( $this->access_service->has_role( array( 'administrator' ) ) ) {
			return;
		}

		\wp_safe_redirect( \home_url() );
		exit;
	}

	/**
	 * Redirect users after logout to the home page.
	 *
	 * @return string The URL to redirect to after logout.
	 */
	public function redirect_after_logout() {
		return \home_url();
	}
}
