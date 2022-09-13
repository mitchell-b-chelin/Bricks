<?php
namespace MBC\inc\brick;
defined( 'ABSPATH' ) || exit;
class Register extends brick {
    function __construct(){}
    
    /**
     * Register Block
     *
     * Registered Block to Wordpress
     * note: ACF PRO Offers the best wordpress Block Implementation bricks Implementation allows block implementation in the same way as ACF Pro without ACF Fields
     * basic ACF allows a similar Experince as ACF Pro with editable fields but is not as powerful.
     */
    public static function block(){
        
        // Get Block Folder Name
        $block_name = self::$current_block['folder_name'];
        // Get base template name ( without extension ) Extended for Common filetypes
        $template_name = str_replace(array('.php','.vue','.twig','.json','.html','.xhtml'), '', basename(self::$current_block['template']));
        // Set Block Set Namespaced ( Default )
        $block_set_name = $block_name."_$template_name";
        
        // if Current block has a name set block name
        // Note: Registering blocks of the same name will override the previous one
        if(isset(self::$current_block['info']['name'])){
            // Remove Spaces from Block Name
            $block_set_name = str_replace(' ', '', self::$current_block['info']['name']);
            // Only A-Z Charecter in name
            $block_set_name = preg_replace('/[^A-Za-z0-9\-]/', '', $block_set_name);
            // Only lowercase in name
            $block_set_name = strtolower($block_set_name);
        }

        // Check if current block has a icon or default dash-icons block icon
        $icon = self::$current_block['info']['icon'] ?? 'dashicons-block-default';
        
        // if Current block has an icon and it is a file path get icon contents
        if(isset(self::$current_block['icon']) && is_file(self::$current_block['icon'])) $icon = file_get_contents(self::$current_block['icon']);
        // if in gutenberg block editor show template
        if(Prepare::is_admin() === true) $renderTemplate = self::$current_block['template'];
        //if on frontend determine restriction
        if(Prepare::is_admin() === false) $renderTemplate = self::$can_pass ? self::$current_block['template'] : self::$default_setup['template_restriction'];

        // set current block as variable
        $currentBlock = self::$current_block;


        //set default scss & mixins to current blocks scss
        $current_scss = self::$current_block['scss'] ?? array();
        $scss_global = self::$default_setup['global']['scss'];
        $scss_global['stylesheets'] = array_merge($scss_global['stylesheets'], $current_scss);

       

        // Setup Register Array
        $__register = array(
            // Block Name ( No Name Spacing )
            'name'              => $block_set_name,
            // Block Title
            'title'             => __(self::$current_block['info']['title'] ?? strtolower($block_name)),
            // Block Description
            'description'       => self::$current_block['info']['description'] ?? __("($block_name) A custom block made with brick."),
            // Render Template depending on restrictions
            'render_template'   => $renderTemplate,
            // unfiltered acess to set template
            'render_template_unfiltered' => self::$current_block['template'],

            // enqueuing scripts and styles
            'enqueue_assets' => function() use ($block_set_name,$currentBlock) {

                

                /**
                 * Setup Block Styles
                 */
                //if current block has styles and its not empty array
                if(isset($currentBlock['style']) && !empty($currentBlock['style'])) {
                    //foreach styles as style
                    foreach($currentBlock['style'] as $style){
                        //get style name as basename without filetype
                        $style_name = str_replace(array('.css','.scss','.less','.sass','.styl'), '', basename($style));
                        //enqueue style with {block name}_{style name}
                        wp_enqueue_style($block_set_name.'_'.$style_name, $style, array(), self::$version);
                    }
                }
                //if default setup has styles and its not empty array
                if(isset(self::$default_setup['global']['css']) && !empty(self::$default_setup['global']['css'])){
                    //foreach styles as style
                    foreach(self::$default_setup['global']['css'] as $style){
                        //get style name as basename without filetype
                        $style_name = str_replace(array('.css'), '', basename($style));
                        //enqueue style with {block name}_global_{style name}
                        wp_enqueue_style( $block_set_name.'_global_'.$style_name, $style, array(), self::$version );
                    }
                }
                /**
                 * Setup Block Scripts
                 */
                //if current block has scripts and its not empty array
                if(isset($currentBlock['scripts']) && !empty($currentBlock['scripts'])) {
                    //foreach styles as style
                    foreach($currentBlock['scripts'] as $script){
                        //get script name as basename without filetype
                        $script_name = str_replace(array('.js'), '', basename($script));
                        //enqueue script with {block name}_{script name}
                        wp_enqueue_script( $block_set_name.'_'.$script_name, $script, array('jquery'), self::$version, true );
                    }
                }
                //if default setup has scripts and its not empty array
                if(isset(self::$default_setup['global']['javascript']) && !empty(self::$default_setup['global']['javascript'])){
                    //foreach styles as style
                    foreach(self::$default_setup['global']['javascript'] as $script){
                        //get script name as basename without filetype
                        $script_name = str_replace(array('.js'), '', basename($script));
                        //enqueue script with {block name}_{script name}
                        wp_enqueue_script( $block_set_name.'_'.$script_name, $script, array('jquery'), self::$version, true );
                    }
                }
            },
            'vue' => self::$current_block['vue'],
            'scss' => $scss_global,
            'styles'  => self::$current_block['styles'] ?? array(),
            // Render Callback block_render Function
            'render_callback'   => 'MBC\inc\brick\block_render',
            //is editor 
            'isEditor'          => Prepare::is_admin(),
            // Block Category
            'category'          => self::$current_cat['info']['slug'] ?? 'brick-category',
            // Block Icon
            'icon'              => $icon,
            // Namespace
            'namespace'         => self::$namespace,
            // brick Mode 
            'setmode'           => self::$mode,
            // Block Attributes
            'keywords'          => self::$current_block['info']['keywords'] ?? array(),
            // Block Supports
            'supports'		=> self::$current_block['supports'] ?? array(),
            // Block Attributes else false
            'example'           => isset(self::$current_block['preview']) ? array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => self::$current_block['preview']
                )
            ) : false);
        
        switch(self::$mode){
            case 'bricks':
                // Register Wordpress Block
                self::registerbrick($__register);
                // Register ACF Fields
                ACF::set($block_set_name);
                break;
            case 'acfpro':
                // Register To ACF Pro register blocks ( Note: ACF Namespace Replaced with brick Namespace )
                acf_register_block_type($__register);
                // Register ACF Fields
                ACF::set($block_set_name);
                break;
        }
        // Register block to bricks Namespace
        self::$bricks[self::$namespace.$block_set_name] = $__register;
    }

    /**
     * Preload Block
     *
     * Preload Block to Wordpress
     * @return html
     */
    private static function preloadbrick($brick){
        // if brick does not exist return false
        if(!file_exists($brick)) return false;
        // Get post id
        $post_id = get_the_ID();
        // if post id
        if($post_id) {
            //get post
            $post = get_post($post_id);
            // setup post data
            setup_postdata($post);
        }
        // output buffer start
        ob_start();
        // Include brick
        include $brick;
        // output buffer end to html
        $html = ob_get_clean();
        // if post id reset post data
        if($post_id) wp_reset_postdata();
        // return html
        return $html;
    }

    /**
     * Register Block ( brick Method)
     *
     * Register Block to Wordpress using the brick Method
     * @return array
     */
    private static function registerbrick($brick){
        // Setup Attributes
        $attributes = array(
            "mode" => "preview",
            "align" => "",
            "supports" => array(
                "align" => true,
                "html" => false,
                "mode" => true,
                "jsx" => true,
            ),
            "post_types" => array(),
            "usesContext" => array(
                "postId",
                "postType"
            ),
            "enqueue_style" => false,
            "enqueue_script" => false,
            "enqueue_assets" => false,
        );
        // Merge Attributes With brick
        $brick = array_merge($attributes, $brick);
        // Setup brick Namespace
        $brick['name'] = self::$namespace.$brick['name'];
        // Register brick using Wordpress Block Types
        register_block_type(
            // Block Name Namespacing required
            $brick['name'],
            // Block Array
            array(
                // Block Attributes
                'attributes'      => Prepare::defaultAttributes($brick),
                // Block uses Context
                'uses_context'    => $brick['usesContext'] ?? array(),
                // API Version, Should be 2 unless wordpress goes to v3
                'api_version'     => 2,
                // Block Render Callback ( Note: Standard brick renderer requires additional function class before passing to default renderer )
                'render_callback' => function( $attributes, $content = '', $wp_block = null ) {
                    //get current brick from store
                    $brick = prepare::block($wp_block->name);
                    //if block passed is not part of brick return
                    if(!$brick) return;
                    //prepare default attributes for brick
                    $block = Prepare::brick($brick);
                    $block = array_merge($block, $attributes);
                    //brick attributes
                    $block['brick'] = array();
                    $block['brick']['id'] = $wp_block->name.'_'.substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', mt_rand(1, 10))), 1, 10);
                    if(empty($block['id'])) $block['id'] = $block['brick']['id'];
                    $block['brick']['attributes'] = $attributes['data'];
                    //add name to block
                    $block['name'] = $wp_block->name;
                    //if block is not asigned to post id asign it now
                    if(!$block['id'] || !isset($block['id'])) $block['id'] = get_the_ID();
                    //if no block return
                    if(!$block) return;
                    //get post id
                    $post_id = get_the_ID();
                    //prepare assets
                    Prepare::assets($block);
                    return block_render($block, $content, true);
                },
            )
        );
        return $brick;
    }
}