<?php

/**
 * Plugin Name: Custom Plugin One
 * https://www.youtube.com/watch?v=FpnHvp9x48c&list=PLriKzYyLb28kR_CPMz8uierDWC2y3znI2&index=6
 * Shortcode class. PHP version 5.6+
 * 
 * @category PluginIndex
 * @package  MyPlugin
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     none
 */

require __DIR__ . '/vendor/autoload.php';

use Plugin\MyPlugin\CustomPlugin;
use Plugin\MyPlugin\Admin\CustomPost\ExamplePostType;
use Plugin\MyPlugin\Front\Shortcodes\ProductShortcodes;

/**
 * Security check
 */
defined('ABSPATH') or die("No direct access allowed");

/**
 * Define crutial constants
 */
define('PLUGIN_MAIN_FILE', __FILE__); // local > C:\laragon\www\dologel\wp-content\plugins\custom-plugin-2132\custom-plugin-2132.php
define('PLUGIN_DIR', __DIR__); // local > C:\laragon\www\dologel\wp-content\plugins\custom-plugin-2132
define('PLUGIN_DIR_FILE', plugin_basename(__FILE__)); // > custom-plugin-2132/custom-plugin-2132.php
define('PLUGIN_NAME', plugin_basename(__DIR__)); // > custom-plugin-2132

/**
 * Init CustomPlugin main class and other supporting classes
 */
if (class_exists('Plugin\MyPlugin\CustomPlugin')) {
    $plugin = new CustomPlugin();
    $plugin->register();
    $somePostType = new ExamplePostType("book");
    $wooShortcode = new ProductShortcodes();
}

// add_action('et_builder_render_layout', [$plugin, 'getBooks']);
