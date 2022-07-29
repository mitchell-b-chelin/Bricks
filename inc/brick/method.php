<?php
namespace MBC\inc\brick;
defined( 'ABSPATH' ) || exit;
class Method extends brick {
	function __construct() {}

    /**
     * Method
     *
     * Set Block Methods
     */
    public static function method(){
        if(is_admin()) { 
            //add action wp_enqueue_scripts
            add_action('admin_enqueue_scripts', function(){
                wp_enqueue_script('brick-blocks-js', plugins_url('assets/brick.js', __FILE__), false, self::$version, false);
            }); 
        }

        // if ACF Pro is installed
        if(function_exists('acf_register_block_type')) {
            //Match ACF Block Arguments to Namespace
            add_filter('acf/register_block_type_args', function( $args ){
                if(isset($args['namespace'])) {
                    $args['name'] = str_replace('acf/', $args['namespace'], $args['name']);
                }
                return $args;
            });
            // Set Mode to ACF Pro
            self::$mode = 'acfpro';
        } else {
            // Enqueue bricks prototype method REACT
            if(is_admin()) {
                add_action('admin_enqueue_scripts', function(){
                    wp_enqueue_script('brick-blocks-prototype-js', plugins_url('assets/bricks.prototype.v2.js', __FILE__), false, self::$version, false);
                });
            }

            if(function_exists('acf_add_local_field_group')){
                add_filter('acf/location/rule_types', function ( $choices ) {
                    $choices['Gutenberg']['bricks'] = 'Bricks';
                    return $choices;
                }, 10, 1);
                add_filter('acf/location/rule_operators/bricks',function($choices){
                    return  array('==' => 'Is',); 
                },10,1);
                add_filter('acf/location/rule_values/bricks', function ( $choices, $data ) {
                    $block_types = \WP_Block_Type_Registry::get_instance()->get_all_registered();
                    foreach($block_types as $block_type){
                        $choices[ $block_type->name ] = $block_type->name;
                    }
                    return $choices;
                }, 10, 2);
                add_filter('acf/location/rule_match/bricks',function( $match, $rule, $options, $field_group ){

                    if(isset($block)){
                        if($rule['value'] == $block->name) $match = true;
                        else $match = false;
                    } else $match = false;

                    return true;
                }, 10, 4);
            }
            // Set Mode to bricks standard
            self::$mode = 'bricks';
        }
    }

}