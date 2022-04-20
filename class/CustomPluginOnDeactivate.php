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
 * CustomPluginOnDeactivate class is responsible for turnign off or remove all functionality, data and 
 * files from WP system when user decide to delete the extension.
 *
 * @category Plugin\MyPlugin
 * @package  MyPlugin
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     none
 */
class CustomPluginOnDeactivate
{

    /**
     * Remove test dir if deactivated
     *
     * @return void
     */
    public static function deactivate()
    {
        rmdir(GetPluginPath::getPath() .'/temp');
    }

    /**
     * Static method registering above activate method to WP system
     *
     * @return void
     */
    public static function registerDeactivationHook()
    {
        register_deactivation_hook(PLUGIN_MAIN_FILE, [ __CLASS__, 'deactivate' ]);
    }
}
