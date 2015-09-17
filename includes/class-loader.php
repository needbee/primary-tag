<?php namespace NeedBee\PrimaryTag;

use NeedBee\PrimaryTag\Controllers\AdminController;
use NeedBee\PrimaryTag\Controllers\PublicController;

class Loader
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
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/controllers/class-admin-controller.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/controllers/class-public-controller.php';
    }

    private function define_admin_hooks()
    {
        $admin = new AdminController;
        add_filter( 'dbx_post_sidebar', array($admin, 'test') );
    }

    private function define_public_hooks()
    {
        $public = new PublicController;
        add_filter( 'the_content', array($public, 'test') );
    }

}