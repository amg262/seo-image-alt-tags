<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

//include_once( '/sit.js' );
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

<?php global $sit_settings;
$sit_settings = (array) get_option('sit_settings');
$key = 'disable_clientside_script';
 //var_dump($sit_settings[$key]);//$var = get_option('wc_bom_option'); ?>

	<?php if (is_null($sit_settings[$key])) ://$ke//if (is_null($sit_settings[$key])) { echo 'is_null';?>
		<script type="text/javascript" src="/dev/wp-content/plugins/seo-image-alt-tags/inc/sit.js"></script>
    <script type="text/javascript">
        
        //jQuery(document).ready(function($) {
        jQuery(document).ready(function($){
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
					var url =  $(this).attr('href');

					<?php $key2 = 'enable_pdf_ext'; 
					if (!(is_null($sit_settings[$key2]))): ?>

						if (isPdf(url)) {
							$(this).attr('target', '_blank');
						}
					<?php endif;
					$key3 = 'enable_seo_links'; 

					if (!(is_null($sit_settings[$key3]))): ?>

						if (isExternal(url)) {
							$(this).attr('target', '_blank');
						}
						//console.log('1');
					<?php endif; ?>	

					<?php $key5 = 'enable_ext';

					if (!(is_null($sit_settings[$key5]))) :
						$exts = $sit_settings[$key5]; ?>
						var final = "<?php echo $exts; ?>";
						if (isExtension(url, final)) {
							//console.log('3');
							$(this).attr('target', '_blank');
						}
						//console.log(<?php echo $exts; ?>);
						//var_dump($exts);
						<?php endif; ?>
					
					
				}
					


			}); //each

			//return count;
			<?php $key4 = 'disable_img_tags';

			if ((is_null($sit_settings[$key4]))) : ?>

			$("img").each(function() {

				if ( ($(this).attr('alt') == null) || ($(this).attr('alt') == "" ) ) {
					//console.log('2');
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

			<?php endif; ?>

			if ($.browser.chrome) {
				//autcomplete_false();
				$("input").each(function() {
			    	//alert("ello");
			    	$(this).attr('autocomplete', 'false'); //FALSE AS OF 2015
			    }); // .each

			    $("form").each(function() {
			    	//alert("ello");
			    	$(this).attr('autocomplete', 'false'); //FALSE AS OF 2015
			    }); // .each

			} else {
				//autcomplete_off();
				$("input").each(function() {
			    	//alert("ello");
			    	$(this).attr('autocomplete', 'off');
			    }); // .each

			    $("form").each(function() {
			    	//alert("ello");
			    	$(this).attr('autocomplete', 'off');
			    }); // .each

			} // end if

			jQuery(document).bind('gform_post_render', function(){

			if ($.browser.chrome) {
				//autcomplete_false();
				$("input").each(function() {
			    	//alert("ello");
			    	$(this).attr('autocomplete', 'false'); //FALSE AS OF 2015
			    }); // .each

			    $("form").each(function() {
			    	//alert("ello");
			    	$(this).attr('autocomplete', 'false'); //FALSE AS OF 2015
			    }); // .each

			} else {
				//autcomplete_off();
				$("input").each(function() {
			    	//alert("ello");
			    	$(this).attr('autocomplete', 'off');
			    }); // .each

			    $("form").each(function() {
			    	//alert("ello");
			    	$(this).attr('autocomplete', 'off');
			    }); // .each
			} // end if
		});
        	
			

			});

	    </script>

<?php endif;
}
