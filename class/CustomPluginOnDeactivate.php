<?php

namespace Plugin\MyPlugin;

use Plugin\MyPlugin\Util\GetPluginPath;

class CustomPluginOnDeactivate
{
    public static function deactivate(){
        rmdir(GetPluginPath::getPath() .'/temp');
    }

    public static function registerDeactivationHook()
    {
        register_deactivation_hook( PLUGIN_MAIN_FILE, [ __CLASS__, 'deactivate' ] );
    }
}
