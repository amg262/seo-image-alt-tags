<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

//include_once( 'sit.js' );
/**
* Script styles to run jQuery on pages
*/
add_action( 'wp_enqueue_scripts', 'sit_setup' );

function sit_setup() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-ui-core' );
}

/**
* Enqueue scripts
*/
add_action('wp_footer','sit_scripts',5);

function sit_scripts() { ?>

<?php global $sit_settings; $sit_settings = (array)get_option('sit_settings'); $key = 'disable_clientside_script'; $off = $sit_settings[$key]; echo 'off'.$off; var_dump($sit_settings[$key]);//$var = get_option('wc_bom_option'); ?>

	<?php if ($sit_settings[$key] !== '1') { ?>

    <script type="text/javascript">
        
        //jQuery(document).ready(function($) {
        jQuery(document).ready(function($){

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
			var count = 0;
			var pathname = window.location.pathname; // Returns path only
			var url = window.location.href; 
			var pdf;
			var host = getHostName( url );
			var domain = getDomain( host );
			var name = getDomainName( domain );

			$("a").each(function() {
				//set url to href value if href doesnt contains
				//base site in it, will return -1

				if ( ( $(this).attr('href') != '#' ) && ( $(this).attr('href') != null ) ) {
					<?php $key = 'enable_seo_links'; $off = $sit_settings[$key];

					if ( $off != null) { ?>

						var external = isExternal( $(this).attr('href') );

						<?php $key2 = 'enable_pdf_ext'; $ext = $sit_settings[$key2];
						//echo $ext;//var_dump($ext);
						//var_dump($pdf);
						//if ($off !== '1') { ?>
							<?php if ($ext != null) { ?>
								pdf = isPdf( $(this).attr('href') );
							<?php } else { ?>
								pdf = false;
							<?php } ?>
						
						console.log(<?php $ext; ?>)
						console.log(pdf);
						<?php //} ?>
						if ( (external == true) || (pdf == true)) {
							$(this).attr('target', '_blank');
							count++;
						}

						<?php } ?>
					}


			}); //each

			return count;


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
			

		

		});

    </script>

<?php }
}
