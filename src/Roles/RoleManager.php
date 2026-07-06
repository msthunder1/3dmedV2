<?php
/**
 * Role manager for the theme
 *
 * @package ThreeDMed
 */

namespace ThreeDMed\Roles;

/*
 * Manages custom user roles
*/

class RoleManager {

    /**
     * Register hooks
     *
     * @return void
     */
    public function init() {
        \add_action( 'init', [ $this, 'register_roles' ] );
    }

    /**
     * Register custom roles and capabilities
     *
     * @return void
     */
    public function register_roles() {
    
        /*
         * Register custom role: 3D Med Stranka
         * This role is intended for users who are clients of the 3D Med platform.
         * It has basic read capabilities and can be extended with additional capabilities as needed.
         */
        if ( ! \get_role( '3dmed_stranka' ) ) {
            \add_role(
                '3dmed_stranka',
                \__( '3D Med Stranka', 'threedmed' ),
                [ 'read' => true ]
            );
        }
    }
}