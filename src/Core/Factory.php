<?php # -*- coding: utf-8 -*-

declare( strict_types = 1 );

namespace Inpsyde\WPRESTStarter\Core;

use Inpsyde\WPRESTStarter\Common;
use Inpsyde\WPRESTStarter\Exception\InvalidClassException;
use InvalidArgumentException;
use ReflectionClass;

/**
 * Generic factory implementation to be used by other factories.
 *
 * @package Inpsyde\WPRESTStarter\Core
 * @since   1.0.0
 */
final class Factory implements Common\Factory {

	/**
	 * @var string
	 */
	private $base;

	/**
	 * @var bool
	 */
	private $base_is_class;

	/**
	 * @var string
	 */
	private $default_class;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @since 1.0.0
	 *
	 * @param string $base          Fully qualified name of the base class or interface.
	 * @param string $default_class Optional. Fully qualified name of the default class. Defaults to $base.
	 *
	 * @throws InvalidArgumentException if the given base is not a valid fully qualified class or interface name.
	 * @throws InvalidArgumentException if no default class is given and the base is an interface.
	 */
	public function __construct( string $base, string $default_class = '' ) {

		$this->base_is_class = class_exists( $base );

		if ( ! ( $this->base_is_class || interface_exists( $base ) ) ) {
			throw new InvalidArgumentException(
				__METHOD__ . ' requires a valid fully qualified class or interface name as first argument.'
			);
		}

		$this->base = $base;

		if ( $default_class ) {
			$this->check_class( $default_class );
			$this->default_class = $default_class;

			return;
		}

		if ( $this->base_is_class ) {
			$this->default_class = $base;

			return;
		}

		throw new InvalidArgumentException(
			__METHOD__ . ' requires a fully qualified class name as first or second argument.'
		);
	}

	/**
	 * Returns a new factory object, instantiated with the given arguments.
	 *
	 * @since 1.0.0
	 * @since 1.1.0 Make use of late static binding (i.e., return a new instance of `static` instead of `self`).
	 *
	 * @param string $base          Fully qualified name of the base class or interface.
	 * @param string $default_class Fully qualified name of the default class.
	 *
	 * @return Factory Factory object.
	 */
	public static function with_default_class( string $base, string $default_class ): Factory {

		return new static( $base, $default_class );
	}

	/**
	 * Returns a new object of the given (or default) class, instantiated with the given arguments.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $args  Optional. Constructor arguments. Defaults to empty array.
	 * @param string $class Optional. Fully qualified class name. Defaults to $this->default_class.
	 *
	 * @return object Object of the given (or default) class, instantiated with the given arguments.
	 */
	public function create( array $args = [], string $class = '' ) {

		if ( $class ) {
			$this->check_class( $class );
		} else {
			$class = $this->default_class;
		}

		switch ( count( $args ) ) {
			case 0:
				return new $class();

			case 1:
				return new $class( $args[0] );
		}

		return ( new ReflectionClass( $class ) )->newInstanceArgs( $args );
	}

	/**
	 * Checks if the class with the given name is valid with respect to the defined base.
	 *
	 * @param string $class FQN of the class to be checked.
	 *
	 * @return void
	 *
	 * @throws InvalidClassException if the class with the given name is invalid with respect to the defined base.
	 */
	private function check_class( string $class ) {

		if (
			! is_subclass_of( $class, $this->base, true )
			&& ( ! $this->base_is_class || $class !== $this->base )
		) {
			throw new InvalidClassException( "{$class} is invalid with respect to the defined base {$this->base}." );
		}
	}
}
