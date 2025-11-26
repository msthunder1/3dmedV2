<?php
namespace ThreeDMed\Assets;

class ScriptEnqueuer {
    public function init() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    public function enqueue_scripts() {
        wp_enqueue_script( 'jquery' );
        
        wp_enqueue_script(
            'threedmed-main',
            THREEDMED_URL . '/assets/js/frontend/main.js',
            [],
            THREEDMED_VERSION,
            true
        );
        
        wp_localize_script(
            'threedmed-main',
            'threedmedAjax',
            [
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'nonce'   => wp_create_nonce( 'threedmed_nonce' ),
            ]
        );
    }
}