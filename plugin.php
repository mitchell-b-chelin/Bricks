<?php
/**
 * Bricks
 *
 * A developer friendly guttenberg block registration method.
 *
 * @link		https://github.com/mitchell-b-chelin/Bricks/blob/main/LICENSE
 * @since 		1.0
 * @package		MBC
 *
 * Plugin Name:	   	Bricks
 * Plugin URI:		https://github.com/mitchell-b-chelin/Bricks/blob/main/LICENSE
 * Description:	   	A developer friendly guttenberg block registration method.
 * Version:		   	1.0.14
 * Author:			Mitchell-Blair Chelin
 * Author URI:		https://github.com/mitchell-b-chelin/
 * License:		   	MIT
 * License URI:	   	https://github.com/mitchell-b-chelin/Bricks/blob/main/LICENSE
 */
namespace MBC;

// Exit if accessed directly.
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;
require plugin_dir_path( __FILE__ ) . 'inc/init.php';