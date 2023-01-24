<?php
namespace MBC\brick;
if(!defined('ABSPATH') || !defined('WP_CONTENT_DIR') || !defined('WP_CONTENT_URL')) exit;
class Restriction extends brick {
    function __construct(){}
    /**
     * Restrictions Set
     *
     * Set Blocks Restrictions
     * note: restrictions should be set lightly as functionality around this is basic.
     */
    public static function restrictionSet(){
        // if the current block has settings that are not empty
        if(!empty(self::$current_block['settings'])){
            // we set pass here is a varible and will set it globally later
            $pass = false;
            // force fail variable will be used later to determine if self::$can_pass will return true or false
            $force_fail = false;
            //foreach settings as key and value
            foreach(self::$current_block['settings'] as $key => $value){
                //switch statement on key
                switch($key){
                    //if case is strict array
                    case 'restrict':
                        // let bricks know there is some restrictions in place
                        self::$has_restricted = true;
                        //check the restriction operator
                        $restriction_operator = isset($value['type']) ? $value['type'] : 'or';
                        //find current users capabilities
                        $capabilities = is_user_logged_in() ? get_userdata( get_current_user_id() )->allcaps : false;
                        //user id
                        $user_id = is_user_logged_in() ? get_current_user_id() : -1;
                        //foreach restriction
                        foreach($value['values'] as $restriction){
                            //base restriction by operator switch
                            switch($restriction_operator){
                                //if operator is or
                                case 'or':
                                    //if restriction is a string
                                    if(is_string($restriction)) {
                                        // and string is in wordpress current users roles
                                        if(in_array($restriction,  wp_get_current_user()->roles) || $capabilities && isset($cap[$restriction]) && $cap[$restriction]){
                                            // allow pass
                                            $pass = true;
                                            // break out this switch case
                                            break 1;
                                        }
                                    }
                                    //if the restriction is an interger and matches user id
                                    if(is_int($restriction) && $restriction === $user_id){
                                        // allow pass
                                        $pass = true;
                                        // break out this switch case
                                        break 1;
                                    }
                                    break;
                                //if operator is and ( Can be probalmatic as functionality is light read notes on #force_fail )
                                case 'and':
                                    //if restriction is a string
                                    if(is_string($restriction)) {
                                        // and string is in wordpress current users roles
                                        if(in_array($restriction,  wp_get_current_user()->roles) || $capabilities && isset($cap[$restriction]) && $cap[$restriction]){
                                            // allow pass
                                            $pass = true;
                                        } else {
                                            // deny pass
                                            $pass = false;
                                            // #force_fail Notes: as this is an or operator we want to ensure can_pass does not return true at the last minute.
                                            // So we force it to fail 
                                            // we could break the switch and return false but this is allows for each restriction to be checked.
                                            $force_fail = true;
                                        }
                                    }
                                    //if the restriction is an interger and matches user id
                                    if(is_int($restriction)) {
                                        if($user_id === $restriction) {
                                            // allow pass
                                            $pass = true;
                                        } else {
                                            // deny pass
                                            $pass = false;
                                            // #force_fail Notes: as this is an or operator we want to ensure can_pass does not return true at the last minute.
                                            // So we force it to fail 
                                            // we could break the switch and return false but this is allows for each restriction to be checked.
                                            $force_fail = true;
                                        }
                                    }
                                    //break as there is no other operators to check
                                    break;
                            }
                        }
                        //break restrictions case
                        break;
                    // if settings logged in is set
                    case 'loggedin':
                        // if value is not a boolean
                        if(!is_bool($value)){
                            // Worse case if not a boolean use this patern to determine.
                            if($value === 1 || $value === '1' || $value === 'true' || $value === 'TRUE' || $value = 'True') $value = true;
                            if($value === 0 || $value === '0' || $value === 'false' || $value === 'FALSE' || $value = 'False') $value = false;
                        }
                        // if value is false but there is restrictions allow restrictions to make a choice.
                        if(!$value && self::$has_restricted){ 
                            break;
                        }
                        // if value is true and there is restrictions this is an obvious conflict just break out of the switch
                        if($value && self::$has_restricted){
                            break;
                        }
                        // if value is true and there is no restrictions and user is indeed logged in allow pass
                        if($value && !self::$has_restricted && is_user_logged_in()){ 
                            $pass = true;
                            break;
                        }
                        // if value is true and there is no restrictions and user is not logged in deny pass
                        if($value && !self::$has_restricted && !is_user_logged_in()){
                            $pass = false;
                            break;
                        }
                        // if nothing else break out of this case
                        break;
                }
            }
            // if force fail is true then we can not pass
            // Otherwise we can just check if pass is true
            self::$can_pass = $force_fail ? false : $pass;
            //we will set $force_fail to its global value
            self::$force_fail = $force_fail;
        } else {
            // Because this current block returned no settings we should ensure we allow it access
            self::$can_pass = true;
            // Setting force fail to false as this is a block with no restrictions
            self::$force_fail = false;
            // Setting that this block returned no restrictions
            self::$has_restricted = false;
        }
    }
}