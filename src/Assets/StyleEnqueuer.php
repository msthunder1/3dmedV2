<?php
namespace ThreeDMed\Assets;

class StyleEnqueuer {
    public function init() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            'threedmed-main',
            THREEDMED_URL . '/assets/css/main.css',
            [],
            THREEDMED_VERSION
        );
    }
}