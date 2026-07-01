<?php
/**
 * Email Template Custom Post Type
 *
 * @package ThreeDMed\CustomPostTypes
 */

namespace ThreeDMed\CustomPostTypes;

/**
 * Email Template post type
 */
class EmailTemplatePostType extends AbstractPostType {
    /**
     * Constructor to set unique values for the post type
     */
    public function __construct() {
        // Set the unique values here
        $this->post_type      = 'emaili';
        $this->post_type_slug = 'emaili';
        $this->menu_position  = 14;
        $this->menu_icon      = 'dashicons-email-alt';
    }

    /**
     * Get post type labels
     *
     * @return array
     */
    protected function get_labels() {
        return [
            'name'               => \__( 'Email Templates', 'threedmed' ),
            'singular_name'      => \__( 'Email Template', 'threedmed' ),
            'menu_name'          => \__( 'Email Templates', 'threedmed' ),
            'add_new'            => \__( 'Add New', 'threedmed' ),
            'add_new_item'       => \__( 'Add New Email Template', 'threedmed' ),
            'edit_item'          => \__( 'Edit Email Template', 'threedmed' ),
            'new_item'           => \__( 'New Email Template', 'threedmed' ),
            'view_item'          => \__( 'View Email Template', 'threedmed' ),
            'search_items'       => \__( 'Search Email Templates', 'threedmed' ),
            'not_found'          => \__( 'No email templates found', 'threedmed' ),
            'not_found_in_trash' => \__( 'No email templates found in trash', 'threedmed' ),
        ];
    }
}