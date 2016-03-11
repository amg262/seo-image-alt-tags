<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

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

<?php//$var = get_option('wc_bom_option'); ?>

    <script type="text/javascript">
        
        jQuery(document).ready(function($) {
            

        }); 
    </script>

<?php }

/**
* Enqueue styles
*/
add_action('init','sit_styles',10);

function sit_styles() { ?>
<style type="text/css">


</style>
<?php }