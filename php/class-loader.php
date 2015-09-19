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
        if( is_admin() ) {
            $this->define_admin_hooks();
        } else {
            $this->define_public_hooks();
        }
    }

    private function load_dependencies()
    {
        $this->load_classes(array(
            'controllers/class-base-controller',
            'controllers/class-admin-controller',
            'controllers/class-public-controller',
            'class-primary-tag-repository',
        ));
    }

    private function load_classes( array $classes ) {
        foreach( $classes as $class ) {
            require_once plugin_dir_path( dirname( __FILE__ ) )
                . 'php/'.$class.'.php';
        }
    }

    private function define_admin_hooks()
    {
        $admin = new AdminController( $this->version, new PrimaryTagRepository );
        add_action( 'admin_enqueue_scripts', array( $admin, 'add_scripts' ) );
        add_action( 'add_meta_boxes', array($admin, 'add_meta_box') );
        add_action( 'save_post', array($admin, 'save_primary_tag') );
    }

    private function define_public_hooks()
    {
        $public = new PublicController( $this->version, new PrimaryTagRepository );
        add_action( 'wp_enqueue_scripts', array($public, 'add_styles') );
        add_filter( 'the_content', array($public, 'render_primary_tag') );
    }

}