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

	/**
	 * Used for cache-busting frontend assets.
	 *
	 * @var string $version the version of the plugin.
	 */
	protected $version;

	/**
	 * Used for cache-busting frontend assets.
	 *
	 * @var NeedBee\Primary_Tag\Primary_Tag_Repository $primary_tag_repo the object for persisting the primary tag.
	 */
	protected $primary_tag_repo;

	/**
	 * Constructs a controller with dependencies.
	 *
	 * @param string                                     $version the version of the plugin.
	 * @param NeedBee\Primary_Tag\Primary_Tag_Repository $primary_tag_repo the object for persisting the primary tag.
	 */
	public function __construct( $version, Primary_Tag_Repository $primary_tag_repo ) {
		$this->version = $version;
		$this->primary_tag_repo = $primary_tag_repo;
	}

	/**
	 * Returns the path to a file in the assets directory.
	 *
	 * Wrapped in a method to avoid having to duplicate file path logic.
	 *
	 * @param string $path the path to the asset starting from the assets directory, including full file name
	 * @return string the absolute asset path for wp_enqueue_style() or wp_enqueue_script()
	 */
	protected function asset_path( $path ) {
		return plugin_dir_url( __FILE__ ) . '../../assets/' . $path;
	}

	/**
	 * Outputs a partial to the browser.
	 *
	 * Wrapped in a method to avoid having to duplicate file path logic, and in
	 * case we switch template engines to Twig or something in the future.
	 *
	 * @param string $path the path to the partial file, not including '/includes/partials/' or '.php'.
	 * @param array  $data the data to pass to the partial, accessible in it under the $data variable.
	 * @return void
	 *
	 * @uses plugin_dir_path()
	 */
	protected function render_partial( $path, $data ) {
		include plugin_dir_path( __FILE__ ) . '../../includes/partials/' . $path . '.php';
	}

	/**
	 * Renders a partial and returns it.
	 *
	 * Wrapped in a method to hide the ugly output-buffer logic, and in case we
	 * switch template engines to Twig or something in the future.
	 *
	 * @param string $path the path to the partial file, not including /includes/partials/ or .php.
	 * @param array  $data the data to pass to the partial, accessible in it under the $data variable.
	 * @return string the rendered partial
	 *
	 * @uses plugin_dir_path()
	 */
	protected function render_partial_to_string( $path, $data ) {
		ob_start();
		$this->render_partial( $path, $data );
		$template = ob_get_contents();
		ob_end_clean();
		return $template;
	}
}
