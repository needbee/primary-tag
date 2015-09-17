<?php namespace NeedBee\PrimaryTag\Controllers;

class PublicController
{

    public function test( $content ) {
        if( is_single() ) {
            $content = '<div>Hello Primary Tag!</div>' . $content;
        }
        return $content;
    }

}