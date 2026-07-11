/**
 * Form validators
 */
window.threedmedValidators = (function() {
    'use strict';

    return {
        /**
         * Check if passwords match
         */
        passwordsMatch: function(password, confirm) {
            return password === confirm;
        },

        /**
         * Check password length
         */
        passwordLength: function(password, minLength) {
            return password.length >= minLength;
        },

        /**
         * Check if checkbox is checked
         */
        isChecked: function(checkbox) {
            return checkbox && checkbox.checked;
        },

        /**
         * Check valid email format
         */
        isValidEmail: function(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        },

        /**
         * Check if value is non-empty
         */
        isRequired: function(value) {
            return value !== null && value !== undefined && value.trim() !== '';
        }
    };
})();