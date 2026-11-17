/**
 * Login form handler
 */
( function () {
	'use strict';

	const form = document.getElementById( 'login-form' );
	if ( ! form ) {
		return;
	}

	const strings           = threedmedLogin.strings;
	const messagesContainer = document.getElementById( 'login-messages' );
	const submitButton      = form.querySelector( 'button[type="submit"]' );

	/**
	 * Show a global message
	 */
	function showMessage( text, type ) {
		messagesContainer.textContent = text;
		messagesContainer.className   = 'login__messages login__messages--' + type;
	}

	/**
	 * Clear all errors
	 */
	function clearErrors() {
		messagesContainer.textContent = '';
		messagesContainer.className   = 'login__messages';

		form.querySelectorAll( '.form-field__error' ).forEach( el => el.remove() );
		form.querySelectorAll( '.form-field--has-error' ).forEach( el => {
			el.classList.remove( 'form-field--has-error' );
		} );
	}

	/**
	 * Display per-field errors from server
	 */
	function displayErrors( errors ) {
		Object.keys( errors ).forEach( fieldName => {
			const message = errors[ fieldName ];

			if ( fieldName === 'general' ) {
				showMessage( message, 'error' );
				return;
			}

			const input = form.querySelector( '[name="' + fieldName + '"]' );
			if ( ! input ) {
				return;
			}

			const wrapper = input.closest( '.form-field' );
			if ( ! wrapper ) {
				return;
			}

			wrapper.classList.add( 'form-field--has-error' );

			const errorEl       = document.createElement( 'span' );
			errorEl.className   = 'form-field__error';
			errorEl.textContent = message;
			wrapper.appendChild( errorEl );
		} );
	}

	/**
	 * Handle form submission
	 */
	form.addEventListener( 'submit', async function ( e ) {
		e.preventDefault();
		clearErrors();

		submitButton.disabled    = true;
		submitButton.textContent = strings.loggingIn;

		const formData = new FormData( form );
		formData.append( 'action', 'threedmed_login' );
		formData.append( 'nonce', formData.get( 'login_nonce' ) );

		try {
			const response = await fetch( threedmedLogin.ajaxUrl, {
				method: 'POST',
				body: formData,
				credentials: 'same-origin',
			} );

			const result = await response.json();

			if ( result.success ) {
				showMessage( strings.loginSuccess, 'success' );
				// Redirect to role-based URL
				if ( result.data && result.data.redirect_url ) {
					window.location.href = result.data.redirect_url;
				}
			} else {
				if ( result.data && result.data.errors ) {
					displayErrors( result.data.errors );
				} else {
					showMessage( strings.loginFailed, 'error' );
				}
			}
		} catch ( error ) {
			showMessage( strings.networkError, 'error' );
			console.error( 'Login error:', error );
		} finally {
			submitButton.disabled    = false;
			submitButton.textContent = strings.login;
		}
	} );
} )();