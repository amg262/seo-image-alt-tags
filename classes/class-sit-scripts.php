<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );


/**
 * Class ScriptHandler
 */
class ScriptHandler {
	/**
	 * Enqueue scripts
	 */


	public function __construct() {
		add_action( 'wp_footer', [ $this, 'sit_scripts' ], 5 );
	}

	/**
	 *
	 */
	public function sit_scripts() { ?>
		<?php

		global $sit_settings;
		$sit_settings = (array) get_option( 'sit_settings' );
		$key          = 'disable_clientside_script';
		$name         = $_SERVER['SERVER_NAME'];
		//var_dump($name);
		//var_dump($sit_settings[$key]);//$var = get_option('wc_bom_option'); ?>

		<?php if ( $sit_settings[ $key ] === null ) ://$ke//if (is_null($sit_settings[$key])) { echo 'is_null'; ?>
            <script type="text/javascript">

                //jQuery(document).ready(function($) {
                jQuery(document).ready(function ($) {
                    var host4;
                    var host3;
                    var host2;
                    var count = 0;
                    var pathname = window.location.pathname; // Returns path only
                    var url = window.location.href;
                    var pdf;
                    var href;
                    var host = window.location.host;
                    var site;
                    var is_hash;
                    //console.log(host);
                    host2 = host.replace('http://', '');

                    host3 = host2.replace('www.', '');
                    host4 = host3.split('.');
                    //console.log(host2);
                    //console.log(host3);
                    //console.log(host4);
                    site = host4[0];
                    //console.log(site);

                    $("a").each(function () {

                        if ($(this).attr('href') != '#' || ($(this).attr('href') != '')) {

                            href = $(this).attr('href');

							<?php $key2 = 'enable_pdf_ext';

							if ( $sit_settings[ $key2 ] !== null): ?>

                            var pos = href.indexOf('.pdf');
                            //console.log(pos);
                            if (pos !== -1) {
                                $(this).attr('target', '_blank');
                            }


							<?php endif;

							$key3 = 'enable_seo_links';

							if ( $sit_settings[ $key3 ] !== null ): ?>

                            //var host = window.location.host;
                            var pos = href.indexOf(site);
                            //console.log(host);
                            if (pos === -1) {
                                $(this).attr('target', '_blank');
                                // console.log(this);
                            }

							<?php endif; ?>
                        }

                    }); //each


					<?php $key4 = 'dab_af';

					if ( $sit_settings[ $key4 ] !== null ) : ?>
                    if ($.browser.chrome) {
                        //autcomplete_false();

                        $("input").each(function () {

                            $(this).attr('autocomplete', 'false'); //FALSE AS OF 2015

                        }); // .each

                        $("form").each(function () {

                            $(this).attr('autocomplete', 'false'); //FALSE AS OF 2015

                        }); // .each

                    } else {

                        $("input").each(function () {

                            $(this).attr('autocomplete', 'off');


                        }); // .each

                        $("form").each(function () {

                            $(this).attr('autocomplete', 'off');

                        }); // .each

                    } // end if
					<?php endif; ?>

                })
                ;

            </script>

		<?php endif;
	}
}

$ss = new ScriptHandler();