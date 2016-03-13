<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

interface i_SitSettings {
    
}
/**
* PLUGIN SETTINGS PAGE
*/
class SitSettings {
    /**
     * Holds the values to be used in the fields callbacks
     */
    public $sit_settings;
    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_sit_menu_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }
    /**
     * Add options page
     */
    public function add_sit_menu_page() {
      
       add_submenu_page(
            'tools.php',
            'SEO Image Tags',
            'SEO Image Tags',
            'manage_options',
            'seo-image-tags',
            array( $this, 'create_sit_menu_page' )//,
        );
    }

    public function create_sit_menu_page() {
        // Set class property
        $this->sit_settings = get_option( 'sit_settings' );
        ?>
        <div class="sit-wrap wrap">
            <div>
            <h1>SEO Image Tags</h1>
            <form method="post" action="options.php">

            <?php
                // This prints out all hidden setting fields
                settings_fields( 'sit_settings_group' );
                do_settings_sections( 'sit-options-admin' );
                submit_button('Save All Options');
            ?>
            </form>
        </div>
            <?php //echo gtm_get_sidebar(); ?>
        </div>
        <?php
    }


    /**
     * Register and add settings
     */
    public function page_init() {
        //global $geo_mashup_options;
        register_setting(
            'sit_settings_group', // Option group
            'sit_settings', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'sit_settings_section', // ID
            '', // Title
            array( $this, '' ), // Callback
            'sit-options-admin' // Page
        );

        add_settings_section(
            'sit_option', // ID
            '', // Title
            array( $this, 'sit_option_callback' ), // Callback
            'sit-options-admin', // Page
            'sit_settings_section' // Section
        );
    
    }
    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input ) {
        //$new_input = array();
        /*if( isset( $input['sit_option'] ) )
            $new_input['sit_option'] = absint( $input['sit_option'] );
        if( isset( $input['trail_story_setting'] ) )
            $new_input['trail_story_setting'] = absint( $input['trail_story_setting'] );
        */
        return $input;
    }
    /**
     * Print the Section text
     */

    /**
     * Get the settings option array and print one of its values
     */
    public function sit_option_callback() {
        //Get plugin options
        
        global $sit_settings;
        // Enqueue Media Library Use
        wp_enqueue_media();
        
        // Get trail story options
        $sit_settings = (array) get_option( 'sit_settings' ); ?>
        
            <div id="sit-settings" class="sit-settings plugin-info header">
                <h3><strong>SEO Image Tag Settings/strong></h3>
                <hr>

                <table class="form-table">
                    <tbody>
                        <tr>
                            <?php //$key = 'delete_data'; ?>
                            <th scope="row">
                                Disable clientside script?
                            </th>
                            <td>
       
                                <fieldset><?php $key = 'disable_clientside_script'; ?>
                                

                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turns offs script that dynamically adds alt attribute to img tags
                                    </label>
                                
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                Disable automatic alt tags on upload?
                            </th>
                            <td>
                                <fieldset><?php $key = 'disable_autotag_upload'; ?>
                                    
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="<?php echo $sit_settings[$key]; ?>" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turns off action copies the image title to the alt field and saves meta data. 
                                    </label>

                                </fieldset>
                                
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                Disable automatic alt tags on edit?
                            </th>
                            <td>
                                <fieldset><?php $key = 'disable_autotag_edit'; ?>
                                    
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="<?php echo $sit_settings[$key]; ?>" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turns off action copies the image title to the alt field and saves meta data. 
                                    </label>

                                </fieldset>
                                
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                Enable smart tag updater database extension?
                            </th>
                            <td>
                                <fieldset><?php $key = 'enable_smart_tag'; ?>
                                    
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="<?php echo $sit_settings[$key]; ?>" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turn on smart tag updater that updates alt tags if they much shorter and don't contain phrases from the title 
                                    </label>

                                </fieldset>
                                
                            </td>
                        </tr>

                         <tr>
                            <th scope="row">
                                Enable PDF database extension?
                            </th>
                            <td>
                                <fieldset><?php $key = 'enable_pdf'; ?>
                                    
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="<?php echo $sit_settings[$key]; ?>" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turns on extension that automatically copies PDF title to description field and updates meta data.
                                    </label>

                                </fieldset>
                                
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                Enable PDF auto tagging on upload? 
                            </th>
                            <td>
                                <fieldset><?php $key = 'enable_pdf_upload'; ?>
                                    
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turns on automatically coping PDF title to description field on upload.
                                    </label>
                                </fieldset>
                                
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                Enable PDF auto tagging on edit? 
                            </th>
                            <td>
                                <fieldset><?php $key = 'enable_pdf_edit'; ?>
                                    
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turns on automatically copying PDF title to description on edit if title has changed or description is blank.
                                    </label>
                                </fieldset>
                                
                            </td>
                        </tr>

                         

                        <tr>
                            <th scope="row">
                                Enable SEO External Link extension?
                            </th>
                            <td>
                                <fieldset><?php $key = 'enable_seo_links'; ?>
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turns on extension that automatically changes all external links in your site to open in a new tab.
                                    </label>
                                </fieldset>
                                
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                Enable internal PDF exception?
                            </th>
                            <td>
                                <fieldset><?php $key = 'enable_internal_pdf'; ?>
                                    
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turns on exception that automatically changes all internal PDF links to open in a new tab.
                                    </label>
                                </fieldset>
                                
                            </td>
                        </tr>

                    </tbody>
                </table>
                <?php submit_button('Save All Options'); ?>
                <hr>
                <br><br>

        
            </div>
<?php }
}

if( is_admin() )
    $sit = new SitSettings();

