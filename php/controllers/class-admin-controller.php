<?php namespace NeedBee\Primary_Tag\Controllers;

/**
 *
 * @see https://codex.wordpress.org/Function_Reference/add_meta_box
 */
class Admin_Controller extends Base_Controller
{

	const NONCE_KEY = 'primary_tag_meta_box_nonce';

	public function test() {
		echo '<div>Hello Primary Tag Admin!</div>';
	}

	public function add_scripts() {
		wp_enqueue_script( 'primary-tag',
			plugin_dir_url( __FILE__ ) . '../../assets/js/src/primary-tag.js',
			array(),
			$this->version
		);
	}

	public function add_meta_box() {
		add_meta_box(
			'primary-tag-admin',
			'Primary Tag',
			array( $this, 'render_meta_box' ),
			'post',
			'normal',
			'core'
		);
	}

	public function render_meta_box( $post ) {
		wp_nonce_field( 'save_primary_tag', self::NONCE_KEY );

		$data = array(
			'tags' => wp_get_post_tags( $post->ID ),
			'primary_tag' => $this->primary_tag_repo->get_for_post( $post->ID ),
		);
		$this->render_partial( 'admin/meta-box', $data );
	}

	public function save_primary_tag( $post_id ) {
		/*
		 * Check if our nonce is set.
		 *
		 * Sanitizes the post variable to pass code sniffer; not sure if
		 * actually needed.
		 */
		if ( ! isset( $_POST[ self::NONCE_KEY ] )
			|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ self::NONCE_KEY ] ) ), 'save_primary_tag' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_posts', $post_id ) ) {
			return;
		}

		/* OK, it's safe for us to save the data now. */

		// Make sure that it is set.
		if ( ! isset( $_POST['primary_tag'] ) ) {
			return;
		}

		// Sanitize user input.
		$primary_tag_name = sanitize_text_field( wp_unslash( $_POST['primary_tag'] ) );

		// Update the meta field in the database.
		$this->primary_tag_repo->save_for_post( $post_id, $primary_tag_name );
	}
}
