<?php
/**
 * The Primary_Tag_Repository class.
 *
 * @package NeedBee\Primary_Tag\Controllers
 */

namespace NeedBee\Primary_Tag;

/**
 * Provides access to the primary tag data for a post.
 *
 * This is wrapped in a class to isolate the implementation from the rest of
 * the app. This already came in handy when I had to refactor it from storing
 * the tag name to storing the tag ID instead. This class isolated those changes
 * from the rest of the app.
 */
class Primary_Tag_Repository {

	/**
	 * The post meta key to store the primary tag under.
	 *
	 * @var string PRIMARY_TAG_KEY The post meta key to store the primary tag under.
	 */
	const PRIMARY_TAG_KEY = 'primary_tag';

	/**
	 * Gets the primary tag object for a post.
	 *
	 * @param integer $post_id the ID of the post.
	 * @return Term the primary tag object.
	 * @uses get_post_meta()
	 * @uses get_term()
	 */
	public function get_for_post( $post_id ) {
		$tag_id = get_post_meta( $post_id, self::PRIMARY_TAG_KEY, true );
		return get_term( $tag_id, 'post_tag' );
	}

	/**
	 * Saves the primary tag for a post.
	 *
	 * @param integer $post_id the ID of the post.
	 * @param string  $primary_tag_name the name of the primary tag to save.
	 * @return void
	 *
	 * @uses delete_post_meta()
	 * @uses get_term_by()
	 * @uses update_post_meta()
	 */
	public function save_for_post( $post_id, $primary_tag_name ) {
		if ( '' === $primary_tag_name ) {
			delete_post_meta( $post_id, self::PRIMARY_TAG_KEY );
		} else {
			$tag = get_term_by( 'name', $primary_tag_name, 'post_tag' );
			update_post_meta( $post_id, self::PRIMARY_TAG_KEY, $tag->term_id );
		}
	}
}
