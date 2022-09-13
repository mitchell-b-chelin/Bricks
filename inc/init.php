<?php
// Exit if accessed directly.
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;



//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/brick.php';

//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/svg.php';

//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/slugify.php';


//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/prepare.php';

//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/method.php';

//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/category.php';

//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/register.php';

//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/blockset.php';

//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/restriction.php';

//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/acf.php';

//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/icon.php';

//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/vue.php';

//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/scss.php';

//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/render.php';


//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/initilize.php';

//Require Bricks
require plugin_dir_path( __FILE__ ) . 'brick/finalize.php';



//Require Documentation
require plugin_dir_path( __FILE__ ) . 'documentation.php';

use MBC\inc\brick as Brick;
/**
 * Brick Blocks method
 *
 * Run Brick class method to load the brick method
 */
add_action('plugins_loaded',function(){
    // Initialize Brick method
    Brick\Method::method();
});
/**
 * Brick Blocks Init
 *
 * Run Brick class we call this at after_setup_theme lifecycle because we want access to setup from theme functions first.
 */
add_action('after_setup_theme', function(){ 
    Brick\Initialize::init(); 
});