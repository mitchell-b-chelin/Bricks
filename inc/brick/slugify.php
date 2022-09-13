<?php
namespace MBC\inc\brick;
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;
class Slugify extends brick {
    function __construct(){}
    public static function slugify( $str = '', $glue = '-' ){
        $slug = str_replace( array( '_', '-', '/', ' ' ), $glue, strtolower( remove_accents( $str ) ) );
        $slug = preg_replace( "/[^A-Za-z0-9" . preg_quote( $glue ) . "]/", '', $slug );
        return $slug;
    }
};
