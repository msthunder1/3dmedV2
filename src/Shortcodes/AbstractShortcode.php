<?php
/**
 * Abstract Shortcode
 *
 * @package ThreeDMed\Shortcodes
 */

namespace ThreeDMed\Shortcodes;

abstract class AbstractShortcode {

    /**
     * Shortcode tag (e.g., 'registration_form')
     *
     * @var string
     */
    protected $tag;

    /**
     * Register the shortcode with WordPress
     *
     * @return void
     */
    public function init() {
        \add_shortcode( $this->tag, [ $this, 'render' ] );
    }

    /**
     * Render the shortcode output
     *
     * @param array $atts Shortcode attributes
     * @return string
     */
    abstract public function render( $atts = [] );
}