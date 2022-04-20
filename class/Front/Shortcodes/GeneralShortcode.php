<?php

/**
 * Shortcode class. PHP version 7.1+
 * 
 * @category Plugin\MyPlugin\Front\Shortcodes
 * @package  WordPress
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     tag in class commentphpcs
 */

namespace Plugin\MyPlugin\Front\Shortcodes;

/**
 * GeneralShortcode class adds some common functionality for shortcode 
 * registration and holds an array of registered shortcodes.
 * 
 * @category Plugin\MyPlugin\Front\Shortcodes
 * @package  WordPress
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     notdefined
 */
class GeneralShortcode
{

    /**
     * Holds array of shortcodes name
     */
    protected $shortcodeList=[];

    /**
     * This method ads 
     *
     * @param string $shorcodeName 
     * @param string $methodName   __FUNCTION__
     * 
     * @return void 
     */
    protected function addShortcode($shorcodeName, $methodName)
    {
        if (isset($this->shortcodeList[$shorcodeName])) {
            throw new \Exception("This shortcode is already registered", 1);
        }
        $this->shortcodeList[$shorcodeName] = $methodName;
    }

    /**
     * Helper function to register shortcodes inside a class
     *
     * @return void 
     */
    protected function registerAllShortcodes()
    {
        if (count($this->shortcodeList) == 0) {
            return;
        } 
        foreach ($this->shortcodeList as $keyShortcodeName => $valueMethodName) {
            $this->registerShortcode($keyShortcodeName, $valueMethodName);
        }
    }

    /**
     * Utility
     * 
     * Support function for registering shortcodes. 
     * Could be implemented in abstract class instead.
     *
     * @param string $name   user defined custom name of the shortcode
     * @param string $method which will be triggered (note the $this)
     * 
     * @return void
     */
    public function registerShortcode($name, $method)
    {
        add_shortcode($name, [$this, $method]);
    }

}
