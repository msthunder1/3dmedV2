<?php
/**
 * Dependency Injection Container
 *
 * Simple DI container for managing service dependencies.
 *
 * @package ThreeDMed
 */

namespace ThreeDMed;

/**
 * Container class
 */
class Container {
	/**
	 * Registered services
	 *
	 * @var array
	 */
	private $services = array();

	/**
	 * Service instances (singletons)
	 *
	 * @var array
	 */
	private $instances = array();

	/**
	 * Register a service
	 *
	 * @param string   $name     Service name.
	 * @param callable $callable Factory function.
	 * @return void
	 */
	public function register( $name, $callable ) {
		$this->services[ $name ] = $callable;
	}

	/**
	 * Get a service instance (singleton pattern)
	 *
	 * @param string $name Service name.
	 * @return mixed Service instance.
	 * @throws \Exception If service not found.
	 */
	public function get( $name ) {
		if ( ! isset( $this->instances[ $name ] ) ) {
			if ( ! isset( $this->services[ $name ] ) ) {
				throw new \Exception( sprintf( 'Service "%s" not found in container.', $name ) );
			}
			$this->instances[ $name ] = call_user_func( $this->services[ $name ], $this );
		}

		return $this->instances[ $name ];
	}

	/**
	 * Check if service exists
	 *
	 * @param string $name Service name.
	 * @return bool
	 */
	public function has( $name ) {
		return isset( $this->services[ $name ] );
	}
}
