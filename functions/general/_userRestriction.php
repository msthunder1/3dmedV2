<?php

function hasAccess($roles=''){

	// if $roles are empty, anyone can view the page
	// as long as user is logged in
	$user = wp_get_current_user();

	if(!$user->roles){
		wp_redirect(home_url());
    	exit();
	}

	$userRole = $user->roles[0];

	if($roles){
		if (is_array($roles)){
			foreach($roles as $role){
				if($userRole == $role){
					return true;
				}
			}
		} else {
			if($userRole == $roles){
				return true;
			}
		}

		wp_redirect(home_url());
    	exit();

	} else {
		return true;
	}

}

function user_blockAdmin() {
    if ( is_admin() && ! current_user_can( 'administrator' ) && 
       ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( home_url() );
        exit;
    }
}
add_action( 'init', 'user_blockAdmin' );

function user_logoutRedirect(){
	wp_redirect( home_url() );
	exit();
}
add_action('wp_logout','user_logoutRedirect');


function user_loginRedirect(){

	global $user;
    if (isset( $user->roles ) && is_array( $user->roles )) {

    	if ( in_array( '3dmed_admin', $user->roles ) || in_array( '3dmed_mini_admin', $user->roles ) || in_array( 'administrator', $user->roles ) ) {
    		wp_redirect(home_url());
			exit();
    	} else if (in_array( '3dmed_stranka', $user->roles )){
			$page = get_permalink(29);
			wp_redirect($page);
			exit();
    	}

    }
	
}
add_action('login_redirect','user_loginRedirect');

?>