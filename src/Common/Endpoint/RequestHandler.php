<?php # -*- coding: utf-8 -*-

declare( strict_types = 1 );

namespace Inpsyde\WPRESTStarter\Common\Endpoint;

use WP_REST_Request;
use WP_REST_Response;

/**
 * Interface for all request handler implementations.
 *
 * @package Inpsyde\WPRESTStarter\Common\Endpoint
 * @since   1.1.0
 */
interface RequestHandler {

	/**
	 * Handles the given request object and returns the according response object.
	 *
	 * @since 1.1.0
	 *
	 * @param WP_REST_Request $request Request object.
	 *
	 * @return WP_REST_Response Response object.
	 */
	public function handle_request( WP_REST_Request $request ): WP_REST_Response;
}
