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
                //submit_button( 'Save Settings', 'primary', 'do_this' );
                //wp_nonce_field( array($this, 'yoyo'), 'do_this' );

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
    public function yoyo() {
        echo 'hi';
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
            array( $this, 'sit_info' ), // Callback
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
    public function sit_info() {
        echo 'echo';
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
                <h3><strong>SEO Image Tag Settings</strong></h3>
                <hr>

                <table class="form-table">
                    <tbody>
                        <tr>
                            <?php //$key = 'delete_data'; ?>
                            <th scope="row">
                                Disable Scripts
                            </th>
                            <td>
       
                                <fieldset><?php $key = 'disable_clientside_script'; ?>
                                

                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turn off <b>all</b> SEO JavaScript 
                                    </label>
                                    </fieldset>
                                    <fieldset><?php $key = 'disable_img_tags'; ?>
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turn off image alt tag JavaScript
                                    </label>
                                </fieldset>
                                <fieldset><?php $key = 'disable_add_attach'; ?>
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turn off alt tag updating on media upload
                                    </label>
                                </fieldset>
                                <fieldset><?php $key = 'disable_edit_attach'; ?>
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turn off alt tag updating on media edit
                                    </label>
                                </fieldset>
                            </td>
                        </tr>
                        
                      <tr>
                            <?php //$key = 'delete_data'; ?>
                            <th scope="row">
                                Configure
                            </th>
                            <td>
       
                                <fieldset><?php $key = 'enable_smart_parse'; ?>

                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Make alt tags as readable as possible
                                    </label>
                                    </fieldset>
                                    <fieldset><?php $key = 'tag_prefix'; ?>

                                     <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="text" value="<?php echo $sit_settings[$key]; ?>"/>
                                        Add text to be prefix on all alt tags
                                    </label>
                                    </fieldset>
                                    
                            </td>
                        </tr>
                         <tr>
                            <?php //$key = 'delete_data'; ?>
                            <th scope="row">
                                Form Autofill
                            </th>
                            <td>
       
                                <fieldset><?php $key = 'disable_form_autofill'; ?>
                                

                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turn off autofilling input fields on forms. 
                                    </label>
                                    </fieldset>
                                    <fieldset><?php $key = 'disable_gf_form_autofill'; ?>
                                

                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turn off autofilling inputs on Gravity Forms.
                                    </label>
                                    </fieldset>
                                    
                            </td>
                        </tr>
                        <tr>
                            <?php //$key = 'delete_data'; ?>
                            <th scope="row">
                                Configuration and Mobile
                            </th>
                            <td>
       
                                <fieldset><?php $key = 'enable_mailto_tel'; ?>
                                

                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turn on automatic Tel: and Mailto: tagging
                                    </label>
                                    </fieldset>
                                    <fieldset><?php $key = 'enable_encoding'; ?>
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Turn on email and phone encoding from bots.
                                    </label>
                                </fieldset>
                               
                               
                            </td>
                        </tr>
            
                        <tr>
                            <th scope="row">
                                SEO Extension
                            </th>
                            <td>
                                <fieldset><?php $key = 'enable_seo_links'; ?>
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Open external links in new tab
                                    </label>
                                </fieldset>
                                <fieldset><?php $key = 'enable_pdf_ext'; ?>
                                    
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="checkbox" value="1" <?php checked(1, $sit_settings[$key], true ); ?> />
                                        Open internal PDFs in a new tab
                                    </label>

                                </fieldset>
                                <fieldset><?php $key = 'enable_ext'; ?>
                                    
                                    <label for="sit_settings[<?php echo $key; ?>]">
                                        <input id='sit_settings[<?php echo $key; ?>]' name="sit_settings[<?php echo $key; ?>]" type="text" value="<?php echo $sit_settings[$key]; ?>"/>
                                        Open these extensions in new tab (seperate by comma)
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


