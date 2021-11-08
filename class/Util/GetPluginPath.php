<?php

namespace Plugin\MyPlugin\Util;

class GetPluginPath
{
    /**
     * Generate proper path regardles from platform to a plugin dir with __DIR__
     *
     * @return string Plugin directory path
     */
    public static function getPath(){
        return str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, PLUGIN_DIR);
    }
}
