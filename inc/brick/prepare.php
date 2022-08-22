<?php
namespace MBC\inc\brick;
defined( 'ABSPATH' ) || exit;
class Prepare extends brick {
	function __construct() {
	}

    public static function block($brick){
        //if $brick exists in self::$bricks, return it
        if(isset(self::$bricks[$brick])) return self::$bricks[$brick];
        else return false;
    }
    public static function getblockFields($block){
        global $currentACFBlock;
        //is set block name
        if(!isset($block['name'])) return false;
        // set variable
        $block_name = $block['name'];
        //prepare block type
        if(strpos($block_name, '\/') !== false) $block_name = str_replace('\/', '/', $block_name);

        //add to current ACF block global
        $currentACFBlock = $block_name;
        //add to block type to name in request
        $_REQUEST['block_type'] = $block_name;
        // Fields array
        $fields = array();
        // Get field groups for this block.
        $field_groups = acf_get_field_groups(array('block' => $block_name));
        // Loop over results and append fields.
        if($field_groups) foreach($field_groups as $field_group) { $fields = array_merge($fields,acf_get_fields($field_group)); }
        // Return fields.
        return $fields;
    }
    
    public static function defaultAttributes($brick_type = array()) {
        if(empty($brick_type)) return array();
        $attributes = array(
            'id'    => array(
                'type'    => 'string',
                'default' => '',
            ),
            'name'  => array(
                'type'    => 'string',
                'default' => '',
            ),
            'data'  => array(
                'type'    => 'object',
                'default' => array(),
            ),
            'align' => array(
                'type'    => 'string',
                'default' => '',
            ),
            'mode'  => array(
                'type'    => 'string',
                'default' => 'preview',
            ),
        );
        if (!empty( $brick_type['supports']['align_text'] ) ) {
            $attributes['align_text'] = array(
                'type'    => 'string',
                'default' => '',
            );
        }
        if (!empty( $brick_type['supports']['align_content'] ) ) {
            $attributes['align_content'] = array(
                'type'    => 'string',
                'default' => '',
            );
        }
        return $attributes;
    }
    public static function assets($brick){
        // Generate handle from name.
        $handle = 'brick-' . Slugify::sanitize($brick['name'] );
        // Enqueue style.
        if (isset($brick['enqueue_style'])) wp_enqueue_style( $handle, $brick['enqueue_style'], array(), false, 'all' );
        // Enqueue script
        if (isset($brick['enqueue_script'])) wp_enqueue_script( $handle, $brick['enqueue_script'], array(), false, true );
        // Enqueue assets callback.
        if (isset($brick['enqueue_assets']) && is_callable($brick['enqueue_assets'])) call_user_func( $brick['enqueue_assets'], $brick );
    }

    public static function brick($block){
        $attributes = array();
        foreach (Prepare::defaultAttributes($block) as $k=>$v) $attributes[$k] = $v['default'];
        return array_merge( $block, $attributes);
    }

    public static function ACFBrick($block){
        // Bail early if no name.
        if (!isset($block['name'])) return false;
        // Get block type and return false if doesn't exist.
        $block_type = self::$bricks[$block['name']] ?? false;
        if(!$block_type) return false;
        // Generate default attributes.
        $attributes = array();
        foreach (Prepare::defaultAttributes($block_type) as $k => $v) $attributes[$k] = $v['default'];
        // Merge together arrays in order of least to most specific.
        $block = array_merge( $block_type, $attributes, $block );
        // Return block.
        return $block;
    }
    /**
     * Super class for returning if admin.
     *
     * @return bool
    */
    public static function is_admin() {
        //if you are in wp-admin return true
        if(is_admin() || wp_doing_ajax() || strpos($_SERVER['REQUEST_URI'], '/wp-json/') !== false) return true;
        else return false;
    }

    /**
     * Setup bricks
     * This function is used to setup bricks. it is used to define bricks location and default loaded assets
     * @param array
     */
    public static function setup($setup = array()){
        $default = array(
            //Template path for where your bricks are stored.
            'template_path' => get_stylesheet_directory() . '/templates/bricks/',
            // Template restriction php
            'template_restriction' => plugin_dir_path(__FILE__)."../assets/restricted.php",
            // Vue version and enviroment loaded
            'vue' => array(
                'version' => '3',
                'enviroment' => 'development'
            ),
            // block globals loaded each instance of a block
            'global' => array(
                // Javascript globals
                'javascript' => array(),
                // Stylesheet globals
                'css' => array(),
                // Sass Globals
                'scss' => array(
                    'mixins' => array(),
                    'stylesheets' => array()
                )
            )
        );
        //if setup is empty set default setup array
        if(empty($setup)) {
            if(empty(self::$default_setup)){
                self::$default_setup = $default;
                //return early
                return;
            }
        } else {
            //merge $setup and $default_setup
            $custom_setup = array_merge($default,$setup);
            //if template restriction is set
            if(isset($custom_setup['template_restriction'])){
                //set template restriction to if the file exists otherwise use the plugin default.
                $custom_setup['template_restriction'] = file_exists($custom_setup['template_restriction']) ? $custom_setup['template_restriction'] : plugin_dir_path(__FILE__)."../assets/restricted.php";
            }
            
            self::$default_setup = $custom_setup;

        };
        // return
        return;
    }

    /**
     * Check
     * This function is used to check if the files and folders exist to build bricks.
     * @return bool
     */
    public static function check(){
        $passed = true;
        if(isset(self::$default_setup)){
            if(!is_dir(self::$default_setup['template_path'])) $passed = false;
            if(!file_exists(self::$default_setup['template_restriction'])) $passed = false;
        } else $passed = false;
        return $passed;
    }
};



    