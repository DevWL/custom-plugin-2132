<?php
/**
 * Plugin Name: Custom Plugin One
 * https://www.youtube.com/watch?v=FpnHvp9x48c&list=PLriKzYyLb28kR_CPMz8uierDWC2y3znI2&index=6
 */
require __DIR__ . '/vendor/autoload.php';

use Plugin\MyPlugin\CustomPlugin;
use Plugin\MyPlugin\Util\HookDebuger;
use Plugin\MyPlugin\Util\GetPluginPath;
use Plugin\MyPlugin\CustomPluginOnActivate;
use Plugin\MyPlugin\CustomPluginOnDeactivate;

/**
 * Security check
 */
defined('ABSPATH') or die();

/**
 * Define crutial constants
 */
define('PLUGIN_MAIN_FILE', __FILE__);
define('PLUGIN_DIR', __DIR__);

/**
 * Init Plugin class
 */
if( class_exists('Plugin\MyPlugin\CustomPlugin') ){
    $pluginClass = new CustomPlugin();
    $pluginClass->register();
    $pluginClass->addPostType();
}

// add_action('et_builder_render_layout', [$pluginClass, 'getBooks']);