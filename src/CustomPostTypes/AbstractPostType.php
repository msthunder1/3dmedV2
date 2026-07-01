<?php

/**
 * Abstract Custom Post Type
 *
 * @package ThreeDMed\CustomPostTypes
 */

namespace ThreeDMed\CustomPostTypes;

abstract class AbstractPostType {
    /**
     * Post type
     *
     * @var string
     */
    protected $post_type;

    /**
     * Post type slug
     *
     * @var string
     */
    protected $post_type_slug;

    
    /**
     * Menu position for the post type in the WordPress admin menu
     *
     * @var int
     */
    protected $menu_position;

    
    /**
     * Menu icon for the post type in the WordPress admin menu
     *
     * @var string
     */
    protected $menu_icon;

    /**
     * Register the post type
     *
     * @return void
     */
    public function register() {
        \add_action( 'init', [ $this, 'register_post_type' ] );
    }

    /**
     * Register post type with WordPress
     *
     * @return void
     */
    public function register_post_type() {
        \register_post_type(
            $this->post_type,
            [
                'labels'              => $this->get_labels(),
                'public'              => true,
                'publicly_queryable'  => true,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'query_var'           => true,
                'rewrite'             => [ 'slug' => $this->post_type_slug ],
                'capability_type'     => 'post',
                'has_archive'         => false,
                'hierarchical'        => false,
                'menu_position'       => $this->menu_position,
                'menu_icon'           => $this->menu_icon,
                'supports'            => [ 'title' ],
                'show_in_rest'        => true,
            ]
        );
    }

    /**
     * Get post type labels
     *
     * @return array
     */
    abstract protected function get_labels();
}
