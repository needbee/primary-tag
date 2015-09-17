<?php

class PrimaryTagPlugin
{

    public function __construct()
    {
        $this->load_dependencies();
    }

    public function init()
    {
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies()
    {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-primary-tag-admin-controller.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-primary-tag-public-controller.php';
    }

    private function define_admin_hooks()
    {
        $admin = new PrimaryTagAdminController;
        add_filter( 'dbx_post_sidebar', array($admin, 'test') );
    }

    private function define_public_hooks()
    {
        $public = new PrimaryTagPublicController;
        add_filter( 'the_content', array($public, 'test') );
    }

}