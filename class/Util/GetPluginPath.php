<?php

namespace Plugin\MyPlugin\Util;

use Plugin\MyPlugin\CustomPlugin;

class GetPluginPath
{
    /**
     * Generate proper path regardles from platform to a plugin dir with __DIR__
     *
     * @return string Plugin directory path
     */
    public static function getPath(){
        return CustomPlugin::getPluginPath();
    }
}
