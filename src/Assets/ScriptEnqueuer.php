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
		\add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	public function enqueue_scripts() {

		// Main frontend script
		\wp_enqueue_script(
			'threedmed-main',
			THREEDMED_URL . '/assets/js/frontend/main.js',
			array(),
			THREEDMED_VERSION,
			true
		);

		// Validators (shared utility)
		\wp_enqueue_script(
			'threedmed-validators',
			THREEDMED_URL . '/assets/js/frontend/validators.js',
			array(),
			THREEDMED_VERSION,
			true
		);

		// Registration script (depends on validators)
		\wp_enqueue_script(
			'threedmed-registration',
			THREEDMED_URL . '/assets/js/frontend/registration.js',
			array( 'threedmed-validators' ),
			THREEDMED_VERSION,
			true
		);

		// Pass PHP data + translated strings to registration JS
		\wp_localize_script(
			'threedmed-registration',
			'threedmedRegistration',
			array(
				'ajaxUrl' => \admin_url( 'admin-ajax.php' ),
				'strings' => RegistrationStrings::get(),
			)
		);

		// Choices.js library
		\wp_enqueue_script(
			'choices-js',
			'https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/scripts/choices.min.js',
			array(),
			'10.2.0',
			true
		);

		// Choices init (depends on choices-js)
		\wp_enqueue_script(
			'threedmed-choices-init',
			THREEDMED_URL . '/assets/js/frontend/choices-init.js',
			array( 'choices-js' ),
			THREEDMED_VERSION,
			true
		);
	}
}
