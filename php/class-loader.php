<?php namespace NeedBee\PrimaryTag;

use NeedBee\PrimaryTag\Controllers\AdminController;
use NeedBee\PrimaryTag\Controllers\PublicController;

class Loader
{

    protected $version;

    public function __construct()
    {
        $this->version = '0.1.0';
        $this->load_dependencies();
    }

    public function init()
    {
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies()
    {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'php/controllers/class-base-controller.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'php/controllers/class-admin-controller.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'php/controllers/class-public-controller.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'php/class-primary-tag-repository.php';
    }

    private function define_admin_hooks()
    {
        $admin = new AdminController( $this->version, new PrimaryTagRepository );
        add_filter( 'add_meta_boxes', array($admin, 'add_meta_box') );
        add_filter( 'save_post', array($admin, 'save_primary_tag') );
    }

    private function define_public_hooks()
    {
        $public = new PublicController( $this->version, new PrimaryTagRepository );
        add_filter( 'wp_enqueue_scripts', array($public, 'add_styles') );
        add_filter( 'the_content', array($public, 'render_primary_tag') );
    }

}