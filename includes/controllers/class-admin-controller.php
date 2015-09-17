<?php namespace NeedBee\PrimaryTag\Controllers;

/**
 *
 * @see https://codex.wordpress.org/Function_Reference/add_meta_box
 */
class AdminController
{

    public function test() {
        echo '<div>Hello Primary Tag Admin!</div>';
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
        wp_nonce_field( 'save_primary_tag', 'primary_tag_meta_box_nonce' );

        $tags = wp_get_post_tags( $post->ID );
        $primary_tag = get_post_meta( $post->ID, 'primary_tag', true );

        include plugin_dir_path( __FILE__ ) . '../partials/admin/meta-box.php';
    }

    public function save_primary_tag( $post_id ) {
        // Check if our nonce is set.
        if ( ! isset( $_POST['primary_tag_meta_box_nonce'] ) ) {
            pt_write_log('a');
            return;
        }

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $_POST['primary_tag_meta_box_nonce'], 'save_primary_tag' ) ) {
            pt_write_log('b');
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            pt_write_log('c');
            return;
        }

        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                pt_write_log('d');
                return;
            }

        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                pt_write_log('e');
                return;
            }
        }

        /* OK, it's safe for us to save the data now. */

        // Make sure that it is set.
        if ( ! isset( $_POST['primary_tag'] ) ) {
            pt_write_log('f');
            return;
        }

        // Sanitize user input.
        $my_data = sanitize_text_field( $_POST['primary_tag'] );

        // Update the meta field in the database.
        update_post_meta( $post_id, 'primary_tag', $my_data );
    }

}