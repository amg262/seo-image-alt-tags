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
		    wp_register_script( 'sit_js', '/wp-content/plugins/seo-image-alt-tags/inc/sit.js', array('jquery'));
			wp_enqueue_script( 'sit_js' );
		}

		public function enqueue_sit_scripts() {

			$index = 0;

			foreach ( $this->set_options as $option ) {


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
							add_action( 'wp_footer', array( $this, 'sit_image_scripts' ) );
							add_action( 'wp_footer', array( $this, 'sit_anchor_scripts' ) );
						} else {
							remove_action( 'wp_enqueue_scripts', array( $this, 'sit_image_scripts' ) );
							remove_action( 'wp_enqueue_scripts', array( $this, 'sit_anchor_scripts' ) );
						}

						break;

					default:

						add_action( 'wp_footer', array( $this, 'sit_image_scripts' ),5 );
						add_action( 'wp_footer', array( $this, 'sit_anchor_scripts' ),5 );


				}
				
				

			}
		}

		/**
		* Enqueue scripts
		*/
		public function sit_image_scripts() { ?>

		<?php//$var = get_option('wc_bom_option'); ?>
		<script type="text/javascript" src="/wp-content/plugins/seo-image-alt-tags/inc/sit.js"></script>
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

							var alt = getImageFilename( $(this).attr('src') );

							if ( alt !== null ) {
								$(this).attr('alt', alt); //FALSE AS OF 2015
							} else {
								console.log('didnt fine one');
								$(this).attr('alt', 'error'); //FALSE AS OF 2015
							}
						}

					count++;

					}); // .each
				});
		<?php }


		
		public function sit_anchor_scripts() { ?>
		<script type="text/javascript" src="/wp-content/plugins/seo-image-alt-tags/inc/sit.js"></script>

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

				function getHostName(url) {
		    var match = url.match(/:\/\/(www[0-9]?\.)?(.[^/:]+)/i);
		    if (match != null && match.length > 2 && typeof match[2] === 'string' && match[2].length > 0) {
		    	var hostName = match[2];
		    	return hostName;
		    }
		    else {
		        return null;
		    }
		}
		function getDomain(hostName) {
		   
		    var domain = hostName;
		    
		    if (hostName != null) {
		        var parts = hostName.split('.').reverse();
		        
		        if (parts != null && parts.length > 1) {
		            domain = parts[1] + '.' + parts[0];
		                
		            if (hostName.toLowerCase().indexOf('.co.uk') != -1 && parts.length > 2) {
		              domain = parts[2] + '.' + domain;
		            }
		        }
		    }
		    
		    return domain;
		}

		function getDomainName(domain) {

			if ( domain !== null ) {
				var str = domain.split( '.' );
				var domainName = str[0];

				return domainName;

			} else {

				return null;
			}

		}

		function isExternal(url) {
		    var match = url.match(/^([^:\/?#]+:)?(?:\/\/([^\/?#]*))?([^?#]+)?(\?[^#]*)?(#.*)?/);
		    if (match != null && typeof match[1] === 'string' &&
		        match[1].length > 0 && match[1].toLowerCase() !== location.protocol)
		        return true;

		    if (match != null && typeof match[2] === 'string' &&
		        match[2].length > 0 &&
		        match[2].replace(new RegExp(':('+{'http:':80,'https:':443}[location.protocol]+')?$'),'')
		           !== location.host) {
		        return true;
		    }
		    else {
		        return false;
		    }
		}

		function isPdf(url) {
			var match = url;

			if ( match.indexOf(".pdf") >= 0) {
				return true;
				
			} else {
				return false;
			}
		}

		function isAdditonal() {

		}

		function getImageFilename(url) {
			
			if ( url !== null ) {
				
				var index = url.lastIndexOf("/") + 1;
				var filename = url.substr(index);

				//if ( filename !== null ) {
				//	return filename;

				//} else {

					var src = url; // "static/images/banner/blue.jpg"
					var tarr = src.split('/');      // ["static","images","banner","blue.jpg"]
					var file = tarr[tarr.length-1]; // "blue.jpg"
					var data = file.split('.')[0];

					if ( data !== null ) {
						
						return data;

					} else if ( file !== null ) {
						return file;

					} else {
						var num = Math.floor(Math.random() * 1001);
						var numStr = num.toString();
						var host = getHostName(url);
						var domain = getDomain(host);
						var name = getDomainName(domain);
						var str = name + "-" + numStr;

						console.log( 'No filename for ' + url );
						return str;
					}

				//}

			} else {
				return null;
			}
		}

				</script>
		<?php }
	}

}

$see = new FrontendScripts();
$see->enqueue_sit_scripts();