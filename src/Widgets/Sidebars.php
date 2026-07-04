<?php
/**
 * Sidebar & Widget Areas Registrar
 *
 * @package ThreeDMed\Widgets
 */

namespace ThreeDMed\Widgets;

/**
 * Registers widget areas (sidebars) for the theme
 */
class Sidebars {

    /**
     * Register hooks
     *
     * @return void
     */
    public function init() {
        \add_action( 'widgets_init', [ $this, 'register_sidebars' ] );
    }

    /**
     * Register all sidebars/widget areas
     *
     * @return void
     */
    public function register_sidebars() {
        $sidebars = [
            [
                'id'          => 'footer_column_1',
                'name'        => \__( 'Footer Column 1', 'threedmed' ),
                'description' => \__( 'First column in footer top row.', 'threedmed' ),
            ],
            [
                'id'          => 'footer_column_2',
                'name'        => \__( 'Footer Column 2', 'threedmed' ),
                'description' => \__( 'Second column in footer top row.', 'threedmed' ),
            ],
            [
                'id'          => 'footer_column_3',
                'name'        => \__( 'Footer Column 3', 'threedmed' ),
                'description' => \__( 'Third column in footer top row.', 'threedmed' ),
            ],
            [
                'id'          => 'footer_bottom',
                'name'        => \__( 'Footer Bottom', 'threedmed' ),
                'description' => \__( 'Full-width bottom section (funding info, partners, etc.)', 'threedmed' ),
            ],
        ];

        foreach ( $sidebars as $sidebar ) {
            \register_sidebar( [
                'id'            => $sidebar['id'],
                'name'          => $sidebar['name'],
                'description'   => $sidebar['description'],
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget__title">',
                'after_title'   => '</h3>',
            ] );
        }
    }
}