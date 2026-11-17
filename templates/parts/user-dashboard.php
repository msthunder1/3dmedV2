<?php
/**
 * Logged-in user dashboard view
 * Shown on login page when user is already logged in
 *
 * @package ThreeDMed
 */

$user = wp_get_current_user();
$user_role = $user->roles[0] ?? '';
$display_name = $user->display_name ?? '';

?>

<div class="user-dashboard">

	<div class="user-dashboard__welcome">
		<h1 class="user-dashboard__title">
			<?php
			printf(
				/* translators: %s: user's display name */
				\esc_html__( 'Welcome, %s', 'threedmed' ),
				\esc_html( $display_name )
			);
			?>
		</h1>
	</div>

	<div class="user-dashboard__tiles">

		<?php if ( 'administrator' === $user_role ) : ?>
			<a href="<?php echo \esc_url( \admin_url() ); ?>" class="user-dashboard__tile user-dashboard__tile--admin">
				<span class="user-dashboard__tile-title">
					<?php \esc_html_e( 'WordPress Admin', 'threedmed' ); ?>
				</span>
				<span class="user-dashboard__tile-description">
					<?php \esc_html_e( 'System administration', 'threedmed' ); ?>
				</span>
			</a>
		<?php endif; ?>

		<?php if ( in_array( $user_role, array( 'administrator', '3dmed_admin' ), true ) ) : ?>
			<a href="<?php echo \esc_url( \home_url( '/dashboard/' ) ); ?>" class="user-dashboard__tile user-dashboard__tile--staff">
				<span class="user-dashboard__tile-title">
					<?php \esc_html_e( 'Staff Dashboard', 'threedmed' ); ?>
				</span>
				<span class="user-dashboard__tile-description">
					<?php \esc_html_e( 'Manage orders, customers, invoices', 'threedmed' ); ?>
				</span>
			</a>
		<?php endif; ?>

		<?php if ( '3dmed_stranka' === $user_role ) : ?>
			<a href="<?php echo \esc_url( \home_url( '/moj-racun/' ) ); ?>" class="user-dashboard__tile user-dashboard__tile--customer">
				<span class="user-dashboard__tile-title">
					<?php \esc_html_e( 'My Account', 'threedmed' ); ?>
				</span>
				<span class="user-dashboard__tile-description">
					<?php \esc_html_e( 'View your orders and invoices', 'threedmed' ); ?>
				</span>
			</a>
		<?php endif; ?>

	</div>

	<div class="user-dashboard__actions">
		<a href="<?php echo \esc_url( \wp_logout_url( \home_url() ) ); ?>" class="user-dashboard__logout">
			<?php \esc_html_e( 'Logout', 'threedmed' ); ?>
		</a>
	</div>

</div>
