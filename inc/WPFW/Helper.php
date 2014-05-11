<?php

namespace WPFW;

/**
 *  Some helper functions for Wordpress
 *
 *  @author Gotardo González <contact@gotardo.es>
 *  @copyright Gotardo González <contact@gotardo.es>
 *  @package WPFW
 *  @version 0.1
 *  @license MIT License
 *  @see LICENSE.txt
 */

class Helper {

    /**
     *  Displays a notice in the wp-admin site
     *  @param string $text the text to show in the notif
     *  @param string $class the type of notification
     *  @param string $style some CSS style for the notification
     *  @return self
     */
    public static function adminNotice($text, $class='updated', $style=''){
        add_action('admin_notices', function ($text, $class='updated', $style='') use ($text, $class, $style) {
            printf('<div class="%s" style="%s"><p>%s</p></div>', $class, $style, $text);
        });;
    }
}