<?php namespace NeedBee\PrimaryTag\Controllers;

use NeedBee\PrimaryTag\PrimaryTagRepository;

class BaseController
{

    protected $primaryTagRepo;

    public function __construct( PrimaryTagRepository $primaryTagRepo ) {
        $this->primaryTagRepo = $primaryTagRepo;
    }

}
