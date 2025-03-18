<?php

/*
** Remove unused user roles **
*/
function remove_unused_roles() {
    remove_role( 'editor' );
    remove_role( 'author' );
    remove_role( 'contributor' );
    remove_role( 'subscriber' );
}
add_action( 'init', 'remove_unused_roles' );

/*
** Change admin name to Super admin **
*/
function change_admin_role_name() {
    global $wp_roles;

    if ( ! isset( $wp_roles ) ){
        $wp_roles = new WP_Roles();
    }
    $wp_roles->roles['administrator']['name'] = 'Super admin';
    $wp_roles->role_names['administrator'] = 'Super admin';           
}
add_action('init', 'change_admin_role_name');

/*
** Add new user roles **
*/

function add_new_user_role($id, $name){
	add_role(
		$id,
		__($name),
		array(
			'read'         => true,
			'edit_posts'   => true,
		)
	);
}

add_new_user_role('3dmed_admin', '3dMed Admin');
add_new_user_role('3dmed_mini_admin', '3dMed Mini Admin');
add_new_user_role('3dmed_stranka', '3dMed Stranka');

?>