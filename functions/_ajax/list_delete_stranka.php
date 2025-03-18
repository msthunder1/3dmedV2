<?php

function list_delete_stranka(){

	$item_id = $_POST['item_id'];
	$zastopnik_id = $_POST['zastopnik_id'];
	wp_delete_post( $item_id );
	wp_delete_user( $zastopnik_id );
	die();

}

add_action( 'wp_ajax_nopriv_list_delete_stranka', 'list_delete_stranka' );
add_action( 'wp_ajax_list_delete_stranka', 'list_delete_stranka' );

?>