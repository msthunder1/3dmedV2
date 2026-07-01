<?php
/**
 * Material Custom Post Type
 *
 * @package ThreeDMed\CustomPostTypes
 */

namespace ThreeDMed\CustomPostTypes;

/**
 * Material post type
 */
class MaterialPostType extends AbstractPostType {
    /**
     * Constructor to set unique values for the post type
     */
    public function __construct() {
        // Set the unique values here
        $this->post_type      = 'materiali';
        $this->post_type_slug = 'materiali';
        $this->menu_position  = 8;
        $this->menu_icon      = 'dashicons-layout';
    }

    /**
     * Get post type labels
     *
     * @return array
     */
    protected function get_labels() {
        return [
            'name'               => \__( 'Materials', 'threedmed' ),
            'singular_name'      => \__( 'Material', 'threedmed' ),
            'menu_name'          => \__( 'Materials', 'threedmed' ),
            'add_new'            => \__( 'Add New', 'threedmed' ),
            'add_new_item'       => \__( 'Add New Material', 'threedmed' ),
            'edit_item'          => \__( 'Edit Material', 'threedmed' ),
            'new_item'           => \__( 'New Material', 'threedmed' ),
            'view_item'          => \__( 'View Material', 'threedmed' ),
            'search_items'       => \__( 'Search Materials', 'threedmed' ),
            'not_found'          => \__( 'No materials found', 'threedmed' ),
            'not_found_in_trash' => \__( 'No materials found in trash', 'threedmed' ),
        ];
    }
}