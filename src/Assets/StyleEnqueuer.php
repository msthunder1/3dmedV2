<?php
namespace ThreeDMed\Assets;

class StyleEnqueuer {
	public function init() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	}

	public function enqueue_styles() {
		\wp_enqueue_style(
			'threedmed-main',
			THREEDMED_URL . '/assets/css/main.css',
			array(),
			THREEDMED_VERSION
		);

		\wp_enqueue_style(
			'choices-js',
			'https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/styles/choices.min.css',
			array(),
			'10.2.0'
		);
	}
}
