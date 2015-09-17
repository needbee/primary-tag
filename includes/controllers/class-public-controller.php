<?php namespace NeedBee\PrimaryTag\Controllers;

class PublicController
{

    public function render_primary_tag( $content ) {
        if( is_single() ) {
            ob_start();
            include plugin_dir_path( __FILE__ ) . '../partials/public/primary-tag.php';
            $template = ob_get_contents();
            $content = $template . $content;
            ob_end_clean();
        }
        return $content;
    }

}