<?php namespace NeedBee\Primary_Tag\Controllers;

class Public_Controller extends Base_Controller
{

	public function add_styles() {
		wp_enqueue_style(
			'primary-tag',
			plugin_dir_url( __FILE__ ) . '../../assets/css/primary-tag.min.css',
			array(),
			$this->version
		);
	}

	public function render_primary_tag( $content ) {
		if ( is_single() ) {
			$data = array(
				'primary_tag' => $this->primary_tag_repo->get_for_post( get_the_ID() ),
			);
			$template = $this->render_partial_to_string( 'public/primary-tag', $data );
			$content = $template . $content;
		}
		return $content;
	}
}
