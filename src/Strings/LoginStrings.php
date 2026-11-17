<?php
/**
 * Login strings
 *
 * @package ThreeDMed
 */

namespace ThreeDMed\Strings;

class LoginStrings {
	public static function get_strings() {
		return array(
			'login'        => __( 'Login', 'threedmed' ),
			'loggingIn'    => __( 'Logging In', 'threedmed' ),
			'loginSuccess' => __( 'Login successful. Redirecting...', 'threedmed' ),
			'loginFailed'  => __( 'Login failed. Please try again.', 'threedmed' ),
			'networkError' => __( 'Network error. Please try again.', 'threedmed' ),
		);
	}
}
