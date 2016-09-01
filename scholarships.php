<?php

/*
 *
 * Plugin Name: Common - Scholarships CPT
 * Description: Scholarships Custom Post Type plugin, for use on applicable CAH sites.
 * Author: Austin Tindle
 *
 */

// Scholarships

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

/* General ------------------------------*/

// Load custom CSS
function scholarship_load_plugin_css() {
    wp_enqueue_style( 'scholarship-plugin-style', plugin_dir_url(__FILE__) . 'css/style.css');
}
add_action( 'admin_enqueue_scripts', 'scholarship_load_plugin_css' );


/* Post Type ------------------------------*/

add_action("admin_init", "scholarship_init");
add_action('save_post', 'save_scholarship');
add_action('init', 'create_scholarship_type');

function create_scholarship_type() {
    $args = array(
          'label' => 'Scholarships',
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('slug' => 'scholarship'),
            'query_var' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'categories',
                'excerpt'),
            'menu_icon' => 'dashicons-awards',
        );
 

    register_post_type( 'scholarship' , $args );
}

function scholarship_init() {
    add_meta_box("scholarship_meta_options", "Options", "scholarship_meta_options", "scholarship", "normal", "high");
}

function scholarship_meta_options() {
    global $post;
    $custom = get_post_custom($post->ID);
    $deadline = $custom["deadline"][0];
    $external_url = $custom["external_url"][0];

    require_once('views/options.php');
}

function save_scholarship() {
    global $post;
    update_post_meta($post->ID, "deadline", $_POST["deadline"]);
    update_post_meta($post->ID, "external_url", $_POST["external_url"]);
}

?>
