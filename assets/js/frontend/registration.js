/**
 * Registration form handler
 */
(function() {
    'use strict';

    const form = document.getElementById('registration-form');
    if (!form) {
        return;
    }

    const strings = threedmedRegistration.strings;
    const messagesContainer = document.getElementById('registration-messages');
    const submitButton = form.querySelector('button[type="submit"]');

    /**
     * Show a global message (success or general error)
     */
    function showMessage(text, type) {
        messagesContainer.textContent = text;
        messagesContainer.className = 'registration__messages registration__messages--' + type;
    }

    /**
     * Clear all error messages (global + per-field)
     */
    function clearErrors() {
        messagesContainer.textContent = '';
        messagesContainer.className = 'registration__messages';

        // Remove any existing field errors
        form.querySelectorAll('.form-field__error').forEach(el => el.remove());
        form.querySelectorAll('.form-field--has-error').forEach(el => {
            el.classList.remove('form-field--has-error');
        });
    }

    /**
     * Display errors from server (per-field)
     */
    function displayErrors(errors) {
        Object.keys(errors).forEach(fieldName => {
            const message = errors[fieldName];

            // General error - show at top
            if (fieldName === 'general') {
                showMessage(message, 'error');
                return;
            }

            // Find the input field
            const input = form.querySelector('[name="' + fieldName + '"]');
            if (!input) {
                return;
            }

            // Find the parent form-field wrapper
            const wrapper = input.closest('.form-field');
            if (!wrapper) {
                return;
            }

            // Add error class
            wrapper.classList.add('form-field--has-error');

            // Create error message element
            const errorEl = document.createElement('span');
            errorEl.className = 'form-field__error';
            errorEl.textContent = message;
            wrapper.appendChild(errorEl);
        });
    }

    /**
     * Handle form submission
     */
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        clearErrors();

        submitButton.disabled = true;
        submitButton.textContent = strings.registering;

        const formData = new FormData(form);
        formData.append('action', 'threedmed_registration');
        formData.append('nonce', formData.get('registration_nonce'));

        try {
            const response = await fetch(threedmedRegistration.ajaxUrl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });

            const result = await response.json();

            if (result.success) {
                showMessage(result.data.message, 'success');
                form.reset();
            } else {
                // Display all field errors
                if (result.data && result.data.errors) {
                    displayErrors(result.data.errors);
                } else {
                    showMessage(strings.registrationFailed, 'error');
                }
            }
        } catch (error) {
            showMessage(strings.networkError, 'error');
            console.error('Registration error:', error);
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = strings.register;
        }
    });
})();