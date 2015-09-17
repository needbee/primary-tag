<?php

class PrimaryTagPublicController
{

    public function test( $content ) {
        if( is_single() ) {
            $content = '<div>Hello Primary Tag!</div>' . $content;
        }
        return $content;
    }

}