<?php

include_once('_login_checkUser.php');
include_once('_login_form.php');

function login_shortcode() {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

	$isLoggedIn = is_user_logged_in();

	if($isLoggedIn){
		// User is logged in
		// Check what admin he is
		// Display/redirect him to the proper page
		checkUser();
	} else {
		// User isnt logged in
		// Show login form
		showLoginForm();
	}

} ?>