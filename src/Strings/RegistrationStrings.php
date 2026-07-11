<?php
/**
 * Registration strings
 *
 * @package ThreeDMed\Strings
 */

namespace ThreeDMed\Strings;

class RegistrationStrings {

    /**
     * Get all registration-related strings
     *
     * @return array
     */
    public static function get() {
        return [
            'passwordsNoMatch'   => \__( 'Passwords do not match.', 'threedmed' ),
            'passwordTooShort'   => \__( 'Password must be at least 8 characters.', 'threedmed' ),
            'termsRequired'      => \__( 'You must accept the terms of use.', 'threedmed' ),
            'registering'        => \__( 'Registering...', 'threedmed' ),
            'register'           => \__( 'Register', 'threedmed' ),
            'registrationFailed' => \__( 'Registration failed.', 'threedmed' ),
            'networkError'       => \__( 'Network error. Please try again.', 'threedmed' ),
        ];
    }
}