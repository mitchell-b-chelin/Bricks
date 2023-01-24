<?php
namespace MBC\brick;
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;
class Vue extends brick {
    function __construct(){}
    /**
     * Vue Template
     *
     * Modify vue template to fit brick standards
     * @param string $template
     * @param block $block
     */
    public static function template($template, $block){
        //block id
        $blockID = '"'.$block['id'].'"';
        //block name
        $blockname = '"'.$block['name'].'_'.$block['id'].'"';
        //Not required to set varible but is a left over from passing it into shadowDOM
        $vueTemplate = '';
        // find template tag
        preg_match('/<template>(.*)<\/template>/s', $template,$vue_template);
        // if template tag exists and inner content exists replace $template with inner div with content replacing the <template> tags
        if(!empty($vue_template) && !empty($vue_template[1])) {
            $vueTemplate = "<div data-vue=$blockname class='brick vue'>".$vue_template[1]."</div>";
            $template = str_replace($vue_template[0], $vueTemplate, $template);
        }
        // find script tag(s*)
        preg_match_all('/<script>(.*)<\/script>/s', $template,$vue_script,PREG_PATTERN_ORDER);
        //if $vue_script is not empty
        if(!empty($vue_script)) {
           
            //foreach script tag
            foreach ($vue_script as $script) {
                $original = $script[0];
                foreach($script as $value) {
                    // if value contains export default we can assume its the default export
                    if(strpos($value, 'export default') !== false) {
                        $value = str_replace(array('export default','export default ','<script>','</script>'), '', $value);
                        $class = "'.brick[data-vue=$blockname]'";
                        if(self::$default_setup['vue']['version'] === '2'){
                            //trim $value
                            $value = trim($value);
                            //if first charecter for $value is {
                            if(substr($value, 0, 1) === '{') {
                                //remove first bracket
                                $value = substr($value, 1);
                                //Re add bracket and add el to block id
                                $value = "{el:$class,$value";
                            }
                            $template = str_replace($original, "<script>
                            new window.Vue($value)</script>", $template);
                        } else {
                            $template = str_replace($original, "<script>
                            window.Vue.createApp($value).mount($class);</script>", $template);
                        }

                    }
                }
            }
        }
        return $template;
    }
}