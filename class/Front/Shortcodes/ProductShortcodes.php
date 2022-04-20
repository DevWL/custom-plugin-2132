<?php
/**
 * Shortcode class. PHP version 5.6+
 *
 * @category Plugin\MyPlugin\Front
 * @package  WordPress
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     none
 */
namespace Plugin\MyPlugin\Front\Shortcodes;
use Plugin\MyPlugin\Front\Shortcodes\GeneralShortcode;
use Plugin\MyPlugin\Interfaces\ShortcodeInterface;
use Plugin\MyPlugin\Util\SlugGenerator;
/**
 * This class provide a set of shortcodes for woocommerce products,
 * categories and tags related to post_type=product
 *
 * @category Plugin\MyPlugin\Front
 * @package  WordPress
 * @author   Wiktor Liszkiewicz <w.liszkiewicz@gmail.com>
 * @license  all rights reserved
 * @link     none
 */
class ProductShortcodes extends GeneralShortcode implements ShortcodeInterface
{
    /**
     * Class constructor
     *
     * @see this::registerShortcode() For description of registering functions
     *
     * @return void
     */
    public function __construct()
    {
        /* @see GeneralShortcode class for more infromation about addShortcode and registerAllShortcodes methods*/
        $this->addShortcode('showproductscategories', 'displayAllTagsAndCat');
        $this->registerAllShortcodes();
    }

    /**
     * Model & View
     *
     * Method showProductCatShortcode returns aoutput for Custom Shortcode
     * It purpose is to disaply all product categories and subcategories
     *
     * @see Additional info at:
     * https://stackoverflow.com/questions/21009516/get-woocommerce-product-categories-from-wordpress
     * https://wordpress.stackexchange.com/questions/193110/wordpress-get-posts-by-category
     * https://stackoverflow.com/questions/31904758/woocommerce-get-product-tags-in-array
     * https://stackoverflow.com/questions/22787341/get-all-tags-based-on-specific-category-including-all-tags-from-child-categorie
     * https://wordpress.stackexchange.com/questions/307511/get-terms-of-posts-with-category-with-sql
     *
     * @return void
     */
    public function showProductCatShortcode()
    {
        $output = "";
        $taxonomy = 'product_cat';
        $orderby = 'name';
        $show_count = 0; // 1 for yes, 0 for no
        $pad_counts = 0; // 1 for yes, 0 for no
        $hierarchical = 1; // 1 for yes, 0 for no
        $title = '';
        $empty = 0;
        $options1 = array(
            'taxonomy' => $taxonomy,
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hierarchical' => $hierarchical,
            'title_li' => $title,
            'hide_empty' => $empty,
        );
        $all_categories = get_categories($options1);
        foreach ($all_categories as $cat) {
            if ($cat->category_parent == 0) {
                $output .= '<br /><a href="'
                . get_term_link($cat->slug, 'product_cat') . '">'
                . $cat->name
                    . '</a>';
                $options2 = array(
                    'taxonomy' => $taxonomy,
                    'child_of' => 0,
                    'parent' => $cat->term_id,
                    'orderby' => $orderby,
                    'show_count' => $show_count,
                    'pad_counts' => $pad_counts,
                    'hierarchical' => $hierarchical,
                    'title_li' => $title,
                    'hide_empty' => $empty,
                );
                $sub_cats = get_categories($options2);
                if ($sub_cats) {
                    foreach ($sub_cats as $cat) {
                        $output .= '<br /><a href="'
                        . get_term_link($cat->slug, 'product_cat') . '">'
                        . $cat->name
                            . '</a>';
                    }
                }
            }
        }
        return $output;
    }

    /**
     * Model
     *
     * Function which return an array of Tag objects.
     *
     * @return array of Tag objects
     */
    public function getAllTags()
    {
        $tags = get_terms('product_tag');
        return $tags;
    }

    /**
     * Model
     *
     * This function return all product tags
     *
     * @return [objects] $results
     */
    public function getNotEmptyAllTags()
    {
        $terms = get_terms('product_tag'); // 'for product tags use product_tag' for post tag use 'post_tag'
        $term_array = [];
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $term_array[] = $term->name;
            }
        }
        $arr = array_filter($terms, function ($v) {
            return $v->count > 0;
        });
        // var_dump($arr->name, $arr->count);
        return $results;
    }

    /**
     * View
     *
     * This functino convert array of object from get_terms function to a linked
     * list which then can be styled on frontend targeting css ul id selector.
     *
     * @return string $print Returns raw html output.
     */
    public function displayCatTagsFromObjects()
    {
        $tagsArr = $this->getAllTags();
        $print = "<ul id='ptaglist'>";
        foreach ($tagsArr as $key => $value) {
            $print .= "
                <li>
                    <a href='https://rolagra.dv/product-tag/$value->slug/'>
                        $value->name
                    </a>
                </li>
            ";
        }
        $print .= "</ul>";
        return $print;
    }

    /**
     * This function returns non epmty tags.
     * 
     * @see https://servebolt.com/articles/how-does-caching-work-in-wordpress/
     *
     * @return array $results (array of category arrays)
     */
    public function getTopLevelNonEmptyCategories()
    {
        global $wpdb;

        $cache = wp_cache_get( 'categories_tree' ); 

        if ( false === $cache) { 
            $cache = $wpdb->get_results(
                "SELECT t.term_id, t.name, t.slug,  tt.taxonomy, tt.parent, tt.count FROM wp_terms t
                LEFT JOIN wp_term_taxonomy tt ON t.term_id = tt.term_taxonomy_id
                WHERE tt.taxonomy = 'product_cat'
                AND tt.parent = 0
                AND tt.count > 0
                ORDER BY tt.count DESC"
            );

            wp_cache_set( 'categories_tree', $cache, '', 3600);
        }
        // Do something with $result;
        // $results = $wpdb->get_results(
        //     "SELECT t.term_id, t.name, t.slug,  tt.taxonomy, tt.parent, tt.count FROM wp_terms t
        //     LEFT JOIN wp_term_taxonomy tt ON t.term_id = tt.term_taxonomy_id
        //     WHERE tt.taxonomy = 'product_cat'
        //     AND tt.parent = 0
        //     AND tt.count > 0
        //     ORDER BY tt.count DESC"
        //);
        return $cache;
    }

    /**
     * Geta all tags of a category including it sub categories tags.
     *
     * @param int $id (Parent category id)
     *
     * @return array $data
     */
    public function getAllCategoryTags($id, $catname)
    {

        $slug = SlugGenerator::createSlug($catname);
        global $wpdb;

        $cache = wp_cache_get( $slug.'_cache_tag_list' );
        if ( false === $cache) { 
            $cache = $wpdb->get_results(
                "
                WITH recursive cteCategory(term_id) AS
                (
                    SELECT t.term_id FROM wp_terms t
                    LEFT JOIN wp_term_taxonomy tt
                    ON tt.term_taxonomy_id = t.term_id
                    WHERE tt.term_taxonomy_id = " . $id . "
                    AND tt.taxonomy = 'product_cat'
                    UNION ALL
                    SELECT t2.term_id FROM wp_terms t2
                    LEFT JOIN wp_term_taxonomy tt2
                    ON tt2.term_taxonomy_id = t2.term_id
                    INNER JOIN cteCategory
                    ON tt2.parent = cteCategory.term_id
                )
                SELECT DISTINCT t.* FROM wp_posts AS p
                LEFT JOIN wp_term_relationships tr ON p.ID = tr.object_id
                LEFT JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                LEFT JOIN wp_terms t ON t.term_id = tt.term_id
                WHERE p.post_type='product'
                AND p.post_status = 'publish'
                AND tt.taxonomy = 'product_tag'
                AND p.ID IN
                    (SELECT p.ID FROM wp_posts AS p
                    LEFT JOIN wp_term_relationships tr ON p.ID = tr.object_id
                    LEFT JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                    LEFT JOIN wp_terms t ON t.term_id = tt.term_id
                    WHERE p.post_type='product'
                    AND p.post_status = 'publish'
                    AND tt.taxonomy = 'product_cat'
                    AND tt.term_taxonomy_id IN (SELECT * FROM cteCategory)
                    ORDER BY p.ID)
                ORDER BY t.name;
                "
            );
            wp_cache_set( $slug.'_cache_tag_list', $cache, '', 3600);
        }

        return $cache;
    }

    /**
     * Get image url
     *
     * @param int|null $cat_id (category id)
     *
     * @return string $image_url (category image  url)
     */
    public function getCategoryImgUrl(int $cat_id = null): string
    {
        $thumbnail_id = get_term_meta($cat_id, 'thumbnail_id', true);
        // get the image URL
        $image_url = wp_get_attachment_url($thumbnail_id);
        return $image_url;
    }

    /**
     * Controller & View
     *
     * Undocumented function
     *
     * @return void
     */
    public function displayAllTagsAndCat()
    {
        $o = '';
        /**
         * Return a array of objects
         *
         * @var $topCar array
         */
        $topCats = $this->getTopLevelNonEmptyCategories();
        $o .= '
        <style>
            #ct{
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-between;
            }
            #ct a:hover, #ct .ct-category a:hover{
                opacity: 0.8;
            }
            #ct .ct-category-wrap{
                padding: 15px; margin: 10px;
                background-size: cover;
                max-width: 400px;
            }
            #ct .ct-category a{
                font-size: 1.6em; padding: 0.3em 0.6em;
                display: inline-block; border-radius: 100px;
            }
            #ct .ct-category{
                padding: 10px;
                margin-top:  0px;
                margin-bottom: 10px;
                color: white;
                font-size: 1.2em;
                font-weight: 900;
            }
            #ct .ct-category a{
                color: white;
            }
            #ct .ct-ul{
                padding: 0px 0px;
                float: left
            }
            #ct .ct-li{
                display: inline-block;
                margin: 1px;
                list-style-type: none;
            }
            #ct .ct-tag-a{
                font-size: 0.9em; padding: 0px 0.7em; margin: 0.1em 0;
                background: #262a23; color: white;
                display: inline-block; border-radius: 100px;
                white-space: nowrap;
            }
        </style>
        ';
        $o .= '<div id="ct">';
        foreach ($topCats as $cat) {
            $catImgURL = $this->getCategoryImgUrl($cat->term_id);
            $o .= '<div class="ct-category-wrap">';
            $o .= "<a href='" . get_category_link($cat->term_id) . "'>"; // ~ https://rolagra.dv/product-tag/cebule/
            $o .= "<img width='100' height='100' src='$catImgURL'/>";
            $o .= "</a>";
            $o .= "<p class='ct-category'>";
            $o .= $cat->name;
            $o .= "</p>";
            $tags = $this->getAllCategoryTags($cat->term_id, $cat->name);
            $o .= "<ul class='ct-ul'>";
            foreach ($tags as $tag) {
                $o .= "<li class='ct-li'>";
                $o .= "<a class='ct-tag-a' href='" . get_tag_link($tag->term_id) . "'>"; // ~ https://rolagra.dv/product-tag/cebule/
                $o .= $tag->name;
                $o .= "</a>";
                $o .= "</li>";
            }
            $o .= "</ul>";
            $o .= '</div>';
        }
        $o .= '</div>';
        return $o;
    }
}