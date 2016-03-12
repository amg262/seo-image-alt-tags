<?php
/**
 * 
*/
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

/**
* 
*/
interface i_SitParser {
    
}

/**
* 
*/
//class sit_DB implements i_sit_DB {
class SitParser {
    /**
     * Holds the values to be used in the fields callbacks
     */
    public $sit_settings;
        
    /**
    * 
    */
    public function __construct() {
        
    }

    public function build_media_library_images() {
    	if (is_admin() && is_user_logged_in()):
    	$args = array(
	        'post_type' => 'attachment',
	        'post_mime_type' =>'image',
	        //'post_status' => 'inherit',
	        'posts_per_page' => -1,
	        'orderby' => 'date'
	    );
	    $query_images = new WP_Query( $args );
	    $images = array();
	    foreach ( $query_images->posts as $image) {
	        $images[]= $image->guid;
	    }
	    var_dump($images);
	    return $images;
	    endif;
	}

	public function insert_image_alt_tag($post_ID) {
		$title = get_the_title($post_ID);

		if ( ! add_post_meta( $post_ID, '_wp_attachment_image_alt', $title, true ) ) {
		   update_post_meta ( $post_ID, '_wp_attachment_image_alt', $title );
		}
	}

	/**
	* Getting all posts that are attachments (images included) and adds the the
	* alt text meta data to the image based on the title of the post
	*/
	public function update_tags($is_update) {

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

	/**
	* Getting all posts that are attachments (images included) and adds the the
	* alt text meta data to the image based on the title of the post
	*/
	public function delete_tags($is_update) {

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

					//if has post meta for alt tag, update it else add it.
					if (! empty($tag) ) {
						delete_post_meta($post->ID, '_wp_attachment_image_alt', $title);
						$deleted++; //update counter

					} //end add_post_meta
					
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




    


}

$sit_parser_be = new sitParserBackend();
$sit_parser_be->build_media_library_images();

