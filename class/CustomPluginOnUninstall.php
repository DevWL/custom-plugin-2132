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

if (! defined('ABSPATH')) {
    die('No direct access allowed');
}

/**
 * CustomPluginOnUninstall class is responsible to remove all data and 
 * files from WP system when user decide to delete the extension.
 * 
 * Beofre using this functionality make sure to create database backup!
 *
 * @category Plugin\MyPlugin
 * @package  MyPlugin
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     none
 */
class CustomPluginOnUninstall
{

    /**
     * Static method - Select and remove all data from 
     * custom post registeded by this plugin.
     *
     * @return void
     */
    public static function uninstall()
    {
        global $wpdb;

        /**
         * TEST OUTPUT BEFORE CHANGING TO "DELETE"
         * 
         * This query removes all asosiations in post_meat to 
         * non exsisting posts in wp_posts table.
         */
        $wpdb->query("SELECT * FROM wp_posts WHERE post_type = 'book'");
        $wpdb->query("SELECT * FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
        $wpdb->query("SELECT * FROM wp_term_relationship WHERE object_id NOT IN (SELECT id FROM wp_posts)");

        /* Uncoment only if SELECT output was tested (TEST FIRST!) */

        // $wpdb->query("DELETE FROM wp_posts WHERE post_type = 'book'");
        // $wpdb->query("SELECT FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
        // $wpdb->query("SELECT FROM wp_term_relationship WHERE object_id NOT IN (SELECT id FROM wp_posts)");

        /* ALTERNATIVLY USE */

        // $books = get_posts(['post_type' => 'book', 'numberposts' => -1]);
        // foreach ($books as $book) {
        //     wp_delete_post($book->ID, true); // 'true' stands for force delete (delete if privet draft and so on ...)
        //     // add delete_post_meta() // you need to know the post meta keys here so you might need to query them first with SQL
        // }
        
    }

    /**
     * Static function which will call the unistall method of this class
     * Note the use of __CLASS__ instead of this as this is a static method.
     * 
     * @see called in CustomPlugin class in __construct method
     *
     * @return void
     */
    public static function registerUninstallHook()
    {
        register_uninstall_hook(PLUGIN_MAIN_FILE, [ __CLASS__, 'uninstall' ]);
    }

}
