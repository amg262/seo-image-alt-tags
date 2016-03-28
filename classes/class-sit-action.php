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



    


}

$sit_parser_be = new sitParserBackend();
$sit_parser_be->build_media_library_images();

