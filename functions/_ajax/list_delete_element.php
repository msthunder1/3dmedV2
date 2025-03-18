<?php

function list_delete_element(){
	
}

add_action( 'wp_ajax_nopriv_list_delete_element', 'list_delete_element' );
add_action( 'wp_ajax_list_delete_element', 'list_delete_element' );

?>