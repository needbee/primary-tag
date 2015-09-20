<?php
/**
 * The Manager class.
 *
 * @package NeedBee\Primary_Tag
 */

namespace NeedBee\Primary_Tag;

use NeedBee\Primary_Tag\Controllers\Admin_Controller;
use NeedBee\Primary_Tag\Controllers\Public_Controller;

/**
 * Manages setup of the plugin.
 *
 * This includes loading classes, instantiating and wiring together objects,
 * and setting up actions and filters.
 */
class Manager
{

	/**
	 * Used for cache-busting frontend assets.
	 *
	 * @var string $version the version of the plugin.
	 */
	protected $version;

	/**
	 * Sets up the manager and loads dependencies.
	 *
	 * Doesn't instantiate any classes or tie any hooks; that's done in the
	 * init() method that must be called separately.
	 */
	public function __construct() {
		$this->version = '0.1.0';
		$this->load_dependencies();
	}

	/**
	 * Initializes the plugin by instantiating all classes and tieing hooks.
	 *
	 * @return void
	 * @uses is_admin()
	 */
	public function init() {
		if ( is_admin() ) {
			$this->init_admin();
		} else {
			$this->init_public();
		}
	}

	/**
	 * Instantiates the admin controller and dependencies, and defines all its
	 * hooks.
	 *
	 * @return void
	 * @uses add_action()
	 * @uses add_filter()
	 */
	private function define_admin_hooks() {
		$admin = new Admin_Controller( $this->version, new Primary_Tag_Repository );
		add_action( 'admin_enqueue_scripts', array( $admin, 'add_scripts' ) );
		add_action( 'add_meta_boxes', array( $admin, 'add_meta_box' ) );
		add_action( 'save_post', array( $admin, 'save_primary_tag' ) );
	}

	/**
	 * Instantiates the public controller and dependencies, and defines all its
	 * hooks.
	 *
	 * @return void
	 * @uses add_action()
	 * @uses add_filter()
	 */
	private function define_public_hooks() {
		$public = new Public_Controller( $this->version, new Primary_Tag_Repository );
		add_action( 'wp_enqueue_scripts', array( $public, 'add_styles' ) );
		add_filter( 'the_content', array( $public, 'render_primary_tag' ) );
	}

	/**
	 * Loads all plugin classes into memory.
	 *
	 * This method contains the list of classes; actual loading behavior is
	 * delegated to load_classes().
	 *
	 * @return void
	 */
	private function load_dependencies() {
		$this->load_classes(array(
			'controllers/class-base-controller',
			'controllers/class-admin-controller',
			'controllers/class-public-controller',
			'class-primary-tag-repository',
		));
	}

	/**
	 * Loads a passed-in list of classes into memory.
	 *
	 * Classes are assumed to reside in the /php/ directory. The full path and
	 * file name should be passed, except for the '.php'.
	 *
	 * Abstracted into a function to hide the ugly path logic.
	 *
	 * @param array $classes the list of class filename paths.
	 * @return void
	 *
	 * @uses plugin_dir_path()
	 */
	private function load_classes( array $classes ) {
		foreach ( $classes as $class ) {
			require_once plugin_dir_path( dirname( __FILE__ ) )
				. 'php/'.$class.'.php';
		}
	}
}
