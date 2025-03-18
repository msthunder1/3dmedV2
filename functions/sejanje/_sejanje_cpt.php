<?php

/*
** Custom post za SEJANJA **
*/
function create_cpt_sejanja() {
	register_post_type( 'sejanja',
		array(
			'labels' => array(
				'name' => __( 'Sejanja' ),
				'singular_name' => __( 'Sejanje' ),
				'add_new' => __( 'Add New Sejanje' ),
				'add_new_item' => __( 'Add New Sejanje' ),
				'edit_item' => __( 'Edit Sejanje' ),
				'new_item' => __( 'Add New Sejanje' ),
				'view_item' => __( 'View Sejanje' ),
				'search_items' => __( 'Search Sejanje' ),
				'not_found' => __( 'No Sejanje found' ),
				'not_found_in_trash' => __( 'No Sejanja found in trash' )
			),
			'public'			=> true,
			'taxonomies'		=> array('post_tag'),
			'supports'			=> array( 'title'),
			'capability_type'	=> 'post',
			'rewrite'			=> array("slug" => "sejanja"), // Permalinks format
			'menu_position'		=> 1,
			// 'menu_icon'			=> '/wp-content/uploads/dashicons/popups250x250.png',
		)
	);
}

add_action( 'init', 'create_cpt_sejanja' );

?>