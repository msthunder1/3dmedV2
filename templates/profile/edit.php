<?php
/**
 * Profile edit form template
 *
 * Expects: $profile (array) in scope - from ProfileShortcode::render()
 *
 * @package ThreeDMed
 */

if ( ! isset( $profile ) || ! is_array( $profile ) ) {
	return;
}
?>

<div class="profile">
	<h1 class="profile__title">
		<?php \esc_html_e( 'My Profile', 'threedmed' ); ?>
	</h1>

	<div class="profile__messages" id="profile-messages" role="alert" aria-live="polite"></div>

	<form class="profile__form" id="profile-form" novalidate>

		<?php \wp_nonce_field( 'threedmed_profile_update', 'profile_nonce' ); ?>

		<fieldset class="profile__fieldset">
			<legend><?php \esc_html_e( 'Company Information', 'threedmed' ); ?></legend>

			<div class="form-field">
				<label for="company_name">
					<?php \esc_html_e( 'Company name', 'threedmed' ); ?> <span class="required">*</span>
				</label>
				<input type="text" id="company_name" name="company_name" value="<?php echo \esc_attr( $profile['company_name'] ?? '' ); ?>" required>
			</div>

			<div class="form-field">
				<label for="short_name">
					<?php \esc_html_e( 'Short name', 'threedmed' ); ?>
				</label>
				<input type="text" id="short_name" name="short_name" value="<?php echo \esc_attr( $profile['short_name'] ?? '' ); ?>">
			</div>

			<div class="form-field">
				<label for="vat_number">
					<?php \esc_html_e( 'VAT number', 'threedmed' ); ?> <span class="required">*</span>
				</label>
				<input type="text" id="vat_number" name="vat_number" value="<?php echo \esc_attr( $profile['vat_number'] ?? '' ); ?>" required>
			</div>

			<div class="form-field form-field--checkbox">
				<label>
					<input type="checkbox" id="vat_liable" name="vat_liable" value="1" <?php \checked( ! empty( $profile['vat_liable'] ) ); ?>>
					<?php \esc_html_e( 'VAT liable', 'threedmed' ); ?>
				</label>
			</div>

			<div class="form-field">
				<label for="street">
					<?php \esc_html_e( 'Street & number', 'threedmed' ); ?> <span class="required">*</span>
				</label>
				<input type="text" id="street" name="street" value="<?php echo \esc_attr( $profile['street'] ?? '' ); ?>" required>
			</div>

			<div class="form-field form-field--row">
				<div class="form-field__col">
					<label for="postal_code">
						<?php \esc_html_e( 'Postal code', 'threedmed' ); ?> <span class="required">*</span>
					</label>
					<input type="text" id="postal_code" name="postal_code" value="<?php echo \esc_attr( $profile['postal_code'] ?? '' ); ?>" required>
				</div>

				<div class="form-field__col">
					<label for="city">
						<?php \esc_html_e( 'City', 'threedmed' ); ?> <span class="required">*</span>
					</label>
					<input type="text" id="city" name="city" value="<?php echo \esc_attr( $profile['city'] ?? '' ); ?>" required>
				</div>
			</div>

			<div class="form-field">
				<label for="country">
					<?php \esc_html_e( 'Country', 'threedmed' ); ?> <span class="required">*</span>
				</label>
				<select id="country" name="country" class="js-choices" required>
					<?php
					$country_field = \acf_get_field( 'drzava' );
					$current_country = $profile['country'] ?? '';
					if ( ! empty( $country_field['choices'] ) ) {
						foreach ( $country_field['choices'] as $value => $label ) {
							printf(
								'<option value="%s"%s>%s</option>',
								\esc_attr( $value ),
								\selected( $current_country, $value, false ),
								\esc_html( $label )
							);
						}
					}
					?>
				</select>
			</div>

			<div class="form-field">
				<label for="company_email">
					<?php \esc_html_e( 'Company email', 'threedmed' ); ?> <span class="required">*</span>
				</label>
				<input type="email" id="company_email" name="company_email" value="<?php echo \esc_attr( $profile['company_email'] ?? '' ); ?>" required>
			</div>

			<div class="form-field">
				<label for="company_phone">
					<?php \esc_html_e( 'Company phone', 'threedmed' ); ?> <span class="required">*</span>
				</label>
				<input type="tel" id="company_phone" name="company_phone" value="<?php echo \esc_attr( $profile['company_phone'] ?? '' ); ?>" required>
			</div>
		</fieldset>

		<fieldset class="profile__fieldset">
			<legend><?php \esc_html_e( 'Representative Information', 'threedmed' ); ?></legend>

			<div class="form-field form-field--row">
				<div class="form-field__col">
					<label for="rep_first_name">
						<?php \esc_html_e( 'First name', 'threedmed' ); ?> <span class="required">*</span>
					</label>
					<input type="text" id="rep_first_name" name="rep_first_name" value="<?php echo \esc_attr( $profile['rep_first_name'] ?? '' ); ?>" required>
				</div>

				<div class="form-field__col">
					<label for="rep_last_name">
						<?php \esc_html_e( 'Last name', 'threedmed' ); ?> <span class="required">*</span>
					</label>
					<input type="text" id="rep_last_name" name="rep_last_name" value="<?php echo \esc_attr( $profile['rep_last_name'] ?? '' ); ?>" required>
				</div>
			</div>

			<div class="form-field">
				<label for="rep_email">
					<?php \esc_html_e( 'Email (login)', 'threedmed' ); ?>
				</label>
				<input type="email" id="rep_email" name="rep_email" value="<?php echo \esc_attr( $profile['rep_email'] ?? '' ); ?>" disabled>
				<small><?php \esc_html_e( 'Email cannot be changed here.', 'threedmed' ); ?></small>
			</div>

			<div class="form-field">
				<label for="rep_phone">
					<?php \esc_html_e( 'Representative phone', 'threedmed' ); ?> <span class="required">*</span>
				</label>
				<input type="tel" id="rep_phone" name="rep_phone" value="<?php echo \esc_attr( $profile['rep_phone'] ?? '' ); ?>" required>
			</div>
		</fieldset>

		<fieldset class="profile__fieldset">
			<legend><?php \esc_html_e( 'Change Password (optional)', 'threedmed' ); ?></legend>

			<div class="form-field">
				<label for="password">
					<?php \esc_html_e( 'New password', 'threedmed' ); ?>
				</label>
				<input type="password" id="password" name="password" minlength="8">
				<small><?php \esc_html_e( 'Leave blank to keep current password.', 'threedmed' ); ?></small>
			</div>

			<div class="form-field">
				<label for="password_confirm">
					<?php \esc_html_e( 'Confirm new password', 'threedmed' ); ?>
				</label>
				<input type="password" id="password_confirm" name="password_confirm" minlength="8">
			</div>
		</fieldset>

		<div class="profile__actions">
			<button type="submit" class="button button--primary">
				<?php \esc_html_e( 'Save changes', 'threedmed' ); ?>
			</button>
		</div>

	</form>
</div>
