<?php namespace NeedBee\PrimaryTag\Controllers;

use NeedBee\PrimaryTag\PrimaryTagRepository;

class BaseController
{

    protected $primaryTagRepo;

    public function __construct( PrimaryTagRepository $primaryTagRepo ) {
        $this->primaryTagRepo = $primaryTagRepo;
    }

    protected function renderPartial( $path, $data ) {
        extract($data);
        include plugin_dir_path( __FILE__ ) . '../../includes/partials/' . $path . '.php';
    }

    protected function renderPartialToString( $path, $data ) {
        ob_start();
        $this->renderPartial($path, $data);
        $template = ob_get_contents();
        ob_end_clean();
        return $template;
    }

}
