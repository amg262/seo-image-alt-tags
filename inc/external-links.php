<?php
/**
* Script Styles file that does PHP / JavaScript file combination logic
*/
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

/**
* Script styles to run jQuery on pages
*/
add_action( 'wp_enqueue_scripts', 'seo_external_links_setup_scripts' );

function seo_external_links_setup_scripts() {
	wp_enqueue_script( 'jquery' );
	//wp_enqueue_script( 'jquery-ui-core' );
}

/**
* Enqueue scripts
*/
add_action('wp_footer','seo_external_links_footer_scripts', 10);

function seo_external_links_footer_scripts() { ?>

<?php

$server = $_SERVER['SERVER_NAME'];

?>

	<script type="text/javascript">

		jQuery(document).ready(function($){
			//counter and constants
			var count = 0;
			var blank = "_blank";
			var base = "<?php echo $server; ?>";

			$('a[href$=".pdf"]').each


			//looping through each anchor tag
			$("a").each(function() {
				//set url to href value if href doesnt contains
				//base site in it, will return -1

				if (($(this).attr('href') !== '#')
						 && ($(this).attr('href') !== undefined)
						 && ($(this).attr('href') !== null)) {

					var url = $(this).attr('href');
					var i = url.indexOf(base);

					if (i === -1) {

						//Set all targets to blank
						if (($(this).attr('target') !== '_blank')) {
							$(this).attr('target', blank);
							count++;
						} //target

					} else {
						//Handles internal PDFS to open in new tab
						$('a[href$=".pdf"]').prop('target', '_blank');
					} //i

				} //undefined

			}); //each

	  	}); //ready

	</script>

<?php }