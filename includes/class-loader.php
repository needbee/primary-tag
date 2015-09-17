<?php namespace NeedBee\PrimaryTag;

use NeedBee\PrimaryTag\Controllers\AdminController;
use NeedBee\PrimaryTag\Controllers\PublicController;
use NeedBee\PrimaryTag\Repositories\PrimaryTagRepository;

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
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/repositories/class-primary-tag-repository.php';
    }

    private function define_admin_hooks()
    {
        $admin = new AdminController( new PrimaryTagRepository );
        add_filter( 'add_meta_boxes', array($admin, 'add_meta_box') );
        add_filter( 'save_post', array($admin, 'save_primary_tag') );
    }

    private function define_public_hooks()
    {
        $public = new PublicController( new PrimaryTagRepository );
        add_filter( 'the_content', array($public, 'render_primary_tag') );
    }

}