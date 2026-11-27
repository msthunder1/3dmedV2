<?php

/**
 * Login form template
 *
 * @package ThreeDMed
 */
?>

<div class="login">
	<h1 class="login__title">
		<?php \esc_html_e( 'Login', 'threedmed' ); ?>
	</h1>

	<div class="login__messages" id="login-messages" role="alert" aria-live="polite"></div>

	<form class="login__form" id="login-form" novalidate>

		<?php \wp_nonce_field( 'threedmed_login', 'login_nonce' ); ?>

		<div class="form-field">
			<label for="login_email">
				<?php \esc_html_e( 'Email', 'threedmed' ); ?> <span class="required">*</span>
			</label>
			<input type="email" id="login_email" name="email" required>
		</div>

		<div class="form-field">
			<label for="login_password">
				<?php \esc_html_e( 'Password', 'threedmed' ); ?> <span class="required">*</span>
			</label>
			<input type="password" id="login_password" name="password" required>
		</div>

		<div class="form-field form-field--checkbox">
			<label>
				<input type="checkbox" id="login_remember" name="remember" value="1">
				<?php \esc_html_e( 'Remember me', 'threedmed' ); ?>
			</label>
		</div>

		<div class="login__actions">
			<button type="submit" class="button button--primary">
				<?php \esc_html_e( 'Login', 'threedmed' ); ?>
			</button>
		</div>

		<div class="login__links">
			<a href="<?php echo \esc_url( \wp_lostpassword_url() ); ?>">
				<?php \esc_html_e( 'Forgot password?', 'threedmed' ); ?>
			</a>
		</div>

	</form>
</div>