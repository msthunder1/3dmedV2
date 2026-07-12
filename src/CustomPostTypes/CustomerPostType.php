<?php
/**
 * Customer Custom Post Type
 *
 * @package ThreeDMed\CustomPostTypes
 */

namespace ThreeDMed\CustomPostTypes;

/**
 * Customer post type
 */
class CustomerPostType extends AbstractPostType {
	/**
	 * Constructor to set unique values for the post type
	 */
	public function __construct() {
		// Set the unique values here
		$this->post_type      = 'stranke';
		$this->post_type_slug = 'stranke';
		$this->menu_position  = 7;
		$this->menu_icon      = 'dashicons-groups';
	}

	/**
	 * Get post type labels
	 *
	 * @return array
	 */
	protected function get_labels() {
		return array(
			'name'               => \__( 'Customers', 'threedmed' ),
			'singular_name'      => \__( 'Customer', 'threedmed' ),
			'menu_name'          => \__( 'Customers', 'threedmed' ),
			'add_new'            => \__( 'Add New', 'threedmed' ),
			'add_new_item'       => \__( 'Add New Customer', 'threedmed' ),
			'edit_item'          => \__( 'Edit Customer', 'threedmed' ),
			'new_item'           => \__( 'New Customer', 'threedmed' ),
			'view_item'          => \__( 'View Customer', 'threedmed' ),
			'search_items'       => \__( 'Search Customers', 'threedmed' ),
			'not_found'          => \__( 'No customers found', 'threedmed' ),
			'not_found_in_trash' => \__( 'No customers found in trash', 'threedmed' ),
		);
	}
}
