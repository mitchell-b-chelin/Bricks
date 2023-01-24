<?php
namespace MBC\brick;
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;
class Style extends brick {
    function __construct(){}
    /**
     * SCSS Compile
     *
     * Compile SCSS to CSS
     */
    public static function compile($scss){
        // if scss class exists
        if(class_exists('MBC\\inc\\native\\scss')){
            $scss_uncompiled = '';
            if(isset($scss['mixins']) && !empty($scss['mixins'])){
                //foreach mixin
                foreach ($scss['mixins'] as $mixin) {
                    $mixin_contents = @file_get_contents($mixin);
                    if($mixin_contents) $scss_uncompiled .= $mixin_contents;
                }
            }
            //if stylesheets exist
            if(isset($scss['stylesheets']) && !empty($scss['stylesheets'])){
                //foreach stylesheet
                foreach ($scss['stylesheets'] as $stylesheet) {
                    $stylesheet_contents = @file_get_contents($stylesheet);
                    if($stylesheet_contents) $scss_uncompiled .= $stylesheet_contents;
                }
            }
            if(!empty($scss_uncompiled)) return '<style>'.\MBC\inc\native\scss::compile($scss_uncompiled).'</style>';
            else return '';
        }
    }
}