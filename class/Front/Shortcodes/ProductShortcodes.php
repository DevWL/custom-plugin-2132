<?php 

/**
 * @package CustomPlugin 
 */


namespace Plugin\MyPlugin\Front\Shortcodes;

// use Plugin\MyPlugin\Front\Shortcodes\GeneralShortcode;
use Plugin\MyPlugin\Interfaces\ShortcodeInterface;

class ProductShortcodes implements ShortcodeInterface
{
    public function __construct(){
        $this->registerShortcode('showproductscategories', 'showProductCatShortcode');
        $this->registerShortcode('cattags', 'displayCatTagsFromObjects');
    }

    /** 
     * 
     * Method showProductCatShortcode returns aoutput for Custom Shortcode 
     * It purpose is to disaply all product categories and subcategories
     * Additional info at: https://stackoverflow.com/questions/21009516/get-woocommerce-product-categories-from-wordpress
     * https://wordpress.stackexchange.com/questions/193110/wordpress-get-posts-by-category
     * https://stackoverflow.com/questions/31904758/woocommerce-get-product-tags-in-array
     * 
     */
    public function showProductCatShortcode()
    {
        $output = "";

        $taxonomy     = 'product_cat';
        $orderby      = 'name';  
        $show_count   = 0;      // 1 for yes, 0 for no
        $pad_counts   = 0;      // 1 for yes, 0 for no
        $hierarchical = 1;      // 1 for yes, 0 for no  
        $title        = '';  
        $empty        = 0;
        
        $args = array(
                'taxonomy'     => $taxonomy,
                'orderby'      => $orderby,
                'show_count'   => $show_count,
                'pad_counts'   => $pad_counts,
                'hierarchical' => $hierarchical,
                'title_li'     => $title,
                'hide_empty'   => $empty
        );
        $all_categories = get_categories( $args );
        foreach ($all_categories as $cat) {
            if($cat->category_parent == 0) {
                $category_id = $cat->term_id; 

                $output .= '<br /><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';
                
                $args2 = array(
                        'taxonomy'     => $taxonomy,
                        'child_of'     => 0,
                        'parent'       => $category_id,
                        'orderby'      => $orderby,
                        'show_count'   => $show_count,
                        'pad_counts'   => $pad_counts,
                        'hierarchical' => $hierarchical,
                        'title_li'     => $title,
                        'hide_empty'   => $empty
                );

                $sub_cats = get_categories( $args2 );
                if($sub_cats) {
                    foreach($sub_cats as $sub_category) {
                        $output .= $sub_category->name;
                    }   
                }
            }       
        }

        return $output;
    }

    public function getAllTags(){

        $tags = get_terms( 'product_tag' );
        // $tag_array = [];
        // if ( ! empty( $tags ) && ! is_wp_error( $tags ) ){
        //     foreach ( $tags as $tag ) {
        //         $tag_array[] = $tag->name;
        //     }
        // }

        var_dump($tags[0]->to_array());

        return $tags;

    }

    public function getCategoryTags($cat_name = "Nowe")
    {

        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='product' LIMIT 4" );
        $results = $wpdb->get_results( "SELECT t.name FROM wp_termmeta tm
            LEFT JOIN wp_terms t ON tm.term_id = t.term_id
            WHERE `meta_key` = 'product_count_product_tag'
            ORDER BY t.name ASC        
        " );

        $terms = get_terms( 'product_tag' );
        $term_array = [];
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $term_array[] = $term->name;
            }
        }
        // $arr = $terms[0];
        $arr = array_filter($terms, function($v){
            return $v->count > 0;
        });

        var_dump($arr);
        // var_dump($arr->name, $arr->count);

        return $results;

    }

    /**
     * This functino convert array of object from get_terms function to a linked list which then can be styed on frontend
     * targeting css ul id selector.
     *
     * @return string $print
     */
    public function displayCatTagsFromObjects(){
        $tagsArr = $this->getAllTags();
        $print = "<ul id='ptaglist'>";
        foreach ($tagsArr as $key => $value) {
            $print .= "<li><a href='https://rolagra.dv/product-tag/$value->slug/'>$value->name</a></li>";
        }
        $print .= "</ul>";
        return $print;
    }

    public function registerShortcode($name, $method){
        add_shortcode($name, [$this, $method]);
    }

// https://stackoverflow.com/questions/22787341/get-all-tags-based-on-specific-category-including-all-tags-from-child-categorie
// https://wordpress.stackexchange.com/questions/307511/get-terms-of-posts-with-category-with-sql

}
