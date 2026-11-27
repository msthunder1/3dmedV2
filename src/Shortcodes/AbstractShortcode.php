<?php
/**
 * Abstract Shortcode
 *
 * @package ThreeDMed\Shortcodes
 */

namespace ThreeDMed\Shortcodes;

abstract class AbstractShortcode {

	/**
	 * Shortcode tag (e.g., 'threedmed_registration', 'threedmed_login')
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
		\add_shortcode( $this->tag, array( $this, 'render' ) );
	}

	/**
	 * Render the shortcode output
	 *
	 * @param array $atts Shortcode attributes
	 * @return string
	 */
	abstract public function render( $atts = array() );
}
