<?php

namespace Plugin\MyPlugin\Util;

class HookDebuger
{
    public static function checkHooksFor(string $hook = null): void
    {
        if(empty($hook)){
            throw new \Exception("hook param should not be null", 1);
        }

        global $wp_actions, $wp_filter;
        if( empty( $hook ) || !isset( $wp_filter[$hook] ) )
            return;
    
        print '<pre>';
        print_r( $wp_filter[$hook] );
        print '</pre>';
    }

    public static function checkHooks(): void
    {
        global $wp_filter, $wp_actions;

        add_action( 'all', function ( $tag ){
            global $debug_tags;
            $debug_tags = [];
            if ( in_array( $tag, $debug_tags ) ) {
                return;
            }
            // echo "<div style='display: inline-block; padding: 0.2em; margin: 0.2em; border: 1px solid black; font-size: 0.8em'>" . $tag . "</div>";
            $debug_tags[] = $tag;
        } );
        echo "<pre>";
            // print_r($GLOBALS['wp_filter']);
            var_dump($GLOBALS);
        echo "</pre>";
    }
    
}
