<?php
/**
 * MaterialCnc Custom Post Type
 *
 * @package ThreeDMed\CustomPostTypes
 */

namespace ThreeDMed\CustomPostTypes;

/**
 * Material post type
 */
class MaterialCncPostType extends AbstractPostType {
    /**
     * Constructor to set unique values for the post type
     */
    public function __construct() {
        // Set the unique values here
        $this->post_type      = 'materializarezkanje';
        $this->post_type_slug = 'materializarezkanje';
        $this->menu_position  = 9;
        $this->menu_icon      = 'dashicons-hammer';
    }

    /**
     * Get post type labels
     *
     * @return array
     */
    protected function get_labels() {
        return [
            'name'               => \__( 'Cnc Materials', 'threedmed' ),
            'singular_name'      => \__( 'Cnc Material', 'threedmed' ),
            'menu_name'          => \__( 'Cnc Materials', 'threedmed' ),
            'add_new'            => \__( 'Add New', 'threedmed' ),
            'add_new_item'       => \__( 'Add New Cnc Material', 'threedmed' ),
            'edit_item'          => \__( 'Edit Cnc Material', 'threedmed' ),
            'new_item'           => \__( 'New Cnc Material', 'threedmed' ),
            'view_item'          => \__( 'View Cnc Material', 'threedmed' ),
            'search_items'       => \__( 'Search Cnc Materials', 'threedmed' ),
            'not_found'          => \__( 'No cnc materials found', 'threedmed' ),
            'not_found_in_trash' => \__( 'No cnc materials found in trash', 'threedmed' ),
        ];
    }
}