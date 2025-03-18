<?php

function list_storniraj_predracun(){

	$item_id = $_POST['item_id'];
	$narocila = get_field('narocila', $item_id);

	foreach($narocila as $narociloId){
		update_field('status_fakture', 'Odprto', $narociloId);
	}

	wp_delete_post( $item_id );
	die();

}

add_action( 'wp_ajax_nopriv_list_storniraj_predracun', 'list_storniraj_predracun' );
add_action( 'wp_ajax_list_storniraj_predracun', 'list_storniraj_predracun' );

?>