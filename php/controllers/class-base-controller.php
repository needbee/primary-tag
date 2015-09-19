<?php
/**
 * The Base_Controller class.
 *
 * @package NeedBee\Primary_Tag\Controllers
 */

namespace NeedBee\Primary_Tag\Controllers;

use NeedBee\Primary_Tag\Primary_Tag_Repository;

/**
 * A base class providing support methods and dependencies for controllers.
 *
 * Provides the tag repository for data retrieval, and partial-rendering
 * methods for user interface.
 */
class Base_Controller
{

	protected $version;

	protected $primary_tag_repo;

	public function __construct( $version, Primary_Tag_Repository $primary_tag_repo ) {
		$this->version = $version;
		$this->primary_tag_repo = $primary_tag_repo;
	}

	/**
	 * @uses plugin_dir_path()
	 */
	protected function render_partial( $path, $data ) {
		include plugin_dir_path( __FILE__ ) . '../../includes/partials/' . $path . '.php';
	}

	protected function render_partial_to_string( $path, $data ) {
		ob_start();
		$this->render_partial( $path, $data );
		$template = ob_get_contents();
		ob_end_clean();
		return $template;
	}
}
