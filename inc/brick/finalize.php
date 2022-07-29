<?php
namespace MBC\inc\brick;
defined( 'ABSPATH' ) || exit;
class Bricks extends brick {
    function __construct(){}
    /**
     * Finalize
     *
     * Finalize brick registeration
     */
    public static function finalize(){
        /* enqueue vue core */
        $vue = array(
            'enabled' => self::$vue_enabled,
            'setup' => self::$default_setup['vue']
        );
        // if vue is enabled
        $func = function() use ($vue){
            if($vue['enabled']){
                // switch version of vue
                switch($vue['setup']['version']){
                    case '3':
                        // enqueue vue 3 core on environment
                        $control = $vue['setup']['enviroment'] === 'production' ? 'vue.global.prod' : 'vue.global';
                        wp_enqueue_script("wp-docsify-vue3-core-".$vue['setup']['enviroment'], "https://cdn.jsdelivr.net/npm/vue@3/dist/$control.js", array( 'jquery' ) );
                        break;
                    case '2':
                        // enqueue vue 2 core on environment
                        $control = $vue['setup']['enviroment'] === 'production' ? 'vue.min' : 'vue';
                        wp_enqueue_script("wp-docsify-vue2-core-".$vue['setup']['enviroment'], "https://cdn.jsdelivr.net/npm/vue@2/dist/$control.js", array( 'jquery' ) );
                        break;
                }
            }
        };
        // Add Vue Core into WordPress
        add_action('wp_enqueue_scripts', $func );
        add_action( 'admin_enqueue_scripts', $func );
        // check implementation mode
        switch(self::$mode){
            case 'bricks':
                //brick Javascript Class Method
                add_action('admin_head', function(){
                    // Sprintf window.bricks 
                    $script = "<script type='text/javascript'>window.bricks = { blocks: %s, nonce: '%s'}</script>";
                    // bricks array
                    $bricks = array();
                    // Foreach brick as bane abd value add to bricks array and merge value with preloaded brick template
                    foreach(self::$bricks as $brick_name => $brick_value) $bricks[$brick_name] = array_merge($brick_value,array('preload' => self::preloadbrick($brick_value['render_template']),));
                    // Echo Script
                    echo sprintf($script, json_encode($bricks),wp_create_nonce('brick_nonce'));
                    Icon::set();
                });
                break;
            case 'acfpro':
                //Set Category Icons
                Icon::set();
                break;
        }
    }
}