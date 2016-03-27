<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

if (! interface_exists( 'AbstractSitSettings' )) {

    /**
    * PLUGIN SETTINGS PAGE
    */
    interface AbstractSitSettings {
        
        /**
         * Start up
         */
        function __construct();

        /**
         * Add options page
         */
        function add_sit_menu_page();

        /*
        * Create admin menu page
        */
        function create_sit_menu_page();
       

        /**
         * Register and add settings
         */
        function page_init();

        /**
        * Sanitize option inputs
        */
        function sanitize( $input );

        /**
         * Print the Section text
         */
        function sit_info();

        /**
         * Get the settings option array and print one of its values
         */
        function sit_option_callback();
         
    }
}
