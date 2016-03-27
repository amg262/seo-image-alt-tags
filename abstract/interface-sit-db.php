<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

if (! interface_exists( 'AbstractSitDatabase' )) {

    /**
    * PLUGIN SETTINGS PAGE
    */
    interface AbstractSitDatabase {
        
        /**
         * Start up
         */
        function __construct();

        /**
        * Installing main table to store info
        */
        function install_sit_tbl();

        /**
        * Installing meta table to link
        */
        function install_sit_meta_tbl();
        
        /**
        * Adds row to created db table
        */
        function create_sit_db_record();
         
    }
}
