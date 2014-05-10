<?php
/*
Plugin Name: WordPress Abstract Plugin
Plugin URI:
Description: A little class framework for WordPress plugins. This plugin provides no functionality by itself but some plugins depend on it.
Author: Gotardo González
Version: 0.1
Author URI: http://blog.gotardo.es/
*/

/** Autoload */
spl_autoload_register( function ($class)
{
    $paths = [
        __DIR__ . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php',
    ];

    foreach($paths as $path)
        if (file_exists($path))
            return require_once $path;
        else
            return false;
});

/** Give priority to the loader. */
add_action('activated_plugin', function ()
{
    $path = str_replace( WP_PLUGIN_DIR . '/', '', __FILE__ );

    if ( $plugins = get_option( 'active_plugins' ) ) {
        if ( $key = array_search( $path, $plugins ) ) {
            array_splice( $plugins, $key, 1 );
            array_unshift( $plugins, $path );
            update_option( 'active_plugins', $plugins );
        }
    }
});