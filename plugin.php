<?php
/**
 * Bricks
 * @link		https://github.com/mitchell-b-chelin/Bricks/
 * @since 		1.0
 * @package		MBC
 * Plugin Name:	   	Bricks
 * Plugin URI:		https://github.com/mitchell-b-chelin/Bricks/
 * Description:	   	Bricks is a Guttenberg plugin that makes it easy for developers to create custom blocks using Advanced Custom Fields Pro. Easily add dynamic content to your pages and posts with Bricks.
 * Version:		   	2.0
 * Author:			Mitchell-Blair Chelin
 * Author URI:		https://github.com/mitchell-b-chelin/
 * License:		   	MIT
 * License URI:	   	https://github.com/mitchell-b-chelin/Bricks/blob/main/LICENSE
 */
namespace MBC;
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;
define('BRICKS_VERSION', '2.0');
define('BRICKS_MAIN', __FILE__);
define('BRICKS_ASSETS_DIR', plugin_dir_url( __FILE__ ) . 'inc/assets/');
require plugin_dir_path( __FILE__ ) . 'inc/init.php';
