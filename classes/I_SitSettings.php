<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 8/1/16
 * Time: 10:19 PM
 */

/**
 * PLUGIN SETTINGS PAGE
 */
interface I_SitSettings
{
    /**
     * Add options page
     */
    public function add_sit_menu_page();

    public function create_sit_menu_page();

    /**
     * Register and add settings
     */
    public function page_init();

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize($input);

    public function sit_info();

    /**
     * Get the settings option array and print one of its values
     */
    public function sit_option_callback();
}