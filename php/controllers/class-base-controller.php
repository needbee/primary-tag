<?php namespace NeedBee\Primary_Tag\Controllers;

use NeedBee\Primary_Tag\Primary_Tag_Repository;

class Base_Controller
{

	protected $version;

	protected $primary_tag_repo;

	public function __construct( $version, Primary_Tag_Repository $primary_tag_repo ) {
		$this->version = $version;
		$this->primary_tag_repo = $primary_tag_repo;
	}

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
