<?php
namespace MBC\inc\brick;
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;
class Initialize extends brick {
	function __construct() {
	}
    /**
     * Init
     *
     * Initialize bricks and set up hooks
     */
    public static function init(){
        // if registering block types is not a function
        if(!function_exists('register_block_type')){
            // Setup error message
            $error_text = sprintf('<strong>bricks</strong> - This plugin will not work as blocks are not available on your wordpress instances');
            // return error
            return _doing_it_wrong( 'bricks::init()', $error_text, self::$version );
        } else {
            Prepare::setup();
            // check if files and folders exist
            if(Prepare::check()){
                Category::set();
                Bricks::finalize();
            } else {
                // Setup error message
                $error_text = sprintf('<strong>bricks</strong> - The folder you have set does not have any bricks. Please check the setup.');
                // return error
                return _doing_it_wrong( 'bricks::check()', $error_text, self::$version );
            }
        } 
    }
}