<?php namespace NeedBee\PrimaryTag\Controllers;

class PublicController extends BaseController
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
		if( is_single() ) {
			$data = array(
				'primary_tag' => $this->primaryTagRepo->getForPost( get_the_ID() ),
			);
			$template = $this->renderPartialToString( 'public/primary-tag', $data );
			$content = $template . $content;
		}
		return $content;
	}

}