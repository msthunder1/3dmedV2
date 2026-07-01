<?php
/**
 * ColorCnc Custom Post Type
 *
 * @package ThreeDMed\CustomPostTypes
 */

namespace ThreeDMed\CustomPostTypes;

/**
 * ColorCnc post type
 */
class ColorCncPostType extends AbstractPostType {
    /**
     * Constructor to set unique values for the post type
     */
    public function __construct() {
        // Set the unique values here
        $this->post_type      = 'barvezarezkanje';
        $this->post_type_slug = 'barvezarezkanje';
        $this->menu_position  = 10;
        $this->menu_icon      = 'dashicons-art';
    }

    /**
     * Get post type labels
     *
     * @return array
     */
    protected function get_labels() {
        return [
            'name'               => \__( 'Cnc Colors', 'threedmed' ),
            'singular_name'      => \__( 'Cnc Color', 'threedmed' ),
            'menu_name'          => \__( 'Cnc Colors', 'threedmed' ),
            'add_new'            => \__( 'Add New', 'threedmed' ),
            'add_new_item'       => \__( 'Add New Cnc Color', 'threedmed' ),
            'edit_item'          => \__( 'Edit Cnc Color', 'threedmed' ),
            'new_item'           => \__( 'New Cnc Color', 'threedmed' ),
            'view_item'          => \__( 'View Cnc Color', 'threedmed' ),
            'search_items'       => \__( 'Search Cnc Colors', 'threedmed' ),
            'not_found'          => \__( 'No cnc colors found', 'threedmed' ),
            'not_found_in_trash' => \__( 'No cnc colors found in trash', 'threedmed' ),
        ];
    }
}