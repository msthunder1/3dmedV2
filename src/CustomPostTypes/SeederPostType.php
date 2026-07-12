<?php
/**
 * Seeder Custom Post Type
 *
 * @package ThreeDMed\CustomPostTypes
 */

namespace ThreeDMed\CustomPostTypes;

/**
 * Seeder post type
 */
class SeederPostType extends AbstractPostType {
	/**
	 * Constructor to set unique values for the post type
	 */
	public function __construct() {
		// Set the unique values here
		$this->post_type      = 'sejanja';
		$this->post_type_slug = 'sejanja';
		$this->menu_position  = 11;
		$this->menu_icon      = 'dashicons-database';
	}

	/**
	 * Get post type labels
	 *
	 * @return array
	 */
	protected function get_labels() {
		return array(
			'name'               => \__( 'Seeders', 'threedmed' ),
			'singular_name'      => \__( 'Seeder', 'threedmed' ),
			'menu_name'          => \__( 'Seeders', 'threedmed' ),
			'add_new'            => \__( 'Add New', 'threedmed' ),
			'add_new_item'       => \__( 'Add New Seeder', 'threedmed' ),
			'edit_item'          => \__( 'Edit Seeder', 'threedmed' ),
			'new_item'           => \__( 'New Seeder', 'threedmed' ),
			'view_item'          => \__( 'View Seeder', 'threedmed' ),
			'search_items'       => \__( 'Search Seeders', 'threedmed' ),
			'not_found'          => \__( 'No seeders found', 'threedmed' ),
			'not_found_in_trash' => \__( 'No seeders found in trash', 'threedmed' ),
		);
	}
}
