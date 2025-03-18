<?php

function userRoleBasedHeader(){

	$userLogged = is_user_logged_in();

	if(!$userLogged){
		return;
	}

	// Get current user and its role
	$user = wp_get_current_user();
	$userRole = $user->roles[0];

	if($userRole === '3dmed_stranka'){
		return 'frontend';
	}

	return 'backend';

}

?>