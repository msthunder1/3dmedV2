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
     * Show a message to the user
     */
    function showMessage(text, type) {
        messagesContainer.textContent = text;
        messagesContainer.className = 'registration__messages registration__messages--' + type;
    }

    /**
     * Clear messages
     */
    function clearMessages() {
        messagesContainer.textContent = '';
        messagesContainer.className = 'registration__messages';
    }

    /**
     * Client-side validation
     */
    function validateForm() {
        const v = window.threedmedValidators;
        const password = form.querySelector('#password').value;
        const passwordConfirm = form.querySelector('#password_confirm').value;
        const terms = form.querySelector('#terms_accepted');

        if (!v.passwordsMatch(password, passwordConfirm)) {
            return strings.passwordsNoMatch;
        }

        if (!v.passwordLength(password, 8)) {
            return strings.passwordTooShort;
        }

        if (!v.isChecked(terms)) {
            return strings.termsRequired;
        }

        return null;
    }

    /**
     * Handle form submission
     */
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        clearMessages();

        const validationError = validateForm();
        if (validationError) {
            showMessage(validationError, 'error');
            return;
        }

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
                showMessage(result.data.message || strings.registrationFailed, 'error');
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