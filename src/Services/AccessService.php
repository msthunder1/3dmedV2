<?php
/**
 * Access service class
 *
 * @package ThreeDMed
 */

namespace ThreeDMed\Services;

/**
 * Answer who is the current user and what they may access.
 */
class AccessService {

	/**
	 * Check if the user is logged in.
	 *
	 * @return bool True if the user is logged in, false otherwise.
	 */
	public function is_logged_in() {
		return \is_user_logged_in();
	}

	/**
	 * Check if the current user has any of the specified roles.
	 *
	 * @param array $roles An array of role names to check against.
	 * @return bool True if the user has any of the specified roles, false otherwise.
	 */
	public function has_role( array $roles ) {
		$current_user = \wp_get_current_user();
		return ! empty( array_intersect( $current_user->roles, $roles ) );
	}
}
