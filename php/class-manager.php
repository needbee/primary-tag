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

	protected $version;

	public function __construct() {
		$this->version = '0.1.0';
		$this->load_dependencies();
	}

	/**
	 * @uses is_admin()
	 */
	public function init() {
		if ( is_admin() ) {
			$this->define_admin_hooks();
		} else {
			$this->define_public_hooks();
		}
	}

	private function load_dependencies() {
		$this->load_classes(array(
			'controllers/class-base-controller',
			'controllers/class-admin-controller',
			'controllers/class-public-controller',
			'class-primary-tag-repository',
		));
	}

	/**
	 * @uses plugin_dir_path()
	 */
	private function load_classes( array $classes ) {
		foreach ( $classes as $class ) {
			require_once plugin_dir_path( dirname( __FILE__ ) )
				. 'php/'.$class.'.php';
		}
	}

	/**
	 * @uses add_action()
	 * @uses add_filter()
	 */
	private function define_admin_hooks() {
		$admin = new Admin_Controller( $this->version, new Primary_Tag_Repository );
		add_action( 'admin_enqueue_scripts', array( $admin, 'add_scripts' ) );
		add_action( 'add_meta_boxes', array( $admin, 'add_meta_box' ) );
		add_action( 'save_post', array( $admin, 'save_primary_tag' ) );
	}

	private function define_public_hooks() {
		$public = new Public_Controller( $this->version, new Primary_Tag_Repository );
		add_action( 'wp_enqueue_scripts', array( $public, 'add_styles' ) );
		add_filter( 'the_content', array( $public, 'render_primary_tag' ) );
	}
}
