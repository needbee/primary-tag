<?php
/**
 * The Public_Controller class.
 *
 * @package NeedBee\Primary_Tag\Controllers
 */

namespace NeedBee\Primary_Tag\Controllers;

/**
 * Provides all plugin functionality for admin screens.
 *
 * This includes displaying the primary tag picker meta box and saving the
 * primary tag when chosen from that interface.
 */
class Admin_Controller extends Base_Controller
{

	const NONCE_KEY = 'primary_tag_meta_box_nonce';

	/**
	 * Sets up JavaScript needed for admin features.
	 *
	 * @uses wp_enqueue_script()
	 * @return void
	 */
	public function add_scripts() {
		wp_enqueue_script( 'primary-tag',
			$this->asset_path( 'js/src/primary-tag.js' ),
			array(),
			$this->version
		);
	}

	/**
	 * Hooks up the Primary Tag picker to display as a meta box.
	 *
	 * Ideally, this content would be added to the main Tags box instead of
	 * creating a new one--but that's beyond my WordPress knowledge at the
	 * moment.
	 *
	 * @uses add_meta_box()
	 * @return void
	 */
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

	/**
	 * Displays the Primary Tag picker as a meta box below the editor.
	 *
	 * @param WP_Post $post the post being edited.
	 * @return void
	 *
	 * @uses wp_get_post_tags()
	 * @uses wp_nonce_field()
	 */
	public function render_meta_box( $post ) {
		wp_nonce_field( 'save_primary_tag', self::NONCE_KEY );

		$data = array(
			'tags' => wp_get_post_tags( $post->ID ),
			'primary_tag' => $this->primary_tag_repo->get_for_post( $post->ID ),
		);
		$this->render_partial( 'admin/meta-box', $data );
	}

	/**
	 * Saves the submitted primary tag field for a post.
	 *
	 * This includes removing the primary tag if an empty one was submitted. It
	 * also includes all necessary safety and security checks.
	 *
	 * @param integer $post_id the post being saved.
	 * @global $_POST the post data
	 * @return void
	 *
	 * @uses current_user_can()
	 * @uses sanitize_text_field()
	 * @uses wp_unslash()
	 * @uses wp_verify_nonce()
	 * @uses DOING_AUTOSAVE
	 */
	public function save_primary_tag( $post_id ) {
		/*
		 * Check if our nonce is set correctly.
		 *
		 * Sanitizes the post variable to pass code sniffer; not sure if
		 * actually needed.
		 */
		if ( ! isset( $_POST[ self::NONCE_KEY ] )
			|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ self::NONCE_KEY ] ) ), 'save_primary_tag' ) ) {
			return;
		}

		// Don't save the primary tag during an autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Don't allow the user to save primary tag if user can't edit the post.
		if ( ! current_user_can( 'edit_posts', $post_id ) ) {
			return;
		}

		// Make sure that it is set. Even an empty string counds.
		if ( ! isset( $_POST['primary_tag'] ) ) {
			return;
		}

		// Sanitize user input.
		$primary_tag_name = sanitize_text_field( wp_unslash( $_POST['primary_tag'] ) );

		// Update the meta field in the database.
		$this->primary_tag_repo->save_for_post( $post_id, $primary_tag_name );
	}
}
