<?php
/**
 * Profile - not logged in state
 *
 * @package ThreeDMed
 */
?>

<div class="profile profile--not-logged-in">
	<p>
		<?php \esc_html_e( 'You must be logged in to view your profile.', 'threedmed' ); ?>
	</p>
	<a href="<?php echo \esc_url( \home_url( '/login/' ) ); ?>" class="button button--primary">
		<?php \esc_html_e( 'Login', 'threedmed' ); ?>
	</a>
</div>