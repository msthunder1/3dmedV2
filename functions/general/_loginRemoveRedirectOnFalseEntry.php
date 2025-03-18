<?php

add_action( 'wp_login_failed', 'custom_login_failed' );
function custom_login_failed( $username ) {
	$referrer = wp_get_referer();

	if ( $referrer && ! strstr($referrer, 'wp-login') && ! strstr($referrer,'wp-admin') ) {
		wp_redirect( add_query_arg('login', 'failed', $referrer) );
		exit;
	}
}

add_filter( 'authenticate', 'custom_authenticate_username_password', 30, 3);
function custom_authenticate_username_password( $user, $username, $password )
{
    if ( is_a($user, 'WP_User') ) { return $user; }

    if ( empty($username) || empty($password) )
    {
        $error = new WP_Error();
        $user  = new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Invalid username or incorrect password.'));

        return $error;
    }
}

?>