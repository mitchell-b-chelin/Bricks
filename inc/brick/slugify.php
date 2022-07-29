<?php
namespace MBC\inc\brick;
defined( 'ABSPATH' ) || exit;
class Slugify extends brick {
    function __construct(){}
    public static function slugify( $str = '', $glue = '-' ){
        $slug = str_replace( array( '_', '-', '/', ' ' ), $glue, strtolower( remove_accents( $str ) ) );
        $slug = preg_replace( "/[^A-Za-z0-9" . preg_quote( $glue ) . "]/", '', $slug );
        return $slug;
    }
};
