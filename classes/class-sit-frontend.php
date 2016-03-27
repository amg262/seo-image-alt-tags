<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );


if ( ! class_exists( 'FrontendScripts' )) {

	class FrontendScripts {
		/**
		* Script styles to run jQuery on pages
		*/
		public $sit_settings;
		public $enabled;
		public $is_seo_links;
		public $is_internal_pdf;
		public $is_clientside;
		public $seo_links_on;
		public $pdf_on;
		public $set_options = array();

		public function __construct() {

			$this->sit_settings = (array) get_option( 'sit_settings' );
			$this->is_clientside = 'disable_clientside_script';
			$this->is_seo_links = 'enable_seo_links';
			$this->is_internal_pdf = 'enable_internal_pdf';

			$this->set_options = array(
									'enable_seo_links' => $sit_settings[$enable_seo_links],
									'enable_internal_pdf' => $sit_settings[$enable_internal_pdf],
									'disable_clientside_script' => $sit_settings[$is_clientside],
								);

			add_action( 'wp_enqueue_scripts', array( $this, 'sit_jquery_scripts' ) );
	
		}

		
		public function sit_jquery_scripts() {
		    wp_enqueue_script( 'jquery' );
		    wp_enqueue_script( 'jquery-ui-core' );
		    wp_register_script( 'sit_js', plugins_url('../inc/sit.js', __FILE__), array('jquery'));
			wp_enqueue_script( 'sit_js' );
		}

		public function enqueue_sit_scripts() {

			var $index = 0;

			foreach ( $set_options as $option ) {


				switch ( $index ) {
					case ( $index == 0 ):

						if ( $option[$index] !== null ) {
							$this->seo_links_on = True;
							
						} else {
							$this->seo_links_on = False;
						}

						break;

					case ( $index == 1 ):
						if ( $option[$index] !== null ) {
							$this->pdf_on = True;
							
						} else {
							$this->pdf_on = False;
						}
						
						break;

					case ( $index == 2 ):

						if ( $option[$index] == null ) {
							add_action( 'wp_enqueue_scripts', array( $this, 'sit_image_scripts' ) );
							add_action( 'wp_enqueue_scripts', array( $this, 'sit_anchor_scripts' ) );
						} else {
							remove_action( 'wp_enqueue_scripts', array( $this, 'sit_image_scripts' ) );
							remove_action( 'wp_enqueue_scripts', array( $this, 'sit_anchor_scripts' ) );
						}

						break;

					default:

						add_action( 'wp_enqueue_scripts', array( $this, 'sit_image_scripts' ) );
						add_action( 'wp_enqueue_scripts', array( $this, 'sit_anchor_scripts' ) );
						break;


				}
				
				

			}
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

			<script type="text/javascript">

		        //jQuery(document).ready(function($) {
		        jQuery(document).ready(function($){
					var count = 0;
					var pathname = window.location.pathname; // Returns path only
					var url = window.location.href; 

					var pdf;
					var ext;
					var host = getHostName( url );
					var domain = getDomain( host );
					var name = getDomainName( domain );
					var is_pdf_on = <?php echo $pdf_on; ?>
					var is_links_on = <?php echo $seo_links_on; ?>

					count = 0;
					$("a").each(function() {
						//set url to href value if href doesnt contains
						//base site in it, will return -1

						if ( ( $(this).attr('href') !== '#' ) && ( $(this).attr('href') !== null ) ) {

							
							if ( isExternal( $(this).attr('href') ) || (isPdf( $(this).attr('href') ) ) ) {

								if ( is_links_on != null ) {

									$(this).attr('target', '_blank');
									count++;
									console.log(count);
						
								}

								if ( is_pdf_on != null ) {
										
									$(this).attr('target', '_blank');
									count++;
									console.log(count);
								}
							}
							
							
						} //undefined

					}); //each

					return count;

				});
				</script>
		<?php }
	}

}
if (is_admin()) {
	$see = new FrontendScripts();
}