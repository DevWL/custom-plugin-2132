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



defined('ABSPATH') or die();
define('PLUGIN_MAIN_FILE', __FILE__);
define('PLUGIN_DIR', __DIR__);

if( class_exists('Plugin\MyPlugin\CustomPlugin') ){
    $pluginClass = new CustomPlugin();
    $pluginClass->register();
    $pluginClass->addPostType();
}

// // activate plugin
// register_activation_hook( __FILE__, [ 'CustomPluginOnActivate', 'activate' ] );

// // deactivate plugin
// register_deactivation_hook( __FILE__, [ $pluginClass, 'deactivate' ] );
// register_deactivation_hook( __FILE__, [ $pluginClass, 'unistall' ] );

// add_action('et_builder_render_layout', [$pluginClass, 'getBooks']);

// // $pluginClass::checkHooks();
//  // HookDebuger::checkHooks();

// echo GetPluginPath::getPath();