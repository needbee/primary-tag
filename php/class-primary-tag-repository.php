<?php namespace NeedBee\Primary_Tag;

class Primary_Tag_Repository {

	const PRIMARY_TAG_KEY = 'primary_tag';

	/**
	 * @uses get_post_meta()
	 * @uses get_term()
	 */
	public function get_for_post( $post_id ) {
		$tag_id = get_post_meta( $post_id, self::PRIMARY_TAG_KEY, true );
		return get_term( $tag_id, 'post_tag' );
	}

	/**
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
