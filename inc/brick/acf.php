<?php
namespace MBC\brick;
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;
class ACF extends brick {
    function __construct(){}
    /**
     * Advanced Custom Fields Setter ( ACF)
     *
     * Set ACF Fields from current block fields
     */
    public static function set($block_set_name){
        //replace _ with - $block_set_name
        $block_set_name = str_replace('_', '-', $block_set_name);
        if(!function_exists('acf_add_local_field_group')) return;
        // if Current Block has ACF Fields
        if(!empty(self::$current_block['acf'])){
            // Get field Groups from Block name
            $field_groups = self::field_groups($block_set_name);

          
            // if field groups do not exist create them
            if(!$field_groups) acf_add_local_field_group(array(
                // Field Group key
                'key' => $block_set_name,
                // Field Group title
                'title' => self::$current_block['info']['title'] ?? $block_set_name.'_brick_'.rand(0, 99999),
                // Fields
                'fields' => self::$current_block['acf'],
                // Fields Location
                'location' => array (
                  array (
                    array (
                      // Blocks
                      'param' => 'block',
                      // Operator Allways eqauls
                      'operator' => '==',
                      // Value Block Name Namespaced to block Namespace
                      'value' => "bricks/$block_set_name",
                    ),
                  ),
                ),
                'show_in_rest' => true,
                'active' => true
            ));
        }
    }

    /**
     * Field Groups
     *
     * Check ACF Field groups
     * @return boolean
     */
    private static function field_groups($value, $type='post_title'){
        // Variable exists
        $exists = false;
        // Field groups exist
        if ($field_groups = get_posts(array('post_type'=>'acf-field-group'))) {
            // foreach field group
            foreach ($field_groups as $field_group) {
                // if field group type is equal to value
                if ($field_group->$type == $value) {
                    // set exists to true
                    $exists = true;
                }
            }
        }
        // return exists
        return $exists;
    }
}