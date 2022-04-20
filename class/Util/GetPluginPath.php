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

namespace Plugin\MyPlugin\Util;

/**
 * GetPluginPath class is responsible for turnign off or remove all functionality, data and 
 * files from WP system when user decide to delete the extension.
 *
 * @category Plugin\MyPlugin
 * @package  MyPlugin
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     none
 */
class GetPluginPath
{
    /**
     * Generate proper path regardles from platform to a plugin dir with __DIR__
     *
     * @return string Plugin directory path
     */
    public static function getPath()
    {
        return str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, PLUGIN_DIR);
    }
}
