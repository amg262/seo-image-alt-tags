<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

if (! interface_exists( 'AbstractSitUninstaller' )) {

    /**
    * PLUGIN SETTINGS PAGE
    */
    interface AbstractSitUninstaller {
        
        /**
         * Start up
         */
        function __construct();

        /**
         * Add options page
         */
        function delete_sit_options();

        /*
        * Create admin menu page
        */
        function delete_sit_network_options();
       

        /**
         * Register and add settings
         */
        function delete_sit_db();
         
    }
}
