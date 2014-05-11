WP Plugin
================

WP Plugin provides a helper class and make it available for every plugin.

### Installing
1. Upload the plugin folder to your *wp-content/pplugins* directory.
2. Activate the plugin in the plugin administration folder. It will make the \WPFW\Plugin class available for other plugins.

### Starting your plugin
Yes, this is kind of 'hello, world'. In your new plugin main file you can start using some helper functions from the `\WPFW\Plugin` class. 
```php
use \WPFW\Plugin as P;
P::adminNotice('Hello, world!');
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

### Paths
There are some specific paths for your plugin's files:
`{your_plugin_path}/custom/taxonomy/` Clases that will be autoloaded
`{your_plugin_path}/inc/` Clases that will be autoloaded
`{your_plugin_path}/lib/` Alternative path for clases that will be autoloaded
`{your_plugin_path}/views/` Views


### Autoloader
The plugin will try to autoload all classes from your `{your_plugin_path}/inc/` directory. You can follow a name convention to load them. Namespaces and underscores will be readed as folders, so class `\Namespace\Foo_Thing` would map to `{your_plugin_path}/inc/Namespace/Foo/Thing.php`
But you will need to include your main plugin class (this one extending `\WPFW\Plugin` as this will be the one in charge of initializing the autoloader.

### View renderer
Plugin class provides a render function that you can call from your plugin. It is not actually a 'complete' view system, but it will allow you to separate some html code from the logic in your plugin PHP code.

First, create a view file in your `{your_plugin_path}/views/test` (e.g. `hello.php`).
```html
<p>
    Hello, <?php echo $name ?>
</p>
```
You will be able to render this file from any function in your plugin by calling the render function and passing the name of the view -or the name of the file- and an array containing the parameters for the view:
```php
$this->render('test/hello', ['name' => 'Paquito']);
```
The render will try to find a file at `{your_plugin_path}/views/test/hello.php` and include it.

### Configuration files
If you need to use some configuration files for your plugin, you can load them in a `config.php` file in the root of your plugin directory. This file will be automatically loaded by the plugin when needed.

### Custom shortcodes
You can declare shortcodes by just declaring a public function with the name `shortcode_yourShortCodeName`.
```php
class MyPlugin extends \WPFW\Plugin {
    public function shortcode_foo($atts, $content, $tag){
        echo "This is my foo shortcode"
    }
}
```
It allows the use of the shortcode like `[foo attr1='value1' attr2='value2']` from your pages and posts.
Note 1: As recomended on the Short Code API Docs (http://codex.wordpress.org/Shortcode_API) don't use camelCase or upper case for the attribute names.
Note 2: You can use the `shortcode_atts()` function to stablish some default values (see WordPress documentation for further information).
Note 3: WordPress default shortcodes (audio, caption, embed, gallery, video) can be overriden.

### Custom taxonomies
To add custom taxonomies, you only need to add some php files returning configuration arrays in the following path:
`{your_plugin_path}/custom/taxonomies/taxonomy-set-1.php`
`{your_plugin_path}/custom/taxonomies/taxonomy-set-2.php`
`{your_plugin_path}/custom/taxonomies/taxonomy-set-3.php`
Your configuration file should look like this:
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
Here you are a little plan for the development of this plugin. Of course, I am waiting for your suggestions.

1. v0.2 
2. Add support for hooks
2. Add support for filters
3. Add support for enqueue styles and javascripts libraries
1. v0.3
2. Add support for admin menu
2. Add support for custom post types
