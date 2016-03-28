<?php
/*
* Plugin Name: SEO Image Tags
* Plugin URI: http://andrewmgunn.com/
* Description: Improve your site's SEO with the best solution for completely Search Engine Optimizing images and dynamically fixing HTML validation errors.
* Version: 3.0
* Author: Andrew M. Gunn
* Author URI: http://andrewmgunn.com
* Text Domain: seo-image-alt-tags
* License: GPL2
*/

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

/**
* Classes and interfaces
*/
//include_once('classes/class-sit-db.php');
include_once('classes/class-sit-settings.php');
include_once('classes/class-sit-parser.php');
include_once('classes/class-sit-scripts.php');

include_once('inc/sit-sidebar.php');
//include_once('inc/script-styles.php');


register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
register_activation_hook( __FILE__, 'sit_init' );

function sit_init() {
	
	flush_rewrite_rules();
}

/**
* Register and enqueue jQuery files to run on frontend, enqueue on admin_init
*/
add_action( 'admin_init', 'sit_enqueue_includes' );

function sit_enqueue_includes() {
	wp_register_script( 'sit_js', plugins_url('inc/sit.js', __FILE__), array('jquery'));
	wp_register_style( 'sit_css', plugins_url('inc/sit.css', __FILE__));
	wp_enqueue_script( 'sit_js' );	
	wp_enqueue_style( 'sit_css' );
}


add_filter( 'plugin_action_links', 'sit_settings_link', 10, 5 );

function sit_settings_link( $actions, $plugin_file )
{
	static $plugin;

	if (!isset($plugin))
		$plugin = plugin_basename(__FILE__);

		if ($plugin == $plugin_file) {

			$settings = array('settings' => '<a href="tools.php?page=seo-image-tags">' . __('Settings', 'General') . '</a>');

    			$actions = array_merge($settings, $actions);
		}

		return $actions;
}

/**
* Copy image title and save to Alt text field when image is uploaded. Runs anytime
* an image is uploaded, automatically.
*/
add_filter('add_attachment', 'insert_image_alt_tag', 10, 2);
//add_filter('edit_attachment', 'insert_image_alt_tag', 10, 2);

function insert_image_alt_tag($post_ID) {

	$attach = wp_get_attachment_url($post_ID);
	$title = get_the_title($post_ID);
	var_dump($attach);
	var_dump($title);
	if ( ! add_post_meta( $post_ID, '_wp_attachment_image_alt', $title, true ) ) {
	   update_post_meta ( $post_ID, '_wp_attachment_image_alt', $title );
	}
}

function name_of_my_action() {
    if ( ! empty( $_POST ) && check_admin_referer( 'name_of_my_action', 'do_this' ) ) {
    	echo 'khk';
    }
   // process form data
}
function sample_admin_notice__error() {
	$class = 'notice notice-error';
	$message = __( 'Irks! An error has occurred.', 'sample-text-domain' );

	printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
}

