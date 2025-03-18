<?php

/*
** Custom post za MATERIALI **
*/
function create_cpt_stranke() {
	register_post_type( 'stranke',
		array(
			'labels' => array(
				'name' => __( 'Stranke' ),
				'singular_name' => __( 'Stranka' ),
				'add_new' => __( 'Add New Stranka' ),
				'add_new_item' => __( 'Add New Stranka' ),
				'edit_item' => __( 'Edit Stranka' ),
				'new_item' => __( 'Add New Stranka' ),
				'view_item' => __( 'View Stranka' ),
				'search_items' => __( 'Search Stranka' ),
				'not_found' => __( 'No Stranka found' ),
				'not_found_in_trash' => __( 'No Stranke found in trash' )
			),
			'public'			=> true,
			'taxonomies'		=> array('post_tag'),
			'supports'			=> array( 'title'),
			'capability_type'	=> 'post',
			'rewrite'			=> array("slug" => "stranke"), // Permalinks format
			'menu_position'		=> 1,
			// 'menu_icon'			=> '/wp-content/uploads/dashicons/popups250x250.png',
		)
	);
}

add_action( 'init', 'create_cpt_stranke' );

?>