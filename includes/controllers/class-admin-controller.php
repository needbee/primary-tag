<?php namespace NeedBee\PrimaryTag\Controllers;

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

    public function render_meta_box() {
        include plugin_dir_path( __FILE__ ) . '../partials/admin/meta-box.php';
    }

}