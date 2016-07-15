<?php # -*- coding: utf-8 -*-

namespace Inpsyde\WPRESTStarter\Tests\Integration\Core\Route;

use Inpsyde\WPRESTStarter\Common\Arguments;
use Inpsyde\WPRESTStarter\Common\Endpoint\Handler;
use Inpsyde\WPRESTStarter\Common\Endpoint\Schema;
use Inpsyde\WPRESTStarter\Core\Route\Options as Testee;
use Inpsyde\WPRESTStarter\Tests\TestCase;
use Mockery;

/**
 * Test case for the route options class.
 *
 * @package Inpsyde\WPRESTStarter\Tests\Integration\Core\Route
 * @since   1.0.0
 */
class OptionsTest extends TestCase {

	/**
	 * Tests creating an object, instantiated with an entry according to the given arguments.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::__construct()
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::add_from_arguments()
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::from_arguments()
	 *
	 * @return void
	 */
	public function test_creating_from_arguments() {

		$handler = Mockery::mock( '\Inpsyde\WPRESTStarter\Common\Endpoint\Handler' );

		$args = Mockery::mock( '\Inpsyde\WPRESTStarter\Common\Arguments' );
		$args->shouldReceive( 'to_array' )
			->andReturn( [] );

		$methods = 'some, methods, here';

		/**
		 * @var Handler   $handler
		 * @var Arguments $args
		 */
		$testee = Testee::from_arguments(
			$handler,
			$args,
			$methods,
			[ 'key' => 'value' ]
		);

		$expected = [
			[
				'callback' => [ $handler, 'process' ],
				'args'     => [],
				'methods'  => $methods,
				'key'      => 'value',
			],
		];

		$this->assertEquals( $expected, $testee->to_array() );
	}

	/**
	 * Tests creating an object, instantiated with an entry according to the default arguments.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::__construct()
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::add_from_arguments()
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::from_arguments()
	 *
	 * @return void
	 */
	public function test_creating_from_arguments_defaults() {

		$testee = Testee::from_arguments();

		$expected = [
			[
				'methods' => Testee::DEFAULT_METHODS,
			],
		];

		$this->assertEquals( $expected, $testee->to_array() );
	}

	/**
	 * Tests creating an object, instantiated with an entry according to the given arguments.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::__construct()
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::with_callback()
	 *
	 * @return void
	 */
	public function test_creating_with_callback() {

		$callback = 'some_callback_here';

		$args = [ 'some', 'args', 'here' ];

		$methods = 'some, methods, here';

		$key = 'some value here';

		$testee = Testee::with_callback(
			$callback,
			$args,
			$methods,
			[ 'key' => $key ]
		);

		$expected = [
			compact( 'methods', 'callback', 'args', 'key' ),
		];

		$this->assertEquals( $expected, $testee->to_array() );
	}

	/**
	 * Tests creating an object, instantiated with an entry according to the given arguments.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::__construct()
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::with_callback()
	 *
	 * @return void
	 */
	public function test_creating_with_callback_only() {

		$callback = 'some_callback_here';

		$testee = Testee::with_callback( $callback );

		$expected = [
			[
				'methods'  => Testee::DEFAULT_METHODS,
				'callback' => $callback,
				'args'     => [],
			],
		];

		$this->assertEquals( $expected, $testee->to_array() );
	}

	/**
	 * Tests creating an object, instantiated with an entry according to the given arguments.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::__construct()
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::set_schema()
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::with_schema()
	 *
	 * @return void
	 */
	public function test_creating_with_schema() {

		$schema = Mockery::mock( '\Inpsyde\WPRESTStarter\Common\Endpoint\Schema' );

		/** @var Schema $schema */
		$testee = Testee::with_schema( $schema, [ 'key' => 'value' ] );

		$expected = [
			[
				'key' => 'value',
			],
			'schema' => [ $schema, 'get_schema' ],
		];

		$this->assertEquals( $expected, $testee->to_array() );
	}

	/**
	 * Tests creating an object, instantiated with an entry according to the given arguments.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::__construct()
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::set_schema()
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::with_schema()
	 *
	 * @return void
	 */
	public function test_creating_with_schema_only() {

		$schema = Mockery::mock( '\Inpsyde\WPRESTStarter\Common\Endpoint\Schema' );

		/** @var Schema $schema */
		$testee = Testee::with_schema( $schema );

		$expected = [
			'schema' => [ $schema, 'get_schema' ],
		];

		$this->assertEquals( $expected, $testee->to_array() );
	}

	/**
	 * Tests adding to the options.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::__construct()
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::add()
	 *
	 * @return void
	 */
	public function test_add() {

		$options = [ 'some', 'options', 'here' ];

		$testee = ( new Testee() )->add( $options );

		$expected = [
			$options,
		];

		$this->assertEquals( $expected, $testee->to_array() );
	}

	/**
	 * Tests setting the schema callback.
	 *
	 * @since  1.0.0
	 *
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::__construct()
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::set_schema()
	 * @covers Inpsyde\WPRESTStarter\Core\Route\Options::to_array()
	 *
	 * @return void
	 */
	public function test_set_schema() {

		$schema = Mockery::mock( '\Inpsyde\WPRESTStarter\Common\Endpoint\Schema' );

		$testee = ( new Testee() )->set_schema( $schema );

		$expected = [
			'schema' => [ $schema, 'get_schema' ],
		];

		$this->assertEquals( $expected, $testee->to_array() );
	}
}
