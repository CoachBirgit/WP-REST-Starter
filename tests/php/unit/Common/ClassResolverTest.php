<?php # -*- coding: utf-8 -*-

namespace Inpsyde\WPRESTStarter\Tests\Unit\Common;

use Inpsyde\WPRESTStarter\Common\Factory\ClassResolver as Testee;
use Inpsyde\WPRESTStarter\Common\Factory\Exception\InvalidClass;
use Inpsyde\WPRESTStarter\Tests\Unit\TestCase;

/**
 * Test case for the class resolver class.
 *
 * @package Inpsyde\WPRESTStarter\Tests\Unit\Common
 * @since   3.0.0
 */
class ClassResolverTest extends TestCase {

	/**
	 * Tests construction with an invalid base fails.
	 *
	 * @since 3.0.0
	 *
	 * @return void
	 */
	public function test_construction_with_invalid_base_fails() {

		self::expectException( \InvalidArgumentException::class );

		new Testee( '\InvalidFQN' );
	}

	/**
	 * Tests construction with an invalid default class fails.
	 *
	 * @since 3.0.0
	 *
	 * @return void
	 */
	public function test_construction_with_invalid_default_class_fails() {

		self::expectException( InvalidClass::class );

		new Testee( '\ArrayAccess', '\InvalidFQN' );
	}

	/**
	 * Tests resolution with an invalid class fails.
	 *
	 * @since 3.0.0
	 *
	 * @return void
	 */
	public function test_resolution_with_invalid_class_fails() {

		self::expectException( InvalidClass::class );

		( new Testee( '\ArrayObject' ) )->resolve( '\InvalidFQN' );
	}

	/**
	 * Tests resolution with no class fails.
	 *
	 * @since 3.0.0
	 *
	 * @return void
	 */
	public function test_resolution_with_no_class_fails() {

		self::expectException( \InvalidArgumentException::class );

		( new Testee( '\ArrayAccess' ) )->resolve();
	}
}
