<?php
/**
 * Plugin Name:       Custom Plugin One
 * https://www.youtube.com/watch?v=FpnHvp9x48c&list=PLriKzYyLb28kR_CPMz8uierDWC2y3znI2&index=6
 */

defined('ABSPATH') or die();

class CustomPluginOne
{
    private $pluginPath;

    public function __construct(){
        $this->pluginPath = $this->getPluginPath();
        add_action( 'init', [$this, 'add_post_type'] );
        
    }

    public function activate(){
        flush_rewrite_rules();
        mkdir($this->pluginPath .'/temp', 0776);
    }

    public function deactivate(){
        rmdir($this->pluginPath .'/temp');
    }

    static function unistall(){
        
    }

    public function add_post_type(){
        register_post_type('book', [
            'public' => true,
            'label' => 'Books'
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
    public function getPluginPath(){
        return str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, __DIR__);
    }

    public function enqueueAdmin(){
        wp_enqueue_style( 'adminpluginstyles', plugins_url('/assets/admin/admin.css', __FILE__ ));
        wp_enqueue_style( 'adminpluginscripts', plugins_url('/assets/admin/admin.js', __FILE__ ));
    }

    public function enqueueFront(){
        wp_enqueue_style( 'frontpluginstyles', plugins_url('/assets/styles.css', __FILE__ ));
        wp_enqueue_style( 'frontpluginscripts', plugins_url('/assets/script.js', __FILE__ ));
    }

    public function register(){
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueAdmin' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueueFront' ] );
    }
}

if( class_exists('CustomPluginOne') ){
    $pluginClass = new CustomPluginOne();
    $pluginClass->register();
}

// activate plugin
register_activation_hook( __FILE__, [ $pluginClass, 'activate' ] );

// deactivate plugin
register_deactivation_hook( __FILE__, [ $pluginClass, 'deactivate' ] );
register_deactivation_hook( __FILE__, [ $pluginClass, 'unistall' ] );


$pluginClass->getBooks();