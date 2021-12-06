<?php

// https://www.youtube.com/watch?v=ruDWmHRNxvE&list=PLriKzYyLb28kR_CPMz8uierDWC2y3znI2&index=11

namespace Plugin\MyPlugin;

use Plugin\MyPlugin\CustomPluginOnActivate;
use Plugin\MyPlugin\CustomPluginOnDeactivate;
use Plugin\MyPlugin\CustomPluginOnUninstall;
use Plugin\MyPlugin\Admin\AdminSettingPage;

class CustomPlugin
{

    public static $pluginName = PLUGIN_NAME;
    private $postName = "book";

    /* 
    * @var Plugin\MyPlugin\Admin\AdminSettingPage $adminSettingPage 
    * 
    */
    private $adminSettingPage;

    public function __construct()
    {
        CustomPluginOnActivate::registerActivationHook();
        CustomPluginOnDeactivate::registerDeactivationHook();
        CustomPluginOnUninstall::registerUninstallHook();

        /* @var Plugin\MyPlugin\Admin\AdminSettingPage $this->adminSettingPage */
        $this->adminSettingPage = new AdminSettingPage();
    }

    public function register()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdmin']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueFront']);
        // add_action('init', [$this, 'registerPostType']);

        $this->adminSettingPage->register();
    }

    // public function registerPostType()
    // {
    //     $postTypeNameSingular = 'book';
    //     register_post_type($postTypeNameSingular, [
    //         'public' => true,
    //         'label' => ucfirst($postTypeNameSingular . 's'),
    //     ]);
    // }

    // public function getBooks()
    // {
    //     $books = get_posts([
    //         'post_type' => 'book',
    //         'num_posts' => -1,
    //     ]);

    //     foreach ($books as $book) {
    //         echo $book->ID . "<br>";
    //         echo $book->post_title . "<br>";
    //         echo $book->post_excerpt . "<br>";
    //         echo $book->post_content . "<br>";
    //     }
    //     // echo "<pre>";
    //     // print_r($books);

    // }

    public function enqueueAdmin()
    {
        wp_enqueue_style('adminpluginstyles', plugins_url('/assets/admin/admin.css', PLUGIN_MAIN_FILE));
        wp_enqueue_style('adminpluginscripts', plugins_url('/assets/admin/admin.js', PLUGIN_MAIN_FILE));
    }

    public function enqueueFront()
    {
        wp_enqueue_style('frontpluginstyles', plugins_url('/assets/styles.css', PLUGIN_MAIN_FILE));
        wp_enqueue_style('frontpluginscripts', plugins_url('/assets/script.js', PLUGIN_MAIN_FILE));
    }
}
