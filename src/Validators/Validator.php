<?php

/**
 * Validator class for handling validation logic.
 *
 * @package ThreeDMed\Validators
 */

namespace ThreeDMed\Validators;

class Validator {

	/**
	 * Array to hold validation errors.
	 *
	 * @var array
	 */
	private $errors = array();

	/**
	 * Check if a field is required.
	 *
	 * @param string $field
	 * @param mixed  $value
	 * @param string $message
	 * @return Validator
	 */
	public function required( $field, $value, $message ) {
		if ( empty( $value ) ) {
			$this->addError( $field, $message );
		}
		return $this;
	}

	/**
	 * Check if a field is a valid email.
	 *
	 * @param string $field
	 * @param mixed  $value
	 * @param string $message
	 * @return Validator
	 */
	public function email( $field, $value, $message ) {
		if ( ! \is_email( $value ) ) {
			$this->addError( $field, $message );
		}

		return $this;
	}

	/**
	 * Check if a field meets the minimum length requirement.
	 *
	 * @param string $field
	 * @param mixed  $value
	 * @param int    $length
	 * @param string $message
	 * @return Validator
	 */
	public function minLength( $field, $value, $length, $message ) {
		if ( strlen( $value ) < $length ) {
			$this->addError( $field, $message );
		}

		return $this;
	}

	/**
	 * Check if a field matches another field.
	 *
	 * @param string $field
	 * @param mixed  $value
	 * @param mixed  $otherValue
	 * @param string $message
	 * @return Validator
	 */
	public function matches( $field, $value, $otherValue, $message ) {
		if ( $value !== $otherValue ) {
			$this->addError( $field, $message );
		}

		return $this;
	}

	/**
	 * Check if a field is checked.
	 *
	 * @param string $field
	 * @param mixed  $value
	 * @param string $message
	 * @return Validator
	 */
	public function checked( $field, $value, $message ) {
		if ( ! $value ) {
			$this->addError( $field, $message );
		}

		return $this;
	}

	/**
	 * Check if a field matches a specific pattern.
	 *
	 * @param string $field
	 * @param mixed  $value
	 * @param string $pattern
	 * @param string $message
	 * @return Validator
	 */
	public function pattern( $field, $value, $pattern, $message ) {
		if ( ! empty( $value ) && ! preg_match( $pattern, $value ) ) {
			$this->addError( $field, $message );
		}

		return $this;
	}

	/**
	 * Get the validation errors.
	 *
	 * @return array
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * Add an error message for a specific field.
	 *
	 * @param string $field The field name.
	 * @param string $message The error message.
	 * @return void
	 */
	private function addError( $field, $message ) {
		if ( ! isset( $this->errors[ $field ] ) ) {
			$this->errors[ $field ] = $message;
		}
	}
}
