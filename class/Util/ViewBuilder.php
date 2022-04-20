<?php

/**
 * Shortcode class. PHP version 5.6+
 * DROPED - Tobe daleted! class not in use
 * 
 * @category Plugin\MyPlugin\Util
 * @package  WordPress
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     tag in class commentphpcs
 */

namespace Plugin\MyPlugin\Util;

/**
 * This class provide a set of shortcodes for woocommerce products,
 * categories and tags related to post_type=product
 *
 * @category Plugin\MyPlugin\Util
 * @package  WordPress
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     tag in class commentphpcs
 */
class ViewBuilder
{

    /**
     * Return Div
     *
     * @param string $content 
     * @param string $cssID 
     * @param string $cssClass 
     * @param string $custom 
     * 
     * @return string 
     */
    static function div(string $content, string $cssID="", string $cssClass="", string $custom = "") : string
    {
        $output = "<div id='$cssID' class='$cssClass' $custom >";
        $output .= $content;
        $output .= "</div>";
        return $output;
    }
}
