<?php namespace NeedBee\PrimaryTag\Repositories;

class PrimaryTagRepository {

    const PRIMARY_TAG_KEY = 'primary_tag';

    public function getForPost( $post_id ) {
        return get_post_meta( $post_id, self::PRIMARY_TAG_KEY, true );
    }

    public function saveForPost( $post_id, $primary_tag ) {
        if( '' === $primary_tag ) {
            delete_post_meta( $post_id, self::PRIMARY_TAG_KEY );
        } else {
            update_post_meta( $post_id, self::PRIMARY_TAG_KEY, $primary_tag );
        }
    }

}