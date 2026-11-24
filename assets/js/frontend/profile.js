/**
 * Profile frm handler
 */

(function () {
    'use strict';

    const form = document.getElementById( 'profile-form' );
    if( !form ) {
        return;
    }

    const strings = threedmedProfile.strings;
    const messagesContainer = document.getElementById( 'profile-messages' );
    const submitButton = form.querySelector( 'button[type="submit"]' );

    /**
     * Show a global message
     */
    function showMessage( text, type ) {
        messagesContainer.textContent = text;
        messagesContainer.className = 'profile__messages profile__messages--' + type;
    }

    /**
     * Clear all errors
     */
    function clearErrors() {
        messagesContainer.textContent = '';
        messagesContainer.className = 'profile__messages';

        form.querySelectorAll( '.form-field__error' ).forEach( el=> el.remove() );
        form.querySelectorAll( '.form-field--has-error' ).forEach( el=> { 
            el.classList.remove( 'form-field--has-error' ) 
        } );
    }

    /**
     * Display per-field errors from server
     */
    function displayFieldErrors( errors ) {
        Object.keys( errors ).forEach( fieldName => {
            const message = errors[ fieldName ];

            if( fieldName === 'general' ) {
                showMessage( message, 'error' );
                return;
            }

            const input = form.querySelector( `[name="${fieldName}"]` );
            if( !input ) {
                return;
            }

            const wrapper = input.closest( '.form-field' );
            if( !wrapper ) {
                console.error( `Wrapper not found for field: ${fieldName}` );
                return;
            }

            wrapper.classList.add( 'form-field--has-error' );

            const errorEl = document.createElement( 'div' );
            errorEl.className = 'form-field__error';
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

        submitButton.disabled = true;
        submitButton.textContent = strings.saving;

        const formData = new FormData( form );
        formData.append( 'action', 'threedmed_profile_update' );
        formData.append( 'nonce', formData.get( 'profile_nonce' ) );

        try {
            const response = await fetch( threedmedProfile.ajaxUrl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
            } );

            const result = await response.json();

            if( result.success ) {
                showMessage( result.data.message || strings.saveSuccess, 'success' );
                // Scroll to top so user sees the success message
                window.scrollTo( { top: 0, behavior: 'smooth' } );
                // Clear password fields after successful save
                form.querySelector( '#password' ).value         = '';
                form.querySelector( '#password_confirm' ).value = '';
            } else {
                if( result.data && result.data.errors ) {
                    displayErrors( result.data.errors );
                } else {
                    showMessage( strings.saveFailed, 'error' );
                }
            }
        } catch ( error ) {
            showMessage( strings.networkError, 'error' );
            console.error( 'Profile update error :', error );
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = strings.save;
        }
    });
} )();
