<?php
/**
 * Invoice Custom Post Type
 *
 * @package ThreeDMed\CustomPostTypes
 */

namespace ThreeDMed\CustomPostTypes;

/**
 * Invoice post type
 */
class InvoicePostType extends AbstractPostType {
	/**
	 * Constructor to set unique values for the post type
	 */
	public function __construct() {
		// Set the unique values here
		$this->post_type      = 'fakture';
		$this->post_type_slug = 'fakture';
		$this->menu_position  = 13;
		$this->menu_icon      = 'dashicons-media-document';
	}

	/**
	 * Get post type labels
	 *
	 * @return array
	 */
	protected function get_labels() {
		return array(
			'name'               => \__( 'Invoices', 'threedmed' ),
			'singular_name'      => \__( 'Invoice', 'threedmed' ),
			'menu_name'          => \__( 'Invoices', 'threedmed' ),
			'add_new'            => \__( 'Add New', 'threedmed' ),
			'add_new_item'       => \__( 'Add New Invoice', 'threedmed' ),
			'edit_item'          => \__( 'Edit Invoice', 'threedmed' ),
			'new_item'           => \__( 'New Invoice', 'threedmed' ),
			'view_item'          => \__( 'View Invoice', 'threedmed' ),
			'search_items'       => \__( 'Search Invoices', 'threedmed' ),
			'not_found'          => \__( 'No invoices found', 'threedmed' ),
			'not_found_in_trash' => \__( 'No invoices found in trash', 'threedmed' ),
		);
	}
}
