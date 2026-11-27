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

$user         = wp_get_current_user();
$user_name    = $user->display_name;
$company_id   = function_exists( 'get_field' )
	? get_field( 'id_podjetja', 'user_' . $user->ID )
	: get_user_meta( $user->ID, 'id_podjetja', true );
$company_name = $company_id ? ', ' . get_the_title( $company_id ) : '';
?>

<div class="logged-in-bar">
	<span class="logged-in-bar__label">
		<?php esc_html_e( 'Logged in as:', 'threedmed' ); ?>
	</span>
	<span class="logged-in-bar__name">
		<?php echo esc_html( $user_name . $company_name ); ?>
	</span>
	<a class="button button--secondary logged-in-bar__logout" style="color: #fff;" href="<?php echo esc_url( wp_logout_url() ); ?>">
		<?php esc_html_e( 'Log out', 'threedmed' ); ?>
	</a>
</div>
