<?php
/**
 * Provides miscellaneous utility functions for the plugin.
 *
 * @package  NeedBee\Primary_Tag\Utils
 */

namespace NeedBee\Primary_Tag\Utils;

/**
 * Writes a message to the debug.log file, respecting the WP_DEBUG setting.
 *
 * @param string $log the message to write to the log file.
 *
 * @uses error_log()
 * @uses WP_DEBUG
 * @see  http://www.stumiller.me/sending-output-to-the-wordpress-debug-log/
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
