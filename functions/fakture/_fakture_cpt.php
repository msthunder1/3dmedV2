<?php

/*
** Custom post za FAKTURE **
*/
function create_cpt_fakture() {
	register_post_type( 'fakture',
		array(
			'labels' => array(
				'name' => __( 'Fakture' ),
				'singular_name' => __( 'Faktura' ),
				'add_new' => __( 'Add New Faktura' ),
				'add_new_item' => __( 'Add New Faktura' ),
				'edit_item' => __( 'Edit Faktura' ),
				'new_item' => __( 'Add New Faktura' ),
				'view_item' => __( 'View Faktura' ),
				'search_items' => __( 'Search Faktura' ),
				'not_found' => __( 'No Faktura found' ),
				'not_found_in_trash' => __( 'No Fakture found in trash' )
			),
			'public'			=> true,
			'taxonomies'		=> array('post_tag'),
			'supports'			=> array( 'title', 'author'),
			'capability_type'	=> 'post',
			'rewrite'			=> array("slug" => "fakture"), // Permalinks format
			'menu_position'		=> 1,
			// 'menu_icon'			=> '/wp-content/uploads/dashicons/popups250x250.png',
		)
	);
}

add_action( 'init', 'create_cpt_fakture' );

/*
** Add counter option - used for titles - for Fakture **
*/
add_option('fakture__nr', 1);

?>