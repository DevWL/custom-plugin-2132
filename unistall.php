<?php

/**
 * https://www.youtube.com/watch?v=FpnHvp9x48c&list=PLriKzYyLb28kR_CPMz8uierDWC2y3znI2&index=6
 */

defined('WP_UNINSTALL_PLUGIN') or die();

// clear database data

global $wpdb;

/**
 * CHECK BEFORE CHANGING TO DELETE FROM
 */
$wpdb->query("SELECT * FROM wp_posts WHERE post_type = 'book'");
$wpdb->query("SELECT * FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
$wpdb->query("SELECT * FROM wp_term_relationship WHERE object_id NOT IN (SELECT id FROM wp_posts)");