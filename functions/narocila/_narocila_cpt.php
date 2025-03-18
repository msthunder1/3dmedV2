<?php

/*
** Custom post za NAROCILA **
*/
function create_cpt_narocila() {
	register_post_type( 'narocila',
		array(
			'labels' => array(
				'name' => __( 'Naročila' ),
				'singular_name' => __( 'Naročilo' ),
				'add_new' => __( 'Add New Naročilo' ),
				'add_new_item' => __( 'Add New Naročilo' ),
				'edit_item' => __( 'Edit Naročilo' ),
				'new_item' => __( 'Add New Naročilo' ),
				'view_item' => __( 'View Naročilo' ),
				'search_items' => __( 'Search Naročilo' ),
				'not_found' => __( 'No Naročilo found' ),
				'not_found_in_trash' => __( 'No Naročila found in trash' )
			),
			'public'			=> true,
			'taxonomies'		=> array('post_tag'),
			'supports'			=> array( 'title', 'author'),
			'capability_type'	=> 'post',
			'rewrite'			=> array("slug" => "narocila"), // Permalinks format
			'menu_position'		=> 1,
			// 'menu_icon'			=> '/wp-content/uploads/dashicons/popups250x250.png',
		)
	);
}

add_action( 'init', 'create_cpt_narocila' );

?>