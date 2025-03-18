<?php

/*
** Custom post za EMAILE **
*/
function create_cpt_emaili() {
	register_post_type( 'emaili',
		array(
			'labels' => array(
				'name' => __( 'Emaili' ),
				'singular_name' => __( 'Email' ),
				'add_new' => __( 'Add New Email' ),
				'add_new_item' => __( 'Add New Email' ),
				'edit_item' => __( 'Edit Email' ),
				'new_item' => __( 'Add New Email' ),
				'view_item' => __( 'View Email' ),
				'search_items' => __( 'Search Email' ),
				'not_found' => __( 'No Email found' ),
				'not_found_in_trash' => __( 'No Emaili found in trash' )
			),
			'public'			=> true,
			'taxonomies'		=> array('post_tag'),
			'supports'			=> array( 'title'),
			'capability_type'	=> 'post',
			'rewrite'			=> array("slug" => "emaili"), // Permalinks format
			'menu_position'		=> 1,
			// 'menu_icon'			=> '/wp-content/uploads/dashicons/popups250x250.png',
		)
	);
}

add_action( 'init', 'create_cpt_emaili' );

?>