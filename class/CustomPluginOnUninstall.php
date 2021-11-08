<?php

namespace Plugin\MyPlugin;

class CustomPluginOnUninstall
{
    public static function uninstall(){
        global $wpdb;

        /**
         * CHECK BEFORE CHANGING TO DELETE FROM
         */
        $wpdb->query("SELECT * FROM wp_posts WHERE post_type = 'book'");
        $wpdb->query("SELECT * FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
        $wpdb->query("SELECT * FROM wp_term_relationship WHERE object_id NOT IN (SELECT id FROM wp_posts)");
        
    }

    public static function registerUninstallHook(){
        register_uninstall_hook( PLUGIN_MAIN_FILE, [ __CLASS__, 'uninstall' ] );
    }

}
