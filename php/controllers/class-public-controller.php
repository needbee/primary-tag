<?php namespace NeedBee\PrimaryTag\Controllers;

class PublicController extends BaseController
{

    public function add_styles() {
        wp_enqueue_style( 'primary-tag', plugins_url() . '/primary-tag/assets/css/primary-tag.css' );
    }

    public function render_primary_tag( $content ) {
        if( is_single() ) {
            $primary_tag = $this->primaryTagRepo->getForPost( get_the_ID() );

            ob_start();
            include plugin_dir_path( __FILE__ ) . '../../includes/partials/public/primary-tag.php';
            $template = ob_get_contents();
            $content = $template . $content;
            ob_end_clean();
        }
        return $content;
    }

}