<?php

function list_delete_item(){

	$item_id = $_POST['item_id'];
	wp_delete_post( $item_id );
	die();

}

add_action( 'wp_ajax_nopriv_list_delete_item', 'list_delete_item' );
add_action( 'wp_ajax_list_delete_item', 'list_delete_item' );

?>