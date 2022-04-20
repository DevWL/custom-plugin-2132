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
class SlugGenerator
{
    /**
     * Generate proper path regardles from platform to a plugin dir with __DIR__
     *
     * @return string Plugin directory path
     */
    public static function createSlug($str, $delimiter = '-'){
        $slug = strtolower(
            trim(
                preg_replace('/[\s-]+/', $delimiter, 
                    preg_replace('/[^A-Za-z0-9-]+/', $delimiter, 
                        preg_replace('/[&]/', 'and', 
                            preg_replace('/[\']/', '', 
                                iconv('UTF-8', 'ASCII//TRANSLIT', $str)
                            )
                        )
                    )
                ), $delimiter
            )
        );
        
        return $slug;
    } 
}
