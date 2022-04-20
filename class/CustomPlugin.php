<?php

/**
 * Shortcode class. PHP version 5.6+
 * 
 * @category Plugin\MyPlugin
 * @package  MyPlugin
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     none
 */

// https://www.youtube.com/watch?v=ruDWmHRNxvE&list=PLriKzYyLb28kR_CPMz8uierDWC2y3znI2&index=11

namespace Plugin\MyPlugin;

use Plugin\MyPlugin\CustomPluginOnActivate;
use Plugin\MyPlugin\CustomPluginOnDeactivate;
use Plugin\MyPlugin\CustomPluginOnUninstall;
use Plugin\MyPlugin\Admin\AdminSettingPage;

/**
 * Security check
 */
defined('ABSPATH') or die("No direct access allowed");

/**
 * This class provide a set of shortcodes for woocommerce products,
 * categories and tags related to post_type=product
 *
 * @category Plugin\MyPlugin
 * @package  MyPlugin
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     tag in class commentphpcs
 */
class CustomPlugin
{

    public static $pluginName = PLUGIN_NAME;
    // private $postName = "book";

    /* 
    * @var Plugin\MyPlugin\Admin\AdminSettingPage $_adminSettingPage 
    */
    private $_adminSettingPage;
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function __construct()
    {
        CustomPluginOnActivate::registerActivationHook();
        CustomPluginOnDeactivate::registerDeactivationHook();
        CustomPluginOnUninstall::registerUninstallHook();

        /* @var Plugin\MyPlugin\Admin\AdminSettingPage $this->_adminSettingPage */
        $this->_adminSettingPage = new AdminSettingPage();
    }

    /**
     * This function is responsible for registring js and css scripts
     * 
     * @see $this->enqueueAdmin() and $this->enqueueFront() methods
     *
     * @return void
     */
    public function register()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdmin']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueFront']);
        // add_action('init', [$this, 'registerPostType']);

        $this->_adminSettingPage->register();
    }

    /**
     * Enque css and js for admin area.
     *
     * @return void
     */
    public function enqueueAdmin()
    {
        wp_enqueue_style('adminpluginstyles', plugins_url('/assets/admin/admin.css', PLUGIN_MAIN_FILE));
        wp_enqueue_style('adminpluginscripts', plugins_url('/assets/admin/admin.js', PLUGIN_MAIN_FILE));
    }

    /**
     * Enque css and js for fornt area.
     *
     * @return void
     */
    public function enqueueFront()
    {
        wp_enqueue_style('frontpluginstyles', plugins_url('/assets/styles.css', PLUGIN_MAIN_FILE));
        wp_enqueue_style('frontpluginscripts', plugins_url('/assets/script.js', PLUGIN_MAIN_FILE));
    }
}
