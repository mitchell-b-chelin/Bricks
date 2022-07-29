<?php
namespace MBC\inc\brick;
defined( 'ABSPATH' ) || exit;
class Block extends brick {
    function __construct(){}
    /**
     * Blocks Set
     *
     * Set Blocks for registering
     * This Function Links into blockRegister Function
     */
    public static function set($blocks){
        //foreach Blocks
        foreach($blocks as $block){
            //if category is is a return directive or is not a folder continue
            if(!$block || $block == '.' || $block == '..') continue;
            // Set Current block path
            self::$current_block_path = self::$current_cat_path.'/'.$block;
            // Set Current block URI
            self::$current_block_uri = str_replace(ABSPATH, get_home_url().'/', self::$current_block_path);

            if(!is_dir(self::$current_block_path)) continue;
            // Scan for files
            $files = scandir(self::$current_block_path);
            // Set Current block to new array
            self::$current_block = array();
            // Foreach files in directory
            foreach($files as $file){
                //if category is is a return directive or is not a folder continue
                if(!$file || $file == '.' || $file == '..' || is_dir(self::$current_block_path.$file)) continue;
                // Setup Assets for file
                self::assetSet($file);
            }
            // Check if Current Block is not empty
            if(!empty(self::$current_block)){
                // set Current block Folder name
                self::$current_block['folder_name'] = $block;

                
                // Set Current Block Restrictions
                Restriction::restrictionSet();
                // Register Block
                Register::block();
            }
        }
    }

    /**
     * Assets Set
     *
     * Set Blocks Assets
     */
    private static function assetSet($file){
        // if no file return
        if(!$file) return;
        // Determine file asset
        switch(strtolower($file)){
            // if Fields or ACF Variables
            case 'acf.json':
            case 'fields.json':
                // Add ACF Fields to Current Block
                self::$current_block['acf'] = json_decode(file_get_contents(self::$current_block_path . '/' . $file), true);
                break;
            // if Block JSON information
            case 'info.json':
            case 'init.json':
            case 'block.json':
            case 'brick.json':
                // Decode JSON  
                $info = @json_decode(file_get_contents(self::$current_block_path . '/' . $file), true);
                // Check if JSON has is Settings Field
                if(isset($info['settings'])){
                    // Set Settings Field to Current Block
                    self::$current_block['settings'] = $info['settings'];
                    // Unset Info Settings
                    unset($info['settings']);
                }
                if(isset($info['preview'])){
                    // Set Preview Field to Current Block
                    self::$current_block['preview'] = $info['preview'];
                    // Unset Info Preview
                    unset($info['preview']);
                }
                if(isset($info['supports'])){
                    // Set Supports Field to Current Block
                    self::$current_block['supports'] = $info['supports'];
                    // Unset Info Supports
                    unset($info['supports']);
                }
                if(isset($info['styles'])){
                    $styles = array();
                    foreach($info['styles'] as $style){
                        $set_style = array(
                            'name' => $style['class'],
                            'label' => $style['label'],
                        );
                        if(isset($style['default'])) $set_style['isDefault'] = $style['default'];
                        $styles[] = $set_style;
                    }
                    // Set Block Styles Field to Current Block
                    self::$current_block['styles'] = $styles;
                    // Unset Info Styles
                    unset($info['styles']);
                }
                // Set Info to Current Block
                self::$current_block['info'] = $info;
                break;
            // if Block SVG icon
            case 'block.svg':
            case 'brick.svg':
            case 'icon.svg':
                // Set SVG icon to Current Block
                self::$current_block['icon'] = self::$current_block_path . '/' . $file;
                break;
            // Default Template file
            default:
                //get file extension
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                switch($ext){
                    case 'vue':
                    case 'php':
                        //set global vue enabled
                        if($ext === 'vue') self::$vue_enabled = true;
                        // Set if template is vue
                        self::$current_block['vue'] = ($ext === 'vue');
                        // Set Template file to Current Block Array
                        if(!isset(self::$current_block['template'])) self::$current_block['template'] = self::$current_block_path . '/' . $file;
                        break;
                    case 'css':
                        if(strpos($file, '_') !== 0) self::$current_block['style'][] = self::$current_block_uri . '/' . $file;
                        break;
                    case 'js':
                        if(strpos($file, '_') !== 0) self::$current_block['scripts'][] = self::$current_block_uri . '/' . $file;
                        break;
                    case 'scss':
                        //absoutle path to scss file as we will encode it in the css inline script
                        if(strpos($file, '_') !== 0) {
                            self::$current_block['scss'][] = self::$current_block_path . '/' . $file;
                        }
                        break;
                }
                //break default
                break;   
        }
    }
}