<?php

namespace Plugin\MyPlugin\Admin;

use Plugin\MyPlugin\CustomPlugin;

class AdminSettingPage
{
    public function register()
    {
        add_action('admin_menu', [$this, 'addAdminPage']);
        add_filter('plugin_action_links_' . PLUGIN_DIR_FILE, [$this, 'settingLinks']);
    }

    /**
     * Creates Admin Page in WP Admina panell
     * Tutorial: https://www.youtube.com/watch?v=ruDWmHRNxvE&list=PLriKzYyLb28kR_CPMz8uierDWC2y3znI2&index=10
     * Icons list: https://developer.wordpress.org/resource/dashicons/#admin-plugins
     * @return void
     */
    public function addAdminPage()
    {
        add_menu_page(CustomPlugin::$pluginName, CustomPlugin::$pluginName, 'manage_options', strtolower(CustomPlugin::$pluginName), [$this, 'adminIndexPage'], 'dashicons-admin-plugins', 110);
    }

    public function adminIndexPage()
    {
        $path = PLUGIN_DIR . '/templates/Admin/SettingPage.php';
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
        require_once $path;
    }

    /**
     * Add setting link under plugin in plugin page
     * https://youtu.be/ruDWmHRNxvE?t=1017
     * @param $links
     * @return array of links in plugin description at plugin page
     */
    public function settingLinks($linksArr)
    {
        $settingsURL = '<a href="https://dologel.dv/wp-admin/admin.php?page='.PLUGIN_NAME .'">Settings</a>';
        array_push($linksArr, $settingsURL);
        return $linksArr;
    }
}
