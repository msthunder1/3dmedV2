<?php

add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );

function add_loginout_link( $items, $args ) {

	if (is_user_logged_in()) {
		if($args->menu == 1 || $args->menu == 4){
			$items .= '<li><a class="logout" href="'. wp_logout_url( home_url() ) .'"><span class="logout__text">Odjava</span><i class="fas fa-sign-out-alt"></i></a></li>';
		}
	}

	return $items;
}

?>