<?php

namespace Plugin\MyPlugin;

use Plugin\MyPlugin\Util\GetPluginPath;

class CustomPluginOnActivate
{
    
    public static function activate(){

        mkdir(GetPluginPath::getPath() .'/temp', 0777);
        flush_rewrite_rules();

    }

    public static function registerActivationHook()
    {
        register_activation_hook( PLUGIN_MAIN_FILE, [ __CLASS__, 'activate' ] );
    }
}