<?php
/**
 * Render Functions
 * These functions are used to render blocks.
 *
 * @package MBC\Docsify
 */
namespace MBC\inc\brick;
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;

/**
 * Block Render
 *
 * Outward call from brick class to render block previews
 * Inline scss added
 * @return html
 */
function block_render( $block, $content = '', $is_preview = false ) {


    //No block return early
    if(!$block) return;
    //Sanitize block class ( Remove is-style-(.*) )
    if(isset($block['className'])) $block['className'] = str_replace('is-style-', '', $block['className']);
    if(!isset($block['className'])) $block['className'] = "default";
    // Setup global post
    global $post;
    
    //if is admin preview is always true.
    $is_preview = Prepare::is_admin() ? true : false;
    // Setup Post Data
    if($post) {
        $post = get_post( $post->ID );
        setup_postdata( $post );
    }
    // Setup passable variables
    $meta = get_post_meta($post->ID) ?? array();
    //if function exists get_fields
    $get_fields = function_exists('get_fields') ? get_fields() : array();
    //Globals ( for vue )
    $GLOBAL = json_encode(array_merge($meta,$get_fields ? $get_fields : array()));
    //if preview
    if($is_preview) $template = $block['render_template_unfiltered'];
    //Standard frontend render
    if(!$is_preview) $template = $block['render_template'];
    // Output Buffer Start
    ob_start();
    echo Style::compile($block['scss']);
    // Require template
    include $template;
    // Template now is output buffer
    $template = ob_get_clean();
    // if SCSS class exists Convert inline SCSS to CSS or return template inside block-render div
    $template = class_exists('MBC\\inc\\scss') ? \MBC\inc\scss::convert($template) : $template;
    // reset post data
    if($post) wp_reset_postdata();
    if($block['vue']){
        //Add global without having to echo it
        $template = str_replace('$GLOBAL', $GLOBAL, $template);
        $template = Vue::template($template, $block);
    }
    unset($block['icon']);
    $template_sprint = "<div class='%s' id='%s'>%s</div>";
    $template = sprintf($template_sprint,$block['className'],$block['id'],$template);
    if($block['setmode'] === 'bricks') return $template; 
    else echo $template;
}