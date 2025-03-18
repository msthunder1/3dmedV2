<?php

// Function to change email address
 
function wpb_sender_email( $original_email_address ) {

	$var = get_field('email_podjetja', 'option');

    return $var;
}
 
// Function to change sender name
function wpb_sender_name( $original_email_from ) {

	$var = get_field('posiljatelj', 'option');

    return '3Dmed';
}
 
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

?>