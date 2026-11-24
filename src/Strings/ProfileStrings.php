<?php
/**
 * Profile strings
 *
 * @package ThreeDMed\Strings
 */

namespace ThreeDMed\Strings;

class ProfileStrings {
	/**
	 * Get all profile-related strings
	 *
	 * @return array
	 */
	public static function get() {
		return array(
			'save'         => \__( 'Save changes', 'threedmed' ),
			'saving'       => \__( 'Saving...', 'threedmed' ),
			'saveSuccess'  => \__( 'Profile updated successfully.', 'threedmed' ),
			'saveFailed'   => \__( 'Failed to update profile.', 'threedmed' ),
			'networkError' => \__( 'Network error. Please try again.', 'threedmed' ),
		);
	}
}
