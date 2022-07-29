<?php
/**
 * brick Blocks
 * This Class is used to implement bricks and extend backend functionality with Wordpress
 *
 * @package MBC\Docsify
 */
namespace MBC\inc\brick;
defined( 'ABSPATH' ) || exit;


class brick {
    //version 
    public static $version = '1.0.8';
    // the stylesheet directory
    public static $stylesheet_directory = '';
    // current category path
    public static $current_cat_path = '';
    // an array of the current category files
    public static $current_cat = array();
    // current block path
    public static $current_block_path = '';
    // current block uri
    public static $current_block_uri = '';
    // an array of the current block files
    public static $current_block = array();
    // an array of the current custom icons
    public static $brick_icons = array();
    // determines if a block is renderable on the frontend
    public static $can_pass = false;
    // determines if restrictions were set at some point
    public static $has_restricted = false;
    // failsafe forcing a failure on restrictions ( read notes under #force_fail )
    public static $force_fail = false;
    // a default restriction file path
    public static $is_restriction = '';
    // an array of bricks
    public static $bricks = array();
    // bricks implementation mode ( brick || acfpro )
    public static $mode = 'bricks';
    // block namespace
    public static $namespace = 'bricks/';
    // Global vue enabled
    public static $vue_enabled = false;
    //default bricks setup
    public static $default_setup = array();
    // the constructor empty as this is a static class
    function __construct(){}
}