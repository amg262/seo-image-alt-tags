<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

include_once( 'sit.js' );

class ClientTagScripts {
	/**
	* Script styles to run jQuery on pages
	*/
	public $sit_settings;
	
	public function __construct() {
		$this->sit_settings = (array) get_option( 'sit_settings' );
		add_action( 'wp_enqueue_scripts', array( $this, 'sit_setup' ) );
		add_action(' wp_footer', 'sit_clientside_scripts', 5 );
	}

	public function sit_jquery_scripts() {
	    wp_enqueue_script( 'jquery' );
	    wp_enqueue_script( 'jquery-ui-core' );
	}

	/**
	* Enqueue scripts
	*/
	public function sit_image_scripts() { ?>

	<?php//$var = get_option('wc_bom_option'); ?>

	    <script type="text/javascript">
	        
	        //jQuery(document).ready(function($) {
	        jQuery(document).ready(function($){
				var count = 0;
				var pathname = window.location.pathname; // Returns path only
				var url = window.location.href; 

				var host = getHostName( url );
				var domain = getDomain( host );
				var name = getDomainName( domain );

				$("img").each(function() {

					if ( ($(this).attr('alt') == null) || ($(this).attr('alt') == "" ) ) {

						var alt = getImageFilename( $(this).attr('src') )

						if ( alt !== null ) {
							$(this).attr('alt', alt); //FALSE AS OF 2015
						} else {
							console.log('didnt fine one');
							$(this).attr('alt', 'error'); //FALSE AS OF 2015
						}
					}

				count++;

				}); // .each

	<?php }
	}

	/**
	* Enqueue scripts
	*/
	public function sit_anchor_scripts() { ?>

	<?php//$var = get_option('wc_bom_option'); ?>

	    <script type="text/javascript">
	        
	        //jQuery(document).ready(function($) {
	        jQuery(document).ready(function($){
				var count = 0;
				var pathname = window.location.pathname; // Returns path only
				var url = window.location.href; 

				var host = getHostName( url );
				var domain = getDomain( host );
				var name = getDomainName( domain );

				count = 0;
				$("a").each(function() {
					//set url to href value if href doesnt contains
					//base site in it, will return -1

					if ( ( $(this).attr('href') !== '#' ) && ( $(this).attr('href') !== null ) ) {

						var external = isExternal( $(this).attr('href') );
						var pdf = isPdf( $(this).attr('href') );

						if ( ( pdf == true ) ) {
							$(this).attr('target', '_blank');
							count++;
							console.log(count);
						}
						//if (($(this).attr('target') !== '_blank')) {
						//	$(this).attr('target', '_blank');
						//	count++;
						//} //target
					} //undefined

				}); //each

				return count;

			});


	<?php }
}
