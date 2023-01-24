<?php
namespace MBC\brick;
use Composer\Installers\Plugin;
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;
class Initialize extends brick {
    function __construct(){
    }
    /**
     * Initialize the plugin
     * 
     * @since 1.0
     * @return void
     */
    public static function init(){
        Prepare::setup();
        if(!Prepare::check()) return;
        Category::set();
        Bricks::finalize();
    }
}