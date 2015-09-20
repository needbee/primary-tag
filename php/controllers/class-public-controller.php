<?php
/**
 * The Public_Controller class.
 *
 * @package NeedBee\Primary_Tag\Controllers
 */

namespace NeedBee\Primary_Tag\Controllers;

/**
 * Provides all plugin functionality for public screens.
 *
 * This includes displaying and styling the primary tag on the single post
 * screen.
 */
class Public_Controller extends Base_Controller
{

	/**
	 * Sets up CSS needed for public features.
	 *
	 * @return void
	 *
	 * @uses plugin_dir_url()
	 * @uses wp_enqueue_style()
	 */
	public function add_styles() {
		wp_enqueue_style(
			'primary-tag',
			plugin_dir_url( __FILE__ ) . '../../assets/css/primary-tag.min.css',
			array(),
			$this->version
		);
	}

	/**
	 * Renders the primary tag at the top of the post content.
	 *
	 * @param string $content the post content.
	 * @return the content with the primary tag added
	 *
	 * @uses is_single()
	 */
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
