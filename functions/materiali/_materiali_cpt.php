<?php

/*
** Custom post za MATERIALI **
*/
function create_cpt_material() {
	register_post_type( 'materiali',
		array(
			'labels' => array(
				'name' => __( 'Materiali' ),
				'singular_name' => __( 'Material' ),
				'add_new' => __( 'Add New Material' ),
				'add_new_item' => __( 'Add New Material' ),
				'edit_item' => __( 'Edit Material' ),
				'new_item' => __( 'Add New Material' ),
				'view_item' => __( 'View Material' ),
				'search_items' => __( 'Search Material' ),
				'not_found' => __( 'No Material found' ),
				'not_found_in_trash' => __( 'No Materiali found in trash' )
			),
			'public'			=> true,
			'taxonomies'		=> array('post_tag'),
			'supports'			=> array( 'title'),
			'capability_type'	=> 'post',
			'rewrite'			=> array("slug" => "materiali"), // Permalinks format
			'menu_position'		=> 1,
			// 'menu_icon'			=> '/wp-content/uploads/dashicons/popups250x250.png',
		)
	);
}

add_action( 'init', 'create_cpt_material' );

?>