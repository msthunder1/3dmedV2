<?php
/**
 * Order Custom Post Type
 *
 * @package ThreeDMed\CustomPostTypes
 */

namespace ThreeDMed\CustomPostTypes;

/**
 * Order post type
 */
class OrderPostType extends AbstractPostType {
    /**
     * Constructor to set unique values for the post type
     */
    public function __construct() {
        // Set the unique values here
        $this->post_type      = 'narocila';
        $this->post_type_slug = 'narocila';
        $this->menu_position  = 12;
        $this->menu_icon      = 'dashicons-clipboard';
    }

    /**
     * Get post type labels
     *
     * @return array
     */
    protected function get_labels() {
        return [
            'name'               => \__( 'Orders', 'threedmed' ),
            'singular_name'      => \__( 'Order', 'threedmed' ),
            'menu_name'          => \__( 'Orders', 'threedmed' ),
            'add_new'            => \__( 'Add New', 'threedmed' ),
            'add_new_item'       => \__( 'Add New Order', 'threedmed' ),
            'edit_item'          => \__( 'Edit Order', 'threedmed' ),
            'new_item'           => \__( 'New Order', 'threedmed' ),
            'view_item'          => \__( 'View Order', 'threedmed' ),
            'search_items'       => \__( 'Search Orders', 'threedmed' ),
            'not_found'          => \__( 'No orders found', 'threedmed' ),
            'not_found_in_trash' => \__( 'No orders found in trash', 'threedmed' ),
        ];
    }
}