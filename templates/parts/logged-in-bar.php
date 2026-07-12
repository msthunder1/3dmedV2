<?php
/**
 * Logged-in user bar
 *
 * Displays current user info in the header.
 *
 * @package ThreeDMed
 */

// Guard: only show for logged-in users.
if ( ! is_user_logged_in() ) {
	return;
}

$current_user = wp_get_current_user();
$user_name    = $current_user->display_name;
$company_id   = function_exists( 'get_field' )
	? get_field( 'id_podjetja', 'user_' . $current_user->ID )
	: get_user_meta( $current_user->ID, 'id_podjetja', true );
$company_name = $company_id ? ', ' . get_the_title( $company_id ) : '';
?>

<div class="logged-in-bar">
	<span class="logged-in-bar__label">
		<?php esc_html_e( 'Logged in as:', 'threedmed' ); ?>
	</span>
	<span class="logged-in-bar__name">
		<?php echo esc_html( $user_name . $company_name ); ?>
	</span>
</div>
