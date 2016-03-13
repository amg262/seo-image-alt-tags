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
include_once('classes/class-sit-db.php');
include_once('classes/class-sit-settings.php');
include_once('classes/class-sit-parser.php');
include_once('inc/sit-sidebar.php');
include_once('inc/sit-widget.php');
include_once('inc/script-styles.php');
include_once('inc/external-links.php');
include_once('inc/script-styles.php');
include_once('inc/script-styles.php');

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
register_activation_hook( __FILE__, 'sit_init' );

function sit_init() {
	
	flush_rewrite_rules();
}

/**
* Register and enqueue jQuery files to run on frontend, enqueue on admin_init
*/
add_action( 'wp_enqueue_scripts', 'sit_enqueue_includes' );

function sit_enqueue_includes() {
	wp_register_script( 'sit_js', plugins_url('inc/sit.js', __FILE__), array('jquery'));
	wp_enqueue_script( 'sit_js' );
}
/**
* Register and enqueue jQuery files to run on frontend, enqueue on admin_init
*/
add_action( 'admin_init', 'sit_enqueue_includes' );

function sit_enqueue_includes() {
	wp_register_style( 'sit_css', plugins_url('inc/sit.css', __FILE__));
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
add_filter('edit_attachment', 'insert_image_alt_tag', 10, 2);

function insert_image_alt_tag($post_ID) {
	$title = get_the_title($post_ID);

	if ( ! add_post_meta( $post_ID, '_wp_attachment_image_alt', $title, true ) ) {
	   update_post_meta ( $post_ID, '_wp_attachment_image_alt', $title );
	}
}

/**
* Getting all posts that are attachments (images included) and adds the the
* alt text meta data to the image based on the title of the post
*/
function batch_update_image_tags($is_update) {

	$total = 0;
	$created = 0;
	$updated = 0;
	$deleted = 0;

	$args = array(
    'post_type' => 'attachment',
    'numberposts' => -1,
    'post_status' => null,
    'post_parent' => null, // any parent
    );

	//Get all attachment posts
	$attachments = get_posts($args);

	//if there are posts
	if ($attachments) {
		$image_mime = 'image';

		//Loop thru each attachment
		foreach ($attachments as $post) {

			//get post data ready,set title var to post title
	        setup_postdata($post);
	        $title = get_the_title($post->ID);
			$type = get_post_mime_type($post->ID);
			$tag = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
			$tag_str = strval($tag);
			$tag_len = strlen($tag_str);
			//echo $type;
			if (strpos($type, $image_mime) !== false) {

				if ( $is_update == True ) {
					//if has post meta for alt tag, update it else add it.
					if (! add_post_meta( $post->ID, '_wp_attachment_image_alt', $title, true )) {

						if ((empty($tag) || (($tag_len <= 2 ) && ($tag_str !== $title)))) {

							update_post_meta ( $post->ID, '_wp_attachment_image_alt', $title );
							$updated++;
						}
					} else {
						$created++; //update counter
					}

				} else {
					//if has post meta for alt tag, update it else add it.
					if (! empty($tag) ) {
						delete_post_meta($post->ID, '_wp_attachment_image_alt', $title);
						$deleted++; //update counter
					} //end add_post_meta
				}
				$total++;
			} //end of image_mime

	    } //end foreach

	} //end attachments

	$count = array(
		'total' => $total,
		'created' => $created,
		'updated' => $updated,
		'deleted' => $deleted
		);

	//count of files updated
	return $count;
}
