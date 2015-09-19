<?php namespace NeedBee\PrimaryTag;

class Primary_Tag_Repository {

	const PRIMARY_TAG_KEY = 'primary_tag';

	public function get_for_post( $post_id ) {
		return get_post_meta( $post_id, self::PRIMARY_TAG_KEY, true );
	}

	public function save_for_post( $post_id, $primary_tag ) {
		if ( '' === $primary_tag ) {
			delete_post_meta( $post_id, self::PRIMARY_TAG_KEY );
		} else {
			update_post_meta( $post_id, self::PRIMARY_TAG_KEY, $primary_tag );
		}
	}
}
