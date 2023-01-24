<?php
namespace MBC\brick;
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;
class Icon extends brick {
    function __construct(){}
    /**
     * Icon Setup
     *
     * brick icon array setup ( Javascript )
     */
    public static function set(){
        // if brick icons is not empty and is admin page
        if(!empty(self::$brick_icons) && is_admin()) {
            // Set Icon Array to gbi variable
            $gbi = self::$brick_icons;
            // Add icons to admin footer
            add_action('admin_footer', function() use($gbi) {
                $screen = get_current_screen();
                
                // Sprintf Icon And Setup new bricks Class
                $sprintf = "<script>
                window.addEventListener('load', function() {
                    window.bricks = {
                        vue: {},
                        icons: %s
                    };
                    window.bricks.icons.forEach(function (brick) {
                        categoryIcon(brick.slug, brick.svg);
                    });
                });
                </script>";
                // Echo Icon Function to footer
                if($screen->base === 'post') echo sprintf($sprintf, json_encode($gbi));
            });
        }
    }
}