<?php
/**
 * Plugin Name: Custom Plugin One
 * https://www.youtube.com/watch?v=FpnHvp9x48c&list=PLriKzYyLb28kR_CPMz8uierDWC2y3znI2&index=6
 */
require __DIR__ . '/vendor/autoload.php';

use Plugin\MyPlugin\CustomPlugin;
use Plugin\MyPlugin\Admin\CustomPost\ExamplePostType;
use Plugin\MyPlugin\Front\Shortcodes\ProductShortcodes;

/**
 * Security check
 */
defined('ABSPATH') or die();

/**
 * Define crutial constants
 */
define('PLUGIN_MAIN_FILE', __FILE__); // local > C:\laragon\www\dologel\wp-content\plugins\custom-plugin-2132\custom-plugin-2132.php
define('PLUGIN_DIR', __DIR__); // local > C:\laragon\www\dologel\wp-content\plugins\custom-plugin-2132
define('PLUGIN_DIR_FILE', plugin_basename(__FILE__)); // > custom-plugin-2132/custom-plugin-2132.php
define('PLUGIN_NAME', plugin_basename(__DIR__)); // > custom-plugin-2132

/**
 * Init Plugin class
 */
if( class_exists('Plugin\MyPlugin\CustomPlugin') ){
    $pluginClass = new CustomPlugin();
    $pluginClass->register();

    $somePostType = new ExamplePostType();
    $shortcode = new ProductShortcodes();
}

// add_action('et_builder_render_layout', [$pluginClass, 'getBooks']);



 // function that runs when shortcode is called
 function wpb_demo_shortcode() { 
 
    // Things that you want to do. 
    $message = 'Hello world!'; 
    // Output needs to be return
    return $message;
} 
    // register shortcode
add_shortcode('greeting', 'wpb_demo_shortcode'); 