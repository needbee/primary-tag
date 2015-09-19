<?php
/**
 * Provides miscellaneous utility functions for the plugin.
 *
 * @package  NeedBee\Primary_Tag\Utils
 */

namespace NeedBee\Primary_Tag\Utils;

/**
 * @uses error_log()
 * @uses WP_DEBUG
 */
function write_log( $log ) {
	if ( true === WP_DEBUG ) {
		if ( is_array( $log ) || is_object( $log ) ) {
			error_log( print_r( $log, true ) );
		} else {
			error_log( $log );
		}
	}
}
