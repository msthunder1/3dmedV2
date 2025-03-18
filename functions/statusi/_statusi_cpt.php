<?php

/*
** Custom post za STATUSI **
*/
function create_cpt_status() {
	register_post_type( 'statusi',
		array(
			'labels' => array(
				'name' => __( 'Statusi' ),
				'singular_name' => __( 'Status' ),
				'add_new' => __( 'Add New Status' ),
				'add_new_item' => __( 'Add New Status' ),
				'edit_item' => __( 'Edit Status' ),
				'new_item' => __( 'Add New Status' ),
				'view_item' => __( 'View Status' ),
				'search_items' => __( 'Search Status' ),
				'not_found' => __( 'No Status found' ),
				'not_found_in_trash' => __( 'No Statusi found in trash' )
			),
			'public'			=> true,
			'taxonomies'		=> array('post_tag'),
			'supports'			=> array( 'title'),
			'capability_type'	=> 'post',
			'rewrite'			=> array("slug" => "statusi"), // Permalinks format
			'menu_position'		=> 1,
			// 'menu_icon'			=> '/wp-content/uploads/dashicons/popups250x250.png',
		)
	);
}

add_action( 'init', 'create_cpt_status' );

?>