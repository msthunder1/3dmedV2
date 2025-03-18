<?php

function list_delete_user(){

	$user_id = $_POST['user_id'];
	wp_delete_user( $user_id );
	die();

}

add_action( 'wp_ajax_nopriv_list_delete_user', 'list_delete_user' );
add_action( 'wp_ajax_list_delete_user', 'list_delete_user' );

?>