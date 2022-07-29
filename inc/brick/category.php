<?php
namespace MBC\inc\brick;
defined( 'ABSPATH' ) || exit;
class Category extends brick {
	function __construct() {}
    /**
     * Category Set
     *
     * Set Block Categories 
     * This Function Links into blocksSet Function
     */
    public static function set(){
        //Get Default Categories location
        $categories = scandir(self::$default_setup['template_path']);
        // Foreach Category
        foreach($categories as $category) {
            //if category is is a return directive or is not a folder continue
            if(!$category || $category == '.' || $category == '..') continue;
            // Set Current Category path
            self::$current_cat_path = self::$default_setup['template_path'] . $category;
            if(!is_dir(self::$current_cat_path)) continue;
            // Scan Directory
            $files = scandir(self::$current_cat_path);
            // Foreach in Directory
            foreach($files as $file){
                // Get Filetype
                $file_type = pathinfo($file, PATHINFO_EXTENSION);
                // Switch Filetype
                switch(strtolower($file_type)){
                    case 'json':
                        // Get Category JSON
                        self::$current_cat['info'] = json_decode(file_get_contents(self::$current_cat_path . '/' . $file), true);
                        break;
                    case 'svg':
                        // Get SVG icon
                        self::$current_cat['icon'] = self::$current_cat_path . '/' . $file;
                        break;
                }
            }
            // if Category json information
            if(isset(self::$current_cat['info'])){
                // Current Category information
                $cc_category = self::$current_cat['info'];
                // If Slug or Title is not set return
                if(!isset($cc_category['slug']) || !isset($cc_category['title'])) return;
                // Setup Custom icon
                $custom_icon = isset(self::$current_cat['icon']) ? SVGJson::convert(self::$current_cat['icon']) : false;
                // if Custom icon is set
                $cc_category['custom_icon'] = $custom_icon ? true : false;
                // Add SVG icons to brick Icons
                if($custom_icon) self::$brick_icons[] = array('slug' => $cc_category['slug'], 'svg' => $custom_icon);
                // Add Block Categories Using Current Category
                add_filter( 'block_categories_all', function( $block_categories, $editor_context ) use ($cc_category) {
                    // if Editor Post Context
                    if (!empty($editor_context->post)){
                        // Found Variable
                        $found = false;
                        // Foreach Block Category
                        foreach($block_categories as $categoryegory){
                            // if Category Slug is equal to Current Category Slug
                            if($categoryegory['slug'] == $cc_category['slug']){
                                $found = true;
                                break;
                            }
                        }
                        // Double Check if icon is set
                        $icon = $cc_category['icon'] ? $cc_category['icon'] : false;
                        // Set title
                        $check_custom = $cc_category['custom_icon'] ? 'custom-brick-icon' : $icon;
                        // Push Category to Block Categories
                        array_push(
                            $block_categories,
                            array(
                                'slug'  => $cc_category['slug'],
                                'title' => __(  $cc_category['title'], 'brick-plugin' ),
                                'icon'  =>  $check_custom
                            )
                        );
                    }
                    // Return Block Categories
                    return $block_categories;
                }, 10, 2 );
            }
            // Set Blocks
            Block::set($files);
        }
    }
}