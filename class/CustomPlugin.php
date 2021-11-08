<?php

namespace Plugin\MyPlugin;

use Plugin\MyPlugin\CustomPluginOnActivate;
use Plugin\MyPlugin\CustomPluginOnDeactivate;
use Plugin\MyPlugin\CustomPluginOnUninstall;

class CustomPlugin
{

    public function __construct(){
        CustomPluginOnActivate::registerActivationHook();
        CustomPluginOnDeactivate::registerDeactivationHook();
        CustomPluginOnUninstall::registerUninstallHook();
    }

    public function registerPostType(){
        $postTypeNameSingular = 'book';
        register_post_type($postTypeNameSingular, [
            'public' => true,
            'label' => $postTypeNameSingular.'s'
        ]);
    }

    public function getBooks(){
        $books = get_posts( [
            'post_type' => 'book',
            'num_posts' => -1
        ] );

        foreach ($books as $book){
            echo $book->ID ."<br>"; 
            echo $book->post_title ."<br>"; 
            echo $book->post_excerpt ."<br>";
            echo $book->post_content ."<br>"; 
        }
        // echo "<pre>";
        // print_r($books);

    }


    /**
     * Generate proper path regardles from platform to a plugin dir with __DIR__
     *
     * @return string Plugin directory path
     */
    public static function getPluginPath(){
        return str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, PLUGIN_DIR);
    }

    public function enqueueAdmin(){
        wp_enqueue_style( 'adminpluginstyles', plugins_url('/assets/admin/admin.css', PLUGIN_MAIN_FILE ));
        wp_enqueue_style( 'adminpluginscripts', plugins_url('/assets/admin/admin.js', PLUGIN_MAIN_FILE ));
    }

    public function enqueueFront(){
        wp_enqueue_style( 'frontpluginstyles', plugins_url('/assets/styles.css', PLUGIN_MAIN_FILE ));
        wp_enqueue_style( 'frontpluginscripts', plugins_url('/assets/script.js', PLUGIN_MAIN_FILE ));
    }

    public function register(){
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueAdmin' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueueFront' ] );
    }

    public function addPostType(){
        add_action( 'init', [$this, 'registerPostType'] );
    }

}