<?php
/**
 * Pricing Custom Post Type
 *
 * @package ThreeDMed\CustomPostTypes
 */

namespace ThreeDMed\CustomPostTypes;

/**
 * Pricing post type
 */
class PricingPostType extends AbstractPostType {

	/**
	 * Constructor to set unique values for the post type
	 */
	public function __construct() {
		// Set the unique values here
		$this->post_type      = 'ceniki';
		$this->post_type_slug = 'ceniki';
		$this->menu_position  = 6;
		$this->menu_icon      = 'dashicons-money-alt';
	}


	/**
	 * Get post type labels
	 *
	 * @return array
	 */
	protected function get_labels() {
		return array(
			'name'               => \__( 'Price Lists', 'threedmed' ),
			'singular_name'      => \__( 'Price List', 'threedmed' ),
			'menu_name'          => \__( 'Price Lists', 'threedmed' ),
			'add_new'            => \__( 'Add New', 'threedmed' ),
			'add_new_item'       => \__( 'Add New Price List', 'threedmed' ),
			'edit_item'          => \__( 'Edit Price List', 'threedmed' ),
			'new_item'           => \__( 'New Price List', 'threedmed' ),
			'view_item'          => \__( 'View Price List', 'threedmed' ),
			'search_items'       => \__( 'Search Price Lists', 'threedmed' ),
			'not_found'          => \__( 'No price Lists found', 'threedmed' ),
			'not_found_in_trash' => \__( 'No price Lists found in trash', 'threedmed' ),
		);
	}
}
