<?php
/**
 * Status Custom Post Type
 *
 * @package ThreeDMed\CustomPostTypes
 */

namespace ThreeDMed\CustomPostTypes;

/**
 * Status post type
 */
class StatusPostType extends AbstractPostType {
	/**
	 * Constructor to set unique values for the post type
	 */
	public function __construct() {
		// Set the unique values here
		$this->post_type      = 'statusi';
		$this->post_type_slug = 'statusi';
		$this->menu_position  = 5;
		$this->menu_icon      = 'dashicons-flag';
	}

	/**
	 * Get post type labels
	 *
	 * @return array
	 */
	protected function get_labels() {
		return array(
			'name'               => \__( 'Statuses', 'threedmed' ),
			'singular_name'      => \__( 'Status', 'threedmed' ),
			'menu_name'          => \__( 'Statuses', 'threedmed' ),
			'add_new'            => \__( 'Add New', 'threedmed' ),
			'add_new_item'       => \__( 'Add New Status', 'threedmed' ),
			'edit_item'          => \__( 'Edit Status', 'threedmed' ),
			'new_item'           => \__( 'New Status', 'threedmed' ),
			'view_item'          => \__( 'View Status', 'threedmed' ),
			'search_items'       => \__( 'Search Statuses', 'threedmed' ),
			'not_found'          => \__( 'No statuses found', 'threedmed' ),
			'not_found_in_trash' => \__( 'No statuses found in trash', 'threedmed' ),
		);
	}
}
