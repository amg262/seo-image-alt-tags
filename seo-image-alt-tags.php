<?php

/*

* Plugin Name: SEO Image Toolbox

* Plugin URI: http://andrewgunn.org

* Description: SEO Image Tags puts an end to ever have to worry about getting HTML validation errors for images
  and improves your SEO score by completely optimizing image data. THIS WILL SAVE YOU HOURS, DAYS, 0R WEEKS.
  Alt tags are dynamically generated
  and saved to the database automatically any time an image is uploaded, no configuration or headache.

* Version: 3.2.6

* Author: Andrew Gunn

* Author URI: http://andrewgunn.org

* Text Domain: seo-image-alt-tags

* License: GPL2

*

*/

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );


/**
 * Classes and interfaces
 */

include_once __DIR__ . '/classes/class-sit-settings.php';

include_once __DIR__ . '/classes/class-sit-scripts.php';


add_filter( 'plugin_action_links', 'sit_settings_link', 10, 5 );


/**
 * @param $actions
 * @param $plugin_file
 *
 * @return array|void
 */
function sit_settings_link( $actions, $plugin_file ) {

	static $plugin;


	if ( ! isset( $plugin ) ) {
		$plugin = plugin_basename( __FILE__ );
	}


	if ( $plugin == $plugin_file ) {


		$settings = [
			'settings' => '<a href="tools.php?page=seo-image-tags">' . __( 'Settings', 'General' ) . '</a>',
		];


		$actions = array_merge( $settings, $actions );

	}


	return $actions;

}


/**
 * Copy image title and save to Alt text field when image is uploaded. Runs anytime
 * an image is uploaded, automatically.
 */

add_filter( 'add_attachment', 'insert_image_alt_tag', 10, 2 );

//add_filter('edit_attachment', 'insert_image_alt_tag', 10, 2);


/**
 * @param $post_ID
 */
function insert_image_alt_tag( $post_ID ) {


	$sit_settings = get_option( 'sit_settings' );


	$attach = wp_get_attachment_url( $post_ID );

	$title = sanitize_text_field( get_the_title( $post_ID ) );


	if ( ! add_post_meta( $post_ID, '_wp_attachment_image_alt', $title, true ) ) {

		update_post_meta( $post_ID, '_wp_attachment_image_alt', $title );

	}


}


/**
 * @param $is_update
 *
 * @return array
 */
function batch_update_image_tags( $is_update ) {


	$total = 0;

	$created = 0;

	$updated = 0;

	$deleted = 0;


	$args = [

		'post_type' => 'attachment',

		'numberposts' => - 1,

		'post_status' => null,

		'post_parent' => null, // any parent

	];


	//Get all attachment posts

	$attachments = get_posts( $args );


	//if there are posts

	if ( $attachments ) {


		$sit_settings = get_option( 'sit_settings' );


		if ( $sit_settings['enable_pdf'] ) {

			$pdf = true;

			$pdf_mine = 'pdf';

		}


		$image_mime = 'image';


		//Loop thru each attachment

		foreach ( $attachments as $post ) {


			//get post data ready,set title var to post title

			setup_postdata( $post );

			$title = sanitize_text_field( get_the_title( $post->ID ) );

			$type = get_post_mime_type( $post->ID );

			$tag = sanitize_text_field( get_post_meta( $post->ID, '_wp_attachment_image_alt', true ) );

			$tag_str = (string) $tag;

			$tag_len = strlen( $tag_str );

			//echo $type;

			if ( strpos( $type, $image_mime ) !== false ) {


				if ( $is_update == true ) {

					//if has post meta for alt tag, update it else add it.

					if ( ! add_post_meta( $post->ID, '_wp_attachment_image_alt', $title, true ) ) {


						if ( $tag_str !== $title ) {


							update_post_meta( $post->ID, '_wp_attachment_image_alt', $title );

							$updated ++;

						}

					} else {

						$created ++; //update counter

					}


				} else {


					//if has post meta for alt tag, update it else add it.

					if ( ! empty( $tag ) ) {

						delete_post_meta( $post->ID, '_wp_attachment_image_alt', $title );

						$deleted ++; //update counter

					} //end add_post_meta

				}


				$total ++;


			}


		} //end foreach


	} //end attachments


	$count = [

		'total' => $total,

		'created' => $created,

		'updated' => $updated,

		'deleted' => $deleted,

	];


	wp_reset_postdata();

	//count of files updated

	return $count;

}

