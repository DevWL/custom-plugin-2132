<?php
/**
 * Shortcode class. PHP version 5.6+
 * 
 * @category Plugin\MyPlugin\Interfaces\Admin
 * @package  MyPlugin
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     none
 */

namespace Plugin\MyPlugin\Interfaces\Admin;

/**
 * Post Type Interface
 *
 * @category Plugin\MyPlugin\Interfaces\Admin
 * @package  MyPlugin
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     none
 */
interface CustomPostTypeInterface
{

    /**
     * Constructor have to be provided with custom post type name (singular)
     *
     * @param string $customPostTypeName 
     */
    public function __construct(string $customPostTypeName);
}
