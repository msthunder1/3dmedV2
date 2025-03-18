<?php

/*
** Custom post za SEJANJA **
*/
function create_cpt_cenik() {
	register_post_type( 'ceniki',
		array(
			'labels' => array(
				'name' => __( 'Ceniki' ),
				'singular_name' => __( 'Cenik' ),
				'add_new' => __( 'Add New Cenik' ),
				'add_new_item' => __( 'Add New Cenik' ),
				'edit_item' => __( 'Edit Cenik' ),
				'new_item' => __( 'Add New Cenik' ),
				'view_item' => __( 'View Cenik' ),
				'search_items' => __( 'Search Cenik' ),
				'not_found' => __( 'No Cenik found' ),
				'not_found_in_trash' => __( 'No Ceniki found in trash' )
			),
			'public'			=> true,
			'taxonomies'		=> array('post_tag'),
			'supports'			=> array( 'title'),
			'capability_type'	=> 'post',
			'rewrite'			=> array("slug" => "ceniki"), // Permalinks format
			'menu_position'		=> 1,
			// 'menu_icon'			=> '/wp-content/uploads/dashicons/popups250x250.png',
		)
	);
}

add_action( 'init', 'create_cpt_cenik' );

?>