<?php
/**
 * Script enqueuer
 *
 * @package ThreeDMed\Assets
 */

namespace ThreeDMed\Assets;

use ThreeDMed\Strings\RegistrationStrings;

class ScriptEnqueuer {

    public function init() {
        \add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    public function enqueue_scripts() {

        // Main frontend script
        \wp_enqueue_script(
            'threedmed-main',
            THREEDMED_URL . '/assets/js/frontend/main.js',
            [],
            THREEDMED_VERSION,
            true
        );

        // Validators (shared utility)
        \wp_enqueue_script(
            'threedmed-validators',
            THREEDMED_URL . '/assets/js/frontend/validators.js',
            [],
            THREEDMED_VERSION,
            true
        );

        // Registration script (depends on validators)
        \wp_enqueue_script(
            'threedmed-registration',
            THREEDMED_URL . '/assets/js/frontend/registration.js',
            [ 'threedmed-validators' ],
            THREEDMED_VERSION,
            true
        );

        // Pass PHP data + translated strings to registration JS
        \wp_localize_script(
            'threedmed-registration',
            'threedmedRegistration',
            [
                'ajaxUrl' => \admin_url( 'admin-ajax.php' ),
                'strings' => RegistrationStrings::get(),
            ]
        );
    }
}