<?php
/**
 * Registration form template
 *
 * @package ThreeDMed
 */

// Guard: redirect logged-in users
if ( \is_user_logged_in() ) {
/*    
\wp_safe_redirect( \home_url( '/' ) );
    exit;
    */
}
?>

<div class="registration">
    <h1 class="registration__title">
        <?php \esc_html_e( 'New user registration', 'threedmed' ); ?>
    </h1>

    <div class="registration__messages" id="registration-messages" role="alert" aria-live="polite"></div>

    <form class="registration__form" id="registration-form" novalidate>

        <?php \wp_nonce_field( 'threedmed_registration', 'registration_nonce' ); ?>

        <fieldset class="registration__fieldset">
            <legend><?php \esc_html_e( 'Company Information', 'threedmed' ); ?></legend>

            <div class="form-field">
                <label for="company_name">
                    <?php \esc_html_e( 'Company name', 'threedmed' ); ?> <span class="required">*</span>
                </label>
                <input type="text" id="company_name" name="company_name" required>
            </div>

            <div class="form-field">
                <label for="vat_number">
                    <?php \esc_html_e( 'VAT number', 'threedmed' ); ?> <span class="required">*</span>
                </label>
                <input type="text" id="vat_number" name="vat_number" required>
            </div>

            <div class="form-field form-field--checkbox">
                <label>
                    <input type="checkbox" id="vat_liable" name="vat_liable" value="1">
                    <?php \esc_html_e( 'VAT liable', 'threedmed' ); ?>
                </label>
            </div>

            <div class="form-field">
                <label for="street">
                    <?php \esc_html_e( 'Street & number', 'threedmed' ); ?> <span class="required">*</span>
                </label>
                <input type="text" id="street" name="street" required>
            </div>

            <div class="form-field form-field--row">
                <div class="form-field__col">
                    <label for="postal_code">
                        <?php \esc_html_e( 'Postal code', 'threedmed' ); ?> <span class="required">*</span>
                    </label>
                    <input type="text" id="postal_code" name="postal_code" required>
                </div>

                <div class="form-field__col">
                    <label for="city">
                        <?php \esc_html_e( 'City', 'threedmed' ); ?> <span class="required">*</span>
                    </label>
                    <input type="text" id="city" name="city" required>
                </div>
            </div>

            <div class="form-field">
                <label for="country">
                    <?php \esc_html_e( 'Country', 'threedmed' ); ?> <span class="required">*</span>
                </label>
                <input type="text" id="country" name="country" value="Slovenija" required>
            </div>

            <div class="form-field">
                <label for="company_email">
                    <?php \esc_html_e( 'Company email', 'threedmed' ); ?> <span class="required">*</span>
                </label>
                <input type="email" id="company_email" name="company_email" required>
            </div>

            <div class="form-field">
                <label for="company_phone">
                    <?php \esc_html_e( 'Company phone', 'threedmed' ); ?> <span class="required">*</span>
                </label>
                <input type="tel" id="company_phone" name="company_phone" required>
            </div>
        </fieldset>

        <fieldset class="registration__fieldset">
            <legend><?php \esc_html_e( 'Representative Information', 'threedmed' ); ?></legend>

            <div class="form-field form-field--row">
                <div class="form-field__col">
                    <label for="rep_first_name">
                        <?php \esc_html_e( 'First name', 'threedmed' ); ?> <span class="required">*</span>
                    </label>
                    <input type="text" id="rep_first_name" name="rep_first_name" required>
                </div>

                <div class="form-field__col">
                    <label for="rep_last_name">
                        <?php \esc_html_e( 'Last name', 'threedmed' ); ?> <span class="required">*</span>
                    </label>
                    <input type="text" id="rep_last_name" name="rep_last_name" required>
                </div>
            </div>

            <div class="form-field">
                <label for="rep_email">
                    <?php \esc_html_e( 'Representative email (login)', 'threedmed' ); ?> <span class="required">*</span>
                </label>
                <input type="email" id="rep_email" name="rep_email" required>
            </div>

            <div class="form-field">
                <label for="rep_phone">
                    <?php \esc_html_e( 'Representative phone', 'threedmed' ); ?> <span class="required">*</span>
                </label>
                <input type="tel" id="rep_phone" name="rep_phone" required>
            </div>

            <div class="form-field">
                <label for="password">
                    <?php \esc_html_e( 'Password', 'threedmed' ); ?> <span class="required">*</span>
                </label>
                <input type="password" id="password" name="password" required minlength="8">
            </div>

            <div class="form-field">
                <label for="password_confirm">
                    <?php \esc_html_e( 'Confirm password', 'threedmed' ); ?> <span class="required">*</span>
                </label>
                <input type="password" id="password_confirm" name="password_confirm" required minlength="8">
            </div>
        </fieldset>

        <div class="form-field form-field--checkbox">
            <label>
                <input type="checkbox" id="terms_accepted" name="terms_accepted" value="1" required>
                <?php
                printf(
                    /* translators: %s: link to terms of use page */
                    \wp_kses(
                        \__( 'I agree to the <a href="%s" target="_blank">terms of use</a>', 'threedmed' ),
                        [ 'a' => [ 'href' => [], 'target' => [] ] ]
                    ),
                    \esc_url( \home_url( '/splosni-pogoji/' ) )
                );
                ?>
                <span class="required">*</span>
            </label>
        </div>

        <div class="registration__actions">
            <button type="submit" class="button button--primary">
                <?php \esc_html_e( 'Register', 'threedmed' ); ?>
            </button>
        </div>

    </form>
</div>