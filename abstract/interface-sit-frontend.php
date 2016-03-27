<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

if (! interface_exists( 'AbstractFrontendScripts' ) ) {

	interface AbstractFrontendScripts {
		/**
		* Script styles to run jQuery on pages
		*/
		
		function __construct();

		function enqueue_sit_scripts();

		/**
		* Enqueues need jquery scripts
		*/
		function sit_jquery_scripts();

		/**
		* Runs image tag scripts
		*/
		function sit_image_scripts();

		/**
		* Runs anchor tag scripts
		*/
		function sit_anchor_scripts();
	}
}