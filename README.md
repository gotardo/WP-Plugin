WP Plugin
================

An helper class for WordPress plugin development.

### Installing
1. Upload the plugin folder to your *wp-content/pplugins* directory.
2. Activate the plugin in the plugin administration folder. It will make the \WPFW\Plugin class available for other plugins.

### Starting your plugin
In your new plugin main file you can start using some helper functions from the `\WPFW\Plugin` class. 

```php
\WPFW\Plugin::adminNotice('Hello, world!');

```

#### Basic start
Create your class extending `\WPFW\Plugin` and create an instance. This will initiate your plugin. In the following 

```php
class MyPlugin extends \WPFW\Plugin {
//We'll leave the body of the plugin empty for now...
}
$aPlugin = new MyPlugin();
```

#### Helper functions

Plugin class provides some helper functions that can be useful to code faster:

`\WPFW\Plugin::adminNotice($text)` Displays an admin notice in wp-admin with the message `$text`


### Autoloader

The plugin will try to autoload all classes from your `{your_plugin_path}/inc/` directory. You can follow a name convention to load them. Namespaces and underscores will be readed as folders, so...
class `\Namespace\Foo_Thing` would map to `{your_plugin_path}/inc/Namespace/Foo/Thing.php`

But you will need to include your main plugin class (this one extending `\WPFW\Plugin` as this will be the one in charge of initializing the autoloader.

### View renderer
Working on this section...

### Configuration files
If you need to use some configuration files for your plugin, you can load them in a `config.php` file in the root of your plugin directory. This file will be automatically load on plugin initialization.

### Custom shortcodes
Notes: As recomended on the Short Code API Docs (http://codex.wordpress.org/Shortcode_API) don't use camelCase or upper case for the attribute names.

### Custom taxonomies
To add custom taxonomies, you only need to add some php files returning configuration arrays in the following path:

{your_plugin_path}/custom/taxonomies/taxonomy-set-1.php
{your_plugin_path}/custom/taxonomies/taxonomy-set-2.php
{your_plugin_path}/custom/taxonomies/taxonomy-set-3.php


```php
/**
 *  Taxonomies sets
 */
return [
    //Taxonomy settings
    [
        'taxonomy'      => 'taxonomy-id1',
        'object_type'   => 'post',
        'args'          =>  [
            'hierarchical' => true,
            'labels' => [
                'name' => _x( 'My taxonomy name', 'taxonomy general name' ),
                'singular_name' => _x( 'Singular', 'taxonomy singular name' ),
                'search_items' =>  __( 'Search by taxonomy' ),
                'all_items' => __( 'All items' ),
                'edit_item' => __( 'Edit item' ),
                'update_item' => __( 'Update item' ),
                'add_new_item' => __( 'Add item' ),
                'new_item_name' => __( 'New item' ),
                'menu_name' => __( 'Menu name' ),
            ],
            'rewrite' => [
                'slug' => 'my taxonomy',
                'with_front' => false,
                'hierarchical' => true
            ],
        ],
    ],
    //You can add other taxonomy arrays here as new elements of thsi array
];
```

### Roadmap
This is a little plan for the development of this plugin. Of course, I am waiting for your suggestions.

1. v0.2 - Add support for hooks
1. v0.2 - Add support for filters
1. v0.2 - Add support for enqueue styles and javascripts libraries
1. v0.2 - Add support for ShortCodes closing tags
1. v0.3 - Add support for admin menu
1. v0.4 - Add support for custom post types
