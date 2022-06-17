<?php

function custom_loginlogo_url($url)
{

    return 'http://idesigner.ir';

}

add_filter('login_headerurl', 'custom_loginlogo_url');


function amh_nj_style_load()
{
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(), '2.1.0');
    wp_enqueue_style('bootstrap.min', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '1.0');
    wp_enqueue_style('amh_nj-bootstrap.min', get_template_directory_uri() . '/css/amh_nj-bootstrap.css', array(), '1.1');
    wp_enqueue_style('swiper.min', get_template_directory_uri() . '/css/swiper.min.css', array(), '1.0');
    wp_enqueue_style('fontawesome-all', get_template_directory_uri() . '/fonts/fontawsome/all.min.css', array(), '1.0');
    wp_enqueue_style('amh_nj.min', get_template_directory_uri() . '/css/amh_nj.css', array(), '1.0');
    wp_enqueue_style('new-style', get_template_directory_uri() . '/css/style.css', array(), '1.0');
}

add_action('wp_enqueue_scripts', 'amh_nj_style_load');

//function add_menuclass_li($liclass)
//{
//    return preg_replace('/<li /', '<li class="nav-item"', $liclass);
//}
//
function add_menuclass_a($aclass)
{
    return preg_replace('/<a /', '<a class="nav-link"', $aclass);
}
//
//add_filter('wp_nav_menu', 'add_menuclass_li');
add_filter('wp_nav_menu', 'add_menuclass_a');

function amh_nj_setup_callback()
{
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
}

add_action('init', 'amh_nj_setup_callback');


//second custom menu

function wpb_custom_new_menu()
{
    register_nav_menus(
        array(
            'header_1' => __('منو اصلی 1 (هدر)'),
            'header_2' => __('منو اصلی 2 (هدر)'),
            'menu_1_footer' => __('منو اول پایین (فوتر)'),
            'menu_social' => __('شبکه های اجتماعی (فوتر)'),
        )
    );
}

add_action('init', 'wpb_custom_new_menu');

//show thumb
add_image_size('admin-list-thumb', 80, 80, false);

// add featured thumbnail to admin post columns
function wpcs_add_thumbnail_columns($columns)
{
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => 'Title',
        'featured_thumb' => 'Thumbnail',
        'author' => 'Author',
        'categories' => 'Categories',
        'tags' => 'Tags',
        'comments' => '<span class="vers"><div title="Comments" class="comment-grey-bubble"></div></span>',
        'date' => 'Date'
    );
    return $columns;
}

function wpcs_add_thumbnail_columns_data($column, $post_id)
{
    switch ($column) {
        case 'featured_thumb':
            echo '<a href="' . get_edit_post_link() . '">';
            echo the_post_thumbnail('admin-list-thumb');
            echo '</a>';
            break;
    }
}

if (function_exists('add_theme_support')) {
    add_filter('manage_posts_columns', 'wpcs_add_thumbnail_columns');
    add_action('manage_posts_custom_column', 'wpcs_add_thumbnail_columns_data', 10, 2);
    add_filter('manage_pages_columns', 'wpcs_add_thumbnail_columns');
    add_action('manage_pages_custom_column', 'wpcs_add_thumbnail_columns_data', 10, 2);
}

//views
function gt_get_post_view()
{
    $count = get_post_meta(get_the_ID(), 'post_views_count', true);
    return "$count";
}

function gt_set_post_view()
{
    $key = 'post_views_count';
    $post_id = get_the_ID();
    $count = (int)get_post_meta($post_id, $key, true);
    $count++;
    update_post_meta($post_id, $key, $count);
}

function gt_posts_column_views($columns)
{
    $columns['post_views'] = 'Views';
    return $columns;
}

function gt_posts_custom_column_views($column)
{
    if ($column === 'post_views') {
        echo gt_get_post_view();
    }
}

add_filter('manage_posts_columns', 'gt_posts_column_views');
add_action('manage_posts_custom_column', 'gt_posts_custom_column_views');


//comments
// Include better comments file from a Parent theme

require_once get_parent_theme_file_path('better-comments.php');

function wpb_move_comment_field_to_bottom($fields)
{
    $comment_field = $fields['comment'];
    unset($fields['comment']);
    $fields['comment'] = $comment_field;
    return $fields;
}

add_filter('comment_form_fields', 'wpb_move_comment_field_to_bottom');

function amh_nj_add_woocommerce_support()
{
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'amh_nj_add_woocommerce_support' );

require 'inc/amh_nj-customizer.php';

function rename_flamingo_to_inbox($translated, $original, $domain)
{

    $strings = array(
        'Flamingo' => 'Inbound Messages',
        'WooCommerce' => 'فروشگاه'
    );

    if (isset($strings[$original]) && is_admin()) {
        $translations = &get_translations_for_domain($domain);
        $translated = $translations->translate($strings[$original]);
    }

    return $translated;
}

add_filter('gettext', 'rename_flamingo_to_inbox', 10, 3);