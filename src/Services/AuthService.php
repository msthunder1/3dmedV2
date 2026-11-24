<?php
/**
 * AuthService class for handling user registration and authentication.
 *
 * @package ThreeDMed\Services
 */

namespace ThreeDMed\Services;

class AuthService {

	public function authenticate( $email, $password, $remember = false ) {

		$credentials = array(
			'user_login'    => $email,
			'user_password' => $password,
			'remember'      => $remember,
		);

		$user = \wp_signon( $credentials, \is_ssl() );

		if ( \is_wp_error( $user ) ) {
			return array(
				'success' => false,
				'errors'  => array( 'general' => \__( 'Invalid email or password.', 'threedmed' ) ),
			);
		}

		return array(
			'success'      => true,
			'redirect_url' => $this->get_redirect_url( $user ),
		);
	}

	private function get_redirect_url( $user ) {
		$roles = $user->roles[0] ?? '';

		switch ( $roles ) {
			case 'administrator':
				return \admin_url();
			case '3dmed_admin':
				return \home_url( '/dashboard/' );
			case '3dmed_stranka':
				return \home_url( '/my-account/' );
			default:
				return \home_url();
		}
	}
}
