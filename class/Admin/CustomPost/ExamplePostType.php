<?php

/**
 * Shortcode class. PHP version 5.6+
 * 
 * @category Plugin\MyPlugin\Admin\CustomPost
 * @package  MyPlugin
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     none
 */

namespace Plugin\MyPlugin\Admin\CustomPost;

use Plugin\MyPlugin\Interfaces\Admin\CustomPostTypeInterface;

/**
 * Security check
 */
defined('ABSPATH') or die("No direct access allowed");

/**
 * Creates a custom PostType
 *
 * @category Plugin\MyPlugin\Front
 * @package  MyPlugin
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     none
 */
class ExamplePostType implements CustomPostTypeInterface
{
    /**
     * Undocumented function
     *
     * @param string $customPostTypeName (name of the posttype - singular)
     */
    public function __construct(string $customPostTypeName)
    {
        $this->customPostTypeName = $customPostTypeName;
        add_action('init', [$this, 'registerPostType']);
        $this->registerShortcodes();
    }

    /**
     * Registers posttype as plurar
     * 
     * @see documentation on register_post_type(...) function 
     *  at https://developer.wordpress.org/reference/functions/register_post_type/
     * @see custom field (no plugin) tutorial https://www.youtube.com/watch?v=QwBeyYP99WY
     * @see how to use custom fields at 
     *  https://blog.teamtreehouse.com/adding-custom-fields-to-a-custom-post-type-the-right-way
     *
     * @return void
     */
    public function registerPostType()
    {
        $postTypeNameSingular = $this->customPostTypeName;
        
        register_post_type(
            $postTypeNameSingular, 
            [
                'public' => true,
                'label' => ucfirst($postTypeNameSingular . 's'),
                'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields' ),
            ]
        );
    }

    /**
     * Basic output method
     *
     * @param bool $catId 
     * 
     * @return void 
     */
    public function showBooks($catId = false)
    {
        $query = [
            'post_type' => $this->customPostTypeName, // "book"
            'num_posts' => -1, // unlimited
        ];

        if ($catId !== false) {
            $query["terms"]=$catId;
        }

        $books = get_posts($query);
        
        $output = "Books List: <br>";
        foreach ($books as $book) {
            $output .= $book->ID . "<br>";
            $output .= $book->post_title . "<br>";
            $output .= $book->post_excerpt . "<br>";
            $output .= $book->post_content . "<br>";
        }

        return $output;

    }

    /**
     * This function register shortcode for given function
     * TODO - need to be moved in to GenearlPostType class and extend from it.
     *
     * @return void
     */
    public function registerShortcodes()
    {
        // $shortcodeName = 'list'.ucfirst($this->customPostTypeName)."s";
        add_shortcode('showbooks', [$this, 'showBooks']);
    }


}