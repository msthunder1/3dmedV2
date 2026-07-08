<?php
/**
 * Registration Shortcode
 *
 * @package ThreeDMed\Shortcodes
 */

namespace ThreeDMed\Shortcodes;

class RegistrationShortcode extends AbstractShortcode {

    /**
     * Shortcode tag for the registration form
     *
     * @var string
     */
    protected $tag = 'registration_form';

    /**
     * Render the registration form
     *
     * @param array $atts Shortcode attributes
     * @return string
     */
    public function render( $atts = [] ) {
        // Start output buffering
        \ob_start();

        // Include the registration form template
        include \get_template_directory() . '/templates/forms/registration.php';

        // Return the buffered content
        return \ob_get_clean();
    }
}