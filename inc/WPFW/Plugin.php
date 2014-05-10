<?php

namespace WPFW;

/**
 *
 * @author Gotardo González <contact@gotardo.es>
 * @copyright Gotardo González <contact@gotardo.es>
 * @version 0.1
 * @license MIT License
 * @see LICENSE.txt
 * @todo
 *      - review and document render method
 *      - review and document shortcodes
 */

class Plugin {

    /** @var mixed WordPress DataBase Object */
    protected $db         = null;

    /** @var string The plugin main file */
    protected $mainFile   = null;

    /** @var string The plugin main folder */
    protected $mainFolder   = null;

    /** @var array Configuration params */
    protected $config   = null;

    /**
     *  Build your plugin!
     *
     *  @param array $config Plugin configuration
     */
    function __construct($config = array()){
        global $wpdb;

        /** @var mixed Keep a reference to global $wpdb object */
        $this->db           =& $wpdb;

        /** @var string Keep a reference to the plugin main file */
        $this->mainFile     = __CLASS__;

        /** @var string Keep a reference to the plugin main folder */
        $this->mainFolder   = dirname($this->mainFile);

        /** Register autoloader */

        spl_autoload_register( function ($class)
        {
            $path = $this->dirname . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            if (file_exists($path)) require_once $path;
            else return false;

        });

        /**
         * Register install adn uninstall methods
         */
        register_activation_hook    ($this->mainFile, array($this, "install")     );
        register_deactivation_hook  ($this->mainFile, array($this, "uninstall")   );

        /**
         * Control $_POST
         */
        if ( isset($_POST) ) { $this->processPost(); }


        /**
         * Enqueue scripts
         */

        add_action( 'wp_enqueue_scripts',       array($this, 'front_enqueue'));
        add_action( 'admin_enqueue_scripts',    array($this, 'admin_enqueue') );


        /** Autodetect shortcodes */
        $this->_registerShortCodes();
        $this->_registerCustomTaxonomy();
    }

    public function getConfig()
    {
        $this->config || $this->config = $this->loadConfig();
        return $this->config;
    }

    public function loadConfig()
    {
        if(file_exists($configFilePath = $this->dirname() . DIRECTORY_SEPARATOR . 'config.php'))
            return include $configFilePath;
        else
            return [];
    }

    /**
     * Load the custom taxonomies configuration files
     */
    private function _registerCustomTaxonomy()
    {
        add_action( 'init', function (){
            $path = glob( $this->dirname() . DIRECTORY_SEPARATOR . 'custom' . DIRECTORY_SEPARATOR . 'taxonomy' . DIRECTORY_SEPARATOR . '*.php');
            foreach($path as $file)
                if(is_array($configArray = include $file))
                    foreach ($configArray as $config)
                    {
                        register_taxonomy($config['taxonomy'], $config['object_type'], $config['args']);
                    }

        });
    }

    private function _registerShortCodes()
    {

        $methods = get_class_methods($this);

        foreach ($methods as $method) {
            if(preg_match("#^shortcode_.*#s",$method)){
                $this->add_shortcode(substr($method, 10));
            }
        }
    }

    public function __get($name)
    {
        return $this->$name();
    }

    protected function file()
    {
        $reflector = new \ReflectionClass(get_called_class());
        return $reflector->getFileName();
    }

    protected function dirname(){
        return dirname($this->file());
    }

    protected function add_shortcode($shortcode) {
        add_shortcode( $shortcode, array($this, "shortcode_" . $shortcode) );
    }


    /**
     *  Process $_POST data
     */
    protected function processPost() {
        foreach ($_POST as $key => $value) {
            //  $_POST[$key] = addcslashes(($value), '"');

        }
    }

    /**
     *  Displays a notice in the wp-admin site
     *  @param string $text the text to show in the notif
     *  @param string $class the type of notification
     * @param string $style some CSS style for the notification
     *  @return string The URL of $file
     */
    public static function adminNotice($text, $class='updated', $style=''){
        add_action('admin_notices', function ($text, $class='updated', $style='') use ($text, $class, $style) {
            printf('<div class="%s" style="%s"><p>%s</p></div>', $class, $style, $text);
        });
    }

    /**
     *  Returns the url of a file from the current plugin
     *  @param string $file The file you need to call
     *  @return string The URL of $file
     */
    public static function url($file = '') {
        return plugin_dir_url(__FILE__) . $file;
    }

    /**
     * Renders a file
     * @param string $file the file to render
     * @return bool true if the file could be rendered
     *
     */
    public function render($file, $params = array()) {

        //Extract de paramethers for the frame to render
        if ( is_array( $params ) )
            extract( $params );

        //Set the route
        $route = $this->mainFolder . '/' . $file . '.php';

        //Check if file exists before include
        if ( file_exists($route) ) {
            include($route);
            return true;
        }
        //if file doesn't exist, a notice is triggered
        else {
            if ( WP_DEBUG ) {
                trigger_error ( __( "Couldn't render " ) . $route, E_USER_WARNING );
                debug_backtrace();
            }
            return false;
        }
    }

    /**
     *  Override this method for admin script enqueue
     */
    public function admin_enqueue($hook = null){}

    /**
     *  Override this method for frontend script enqueue
     */
    public function front_enqueue($hook = null){}

    /**
     *  Override this method for plugin install
     */
    public function install(){}

    /**
     *  Override this method for plugin uninstall
     */
    public function uninstall(){}
}