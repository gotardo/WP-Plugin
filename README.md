WP Plugin
================

An abstract plugin class for WordPress.

### Installing

### Starting your plugin

#### Basic start
```php
class MyPlugin extends \WPFW\Plugin
{

}

new MyPlugin();
```

#### Helper functions


#### Advanced


### Autoloader
{your_plugin_path}/inc/

### View renderer

### Configuration files

### Custom shortcodes
Notes:
* As recomended on the Short Code API Docs (http://codex.wordpress.org/Shortcode_API) don't use camelCase or upper case for the attribute names.

### Custom taxonomies
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

1. v0.2 - Add support for hooks
1. v0.2 - Add support for filters
1. v0.2 - Add support for enqueue styles and javascripts libraries
1. v0.2 - Add support for ShortCodes closing tags
1. v0.3 - Add support for admin menu
1. v0.4 - Add support for custom post types