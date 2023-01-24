<?php
namespace MBC\brick;
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;
class Admin extends brick {
    function __construct(){
        add_action('admin_enqueue_scripts', array($this, 'style'),100);
    }
    private function isGutenberg(){
        $current_screen = get_current_screen();
        if(
            function_exists( 'is_gutenberg_page' ) && is_gutenberg_page() ||
            method_exists($current_screen,'is_block_editor') && $current_screen->is_block_editor()
        ) return true;
        else return false;
    }
    public function style(){
        if ($this->isGutenberg()) {
            //wp_enqueue_style('bricks-admin', BRICKS_ASSETS_DIR . 'css/admin.css', array(), BRICKS_VERSION);
            wp_enqueue_script('bricks-admin', BRICKS_ASSETS_DIR . 'js/bricks.min.js', array('jquery'), BRICKS_VERSION, true);
        }
    }
}