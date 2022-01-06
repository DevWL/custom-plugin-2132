<?php

/**
 * @package WordPress
 */

namespace Plugin\MyPlugin\Admin\CustomPost;

use Plugin\MyPlugin\Interfaces\Admin\CustomPostTypeInterface;

class ExamplePostType implements CustomPostTypeInterface
{
    /**
     * class constructor.
     */
    public function __construct(string $customPostTypeName = "book")
    {
        $this->customPostTypeName = $customPostTypeName;
        add_action('init', [$this, 'registerPostType']);
        $this->registerShortcodes();
    }

    public function registerPostType()
    {
        $postTypeNameSingular = $this->customPostTypeName;
        register_post_type($postTypeNameSingular, [
            'public' => true,
            'label' => ucfirst($postTypeNameSingular . 's'),
        ]);
    }

    public function showBooks($catId = false)
    {
        $query = [
            'post_type' => $this->customPostTypeName, // "book"
            'num_posts' => -1, // unlimited
        ];

        if($catId !== false){
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
     *
     * @return void
     */
    public function registerShortcodes()
    {
        // $shortcodeName = 'list'.ucfirst($this->customPostTypeName)."s";
        add_shortcode('showbooks', [$this, 'showBooks']);
    }


}