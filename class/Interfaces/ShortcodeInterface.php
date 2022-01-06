<?php

namespace Plugin\MyPlugin\Interfaces;

interface ShortcodeInterface
{
    /**
     * Class constructor should call registerShortcode 
     */
    public function __construct();

    /**
     * Function which will register shortcodes
     *
     * @return void
     */
    public function registerShortcode($name, $method);
}
