<?php # -*- coding: utf-8 -*-

namespace Inpsyde\WPRESTStarter\Common;

use WP_REST_Response;

/**
 * Interface for all response data access implementations.
 *
 * @package Inpsyde\WPRESTStarter\Common
 * @since   2.0.0
 */
interface ResponseDataAccess {

	/**
	 * Returns an array holding the data as well as the defined links of the given response object.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Response $response Response object.
	 *
	 * @return array The array holding the data as well as the defined links of the given response object.
	 */
	public function get_data( WP_REST_Response $response );
}
