<?php
// Exit if accessed directly.
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;
$load = array(
    'brick',
    'admin',
    'svg',
    'slugify',
    'prepare',
    'method',
    'category',
    'register',
    'blockset',
    'restriction',
    'acf',
    'icon',
    'vue',
    'scss',
    'render',
    'initilize',
    'finalize'
);
foreach($load as $file) require plugin_dir_path( __FILE__ ) . 'brick/'.$file.'.php';
require plugin_dir_path( __FILE__ ) . 'documentation.php';
use MBC\brick as Brick;

add_action('plugins_loaded',function(){
    Brick\Method::method();
    new Brick\Admin;
},1);
add_action('after_setup_theme',function(){Brick\Initialize::init();},1);
add_action('admin_init', function(){
    if(!function_exists('register_block_type')){
        add_action('admin_notices', function(){ echo '<div class="notice notice-error"><p><strong>Bricks Error:</strong> Advanced Custom Fields Pro not found. This plugin requires the dependency to be installed and activated.</p></div>'; });
        deactivate_plugins(BRICKS_MAIN);
    } else {
        if(get_option('brick')) {
            add_action('admin_notices', function(){ echo '<div class="notice notice-success"><p>Thanks for installing Bricks! Check out the documentation and settings pages for more information.</p></div>'; });
            delete_option('brick');
        }
    }
},1);
register_activation_hook(BRICKS_MAIN,function(){update_option('brick', true);});
register_deactivation_hook(BRICKS_MAIN, function(){delete_option('brick');});