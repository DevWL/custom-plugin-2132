<?php

/**
 * Shortcode class. PHP version 5.6+
 * 
 * @category Plugin\MyPlugin\Front
 * @package  MyPlugin
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     none
 */

namespace Plugin\MyPlugin;

use Plugin\MyPlugin\Util\GetPluginPath;

/**
 * CustomPluginOnActivate class is responsible to perform some actions 
 * for example: creation of BD, file or some other action
 *
 * @category Plugin\MyPlugin
 * @package  MyPlugin
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     none
 */
class CustomPluginOnActivate
{
    
    /**
     * Create testing directory on plugin activation and flush the rewrite rules.
     *
     * @return void
     */
    public static function activate()
    {

        mkdir(GetPluginPath::getPath() .'/temp', 0777);
        flush_rewrite_rules();

    }

    /**
     * Static method registering above activate method to WP system
     *
     * @return void
     */
    public static function registerActivationHook()
    {
        register_activation_hook(PLUGIN_MAIN_FILE, [ __CLASS__, 'activate' ]);
    }
}